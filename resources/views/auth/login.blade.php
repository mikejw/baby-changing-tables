@extends('layouts.app', ['title' => config('app.name', 'Feeder') . ' — Sign in'])

@section('content')
    <div class="flex min-h-screen items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-semibold tracking-tight">{{ config('app.name', 'Feeder') }}</h1>
                <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Sign in to view feed history.</p>
            </div>

            <div class="rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-6 shadow-sm">
                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            autofocus
                            value="{{ old('email') }}"
                            class="block w-full rounded-md border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#0a0a0a] px-3 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] focus:border-[#1b1b18] dark:focus:border-[#EDEDEC] focus:outline-none focus:ring-1 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC]"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="block w-full rounded-md border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#0a0a0a] px-3 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] focus:border-[#1b1b18] dark:focus:border-[#EDEDEC] focus:outline-none focus:ring-1 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC]"
                        >
                    </div>

                    <label class="flex items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-[#19140035] dark:border-[#3E3E3A]">
                        Remember me
                    </label>

                    @if ($errors->any())
                        <div class="rounded-md border border-red-200 dark:border-red-900/50 bg-red-50 dark:bg-red-950/40 px-3 py-2 text-sm text-red-700 dark:text-red-300">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <button
                        type="submit"
                        class="w-full rounded-md bg-[#1b1b18] dark:bg-[#EDEDEC] px-4 py-2 text-sm font-medium text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors"
                    >
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
