<?php

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/feeds', function () {
        $feeds = Feed::with(['changedBy', 'fedBy', 'skinToSkinWith', 'timeInSunWith'])
            ->latest()
            ->get();

        return view('feeds.index', ['feeds' => $feeds]);
    })->name('feeds.index');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
