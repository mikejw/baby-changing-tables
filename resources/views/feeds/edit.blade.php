@extends('layouts.app', ['title' => config('app.name', 'Feeder') . ' — Edit feed'])

@section('content')
    <div class="mx-auto max-w-3xl px-6 py-10 lg:py-16">
        <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Edit feed</h1>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Logged {{ $feed->created_at?->format('M j, Y \a\t H:i') }}
                </p>
            </div>

            <a href="{{ route('feeds.index') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] underline underline-offset-4">
                Back to feeds
            </a>
        </header>

        <form method="POST" action="{{ route('feeds.update', $feed) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            @include('feeds.form', ['feed' => $feed, 'users' => $users])

            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                <button
                    type="submit"
                    form="feed-delete"
                    class="text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 underline underline-offset-4"
                >
                    Delete this feed
                </button>

                <div class="flex items-center gap-3">
                    <a href="{{ route('feeds.index') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] underline underline-offset-4">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="rounded-md bg-[#1b1b18] dark:bg-[#EDEDEC] px-5 py-2 text-sm font-medium text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </form>

        <form id="feed-delete" method="POST" action="{{ route('feeds.destroy', $feed) }}" onsubmit="return confirm('Delete this feed? This cannot be undone.')">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
