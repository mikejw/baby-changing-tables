@extends('layouts.app', ['title' => config('app.name', 'Feeder') . ' — Log a feed'])

@section('content')
    <div class="mx-auto max-w-3xl px-6 py-10 lg:py-16">
        <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Log a feed</h1>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Record everything that happened during this feed.</p>
            </div>

            <a href="{{ route('feeds.index') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] underline underline-offset-4">
                Cancel
            </a>
        </header>

        <form method="POST" action="{{ route('feeds.store') }}" class="space-y-5">
            @csrf

            @include('feeds.form', ['feed' => $feed, 'users' => $users])

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('feeds.index') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] underline underline-offset-4">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-[#1b1b18] dark:bg-[#EDEDEC] px-5 py-2 text-sm font-medium text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors"
                >
                    Save feed
                </button>
            </div>
        </form>
    </div>
@endsection
