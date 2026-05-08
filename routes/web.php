<?php

use App\Models\Feed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$feedAttributesFromRequest = function (Request $request): array {
    $validated = $request->validate([
        'cry_level' => ['required', 'integer', 'between:0,10'],
        'temperature' => ['nullable', 'numeric', 'between:30,45'],
        'formula_ounces' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
        'skin_to_skin_minutes' => ['nullable', 'integer', 'min:0', 'max:600'],
        'time_in_sun' => ['nullable', 'integer', 'min:0', 'max:99'],
        'changed_by' => ['nullable', 'integer', 'exists:users,id'],
        'clothes_changed_by' => ['nullable', 'integer', 'exists:users,id'],
        'fed_by' => ['nullable', 'integer', 'exists:users,id'],
        'skin_to_skin_with' => ['nullable', 'integer', 'exists:users,id'],
        'time_in_sun_with' => ['nullable', 'integer', 'exists:users,id'],
        'notes' => ['nullable', 'string', 'max:2000'],
    ]);

    return [
        ...$validated,
        'nappy_wet' => $request->boolean('nappy_wet'),
        'nappy_poo' => $request->boolean('nappy_poo'),
        'breast_fed' => $request->boolean('breast_fed'),
        'change_of_clothes' => $request->boolean('change_of_clothes'),
        'table_wee' => $request->boolean('table_wee'),
        'table_poo' => $request->boolean('table_poo'),
    ];
};

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('feeds.index');
    }

    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()
            ->withErrors(['email' => 'Those credentials don\'t match our records.'])
            ->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended(route('feeds.index'));
})->name('login.attempt');

Route::middleware('auth')->group(function () use ($feedAttributesFromRequest) {
    Route::get('/feeds', function () {
        $feeds = Feed::with(['changedBy', 'clothesChangedBy', 'fedBy', 'skinToSkinWith', 'timeInSunWith'])
            ->latest()
            ->get();

        return view('feeds.index', ['feeds' => $feeds]);
    })->name('feeds.index');

    Route::get('/feeds/create', function () {
        return view('feeds.create', [
            'feed' => new Feed(),
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    })->name('feeds.create');

    Route::post('/feeds', function (Request $request) use ($feedAttributesFromRequest) {
        Feed::create($feedAttributesFromRequest($request));

        return redirect()
            ->route('feeds.index')
            ->with('status', 'Feed logged.');
    })->name('feeds.store');

    Route::get('/feeds/{feed}/edit', function (Feed $feed) {
        return view('feeds.edit', [
            'feed' => $feed,
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    })->name('feeds.edit');

    Route::patch('/feeds/{feed}', function (Request $request, Feed $feed) use ($feedAttributesFromRequest) {
        $feed->update($feedAttributesFromRequest($request));

        return redirect()
            ->route('feeds.index')
            ->with('status', 'Feed updated.');
    })->name('feeds.update');

    Route::delete('/feeds/{feed}', function (Feed $feed) {
        $feed->delete();

        return redirect()
            ->route('feeds.index')
            ->with('status', 'Feed deleted.');
    })->name('feeds.destroy');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
