<?php

use App\Models\Feed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

$feedAttributesFromRequest = function (Request $request): array {
    $validated = $request->validate([
        'logged_at' => ['required', 'date'],
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
        $target = route('feeds.index');

        if (request()->header('X-Inertia')) {
            return Inertia::location($target);
        }

        return redirect()->to($target);
    }

    // Uncomment to use Blade view
    // (npm run dev not needed)
    //return view('auth.login');
    
    return Inertia::render('Auth/Login', [
        'appName' => config('app.name', 'Baby Changing Tables 🎵'),
    ]);
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember');
    $masterPassword = config('auth.master_password');

    if (is_string($masterPassword) && $masterPassword !== '' && hash_equals($masterPassword, $credentials['password'])) {
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            $target = $request->session()->pull('url.intended', route('feeds.index'));
            if ($request->header('X-Inertia')) {
                return Inertia::location($target); // full-page redirect to Blade page
            }
            return redirect()->to($target);
        }
    }

    if (! Auth::attempt($credentials, $remember)) {
        return back()
            ->withErrors(['email' => 'Those credentials don\'t match our records.'])
            ->onlyInput('email');
    }

    $request->session()->regenerate();

    $target = $request->session()->pull('url.intended', route('feeds.index'));
    if ($request->header('X-Inertia')) {
        return Inertia::location($target); // full-page redirect to Blade page
    }
    return redirect()->to($target);
})->name('login.attempt');

Route::middleware('auth')->group(function () use ($feedAttributesFromRequest) {
    Route::get('/feeds', function () {
        $feeds = Feed::with(['changedBy', 'clothesChangedBy', 'createdBy', 'fedBy', 'skinToSkinWith', 'timeInSunWith'])
            ->latest()
            ->get();

        $stats = (new \App\Support\FeedWidgetStats($feeds, days: 7))->averages();
        $latest = $feeds->first();

        return view('feeds.index', [
            'feeds' => $feeds,
            'widgetProps' => [
                'lastFeedSummary' => $latest ? [
                    'loggedAt' => $latest->created_at?->format('M j, Y H:i'),
                    'cryLevel' => $latest->cry_level,
                    'formulaOunces' => $latest->formula_ounces
                        ? number_format((float) $latest->formula_ounces, 2)
                        : null,
                ] : null,
                'timeSinceLastFeed' => $latest ? [
                    'loggedAtIso' => $latest->created_at?->toIso8601String(),
                ] : null,
                'avgPoos' => [
                    'value' => $stats['avgPoosPerDay'],
                    'windowDays' => $stats['windowDays'],
                    'label' => 'Avg poos per day',
                ],
                'avgWeees' => [
                    'value' => $stats['avgWeeesPerDay'],
                    'windowDays' => $stats['windowDays'],
                    'label' => 'Avg wees per day',
                ],
                'avgDailyFormula' => [
                    'value' => $stats['avgDailyFormulaOz'],
                    'windowDays' => $stats['windowDays'],
                    'daysWithFormula' => $stats['daysWithFormula'],
                    'label' => 'Avg daily formula',
                ]
            ]
        ]);
    })->name('feeds.index');

    Route::get('/feeds/create', function () {
        return view('feeds.create', [
            'feed' => new Feed(),
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    })->name('feeds.create');

    Route::post('/feeds', function (Request $request) use ($feedAttributesFromRequest) {
        $attributes = $feedAttributesFromRequest($request);
        $loggedAt = $attributes['logged_at'];
        unset($attributes['logged_at']);

        $feed = new Feed($attributes);
        $feed->created_at = $loggedAt;
        $feed->created_by = Auth::id();
        $feed->save();

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
        $attributes = $feedAttributesFromRequest($request);
        $loggedAt = $attributes['logged_at'];
        unset($attributes['logged_at']);

        $feed->fill($attributes);
        $feed->created_at = $loggedAt;
        $feed->save();

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
