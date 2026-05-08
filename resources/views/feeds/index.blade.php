@extends('layouts.app', ['title' => config('app.name', 'Feeder') . ' — Feeds'])

@section('content')
    <div class="mx-auto max-w-6xl px-6 py-10 lg:py-16">
        <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Feeds</h1>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    {{ $feeds->count() }} {{ Str::plural('entry', $feeds->count()) }} recorded
                </p>
            </div>

            <div class="flex items-center gap-3 text-sm">
                <span class="text-[#706f6c] dark:text-[#A1A09A]">Hi, <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ auth()->user()->name }}</span></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-md border border-[#19140035] dark:border-[#3E3E3A] px-3 py-1.5 text-sm font-medium hover:border-[#1b1b18] dark:hover:border-[#EDEDEC] transition-colors"
                    >
                        Sign out
                    </button>
                </form>
            </div>
        </header>

        @if ($feeds->isEmpty())
            <div class="rounded-lg border border-dashed border-[#19140035] dark:border-[#3E3E3A] p-10 text-center text-[#706f6c] dark:text-[#A1A09A]">
                No feeds yet. Run <code class="font-mono text-[#1b1b18] dark:text-[#EDEDEC]">php artisan db:seed</code> to add one.
            </div>
        @else
            {{-- Mobile: card list --}}
            <div class="md:hidden space-y-3">
                @foreach ($feeds as $feed)
                    <article class="rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] shadow-sm">
                        <header class="flex items-center justify-between border-b border-[#19140020] dark:border-[#3E3E3A] px-4 py-3">
                            <div>
                                <div class="font-medium">{{ $feed->created_at?->format('M j, Y') }}</div>
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $feed->created_at?->format('H:i') }}</div>
                            </div>
                            <div class="flex flex-wrap justify-end gap-1">
                                @if ($feed->breast_fed)
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">Breast fed</span>
                                @endif
                                @if ($feed->nappy_wet)
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">Wet</span>
                                @endif
                                @if ($feed->nappy_poo)
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">Poo</span>
                                @endif
                            </div>
                        </header>

                        <dl class="divide-y divide-[#19140020] dark:divide-[#3E3E3A] text-sm">
                            @if ($feed->formula_ounces)
                                <div class="flex items-start justify-between gap-4 px-4 py-2">
                                    <dt class="text-[#706f6c] dark:text-[#A1A09A]">Formula</dt>
                                    <dd class="text-right">
                                        <div>{{ number_format((float) $feed->formula_ounces, 2) }} oz</div>
                                        @if ($feed->fedBy)
                                            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">by {{ $feed->fedBy->name }}</div>
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if ($feed->skinToSkinWith)
                                <div class="flex items-start justify-between gap-4 px-4 py-2">
                                    <dt class="text-[#706f6c] dark:text-[#A1A09A]">Skin-to-skin</dt>
                                    <dd class="text-right">
                                        <div>{{ $feed->skin_to_skin_minutes }} min</div>
                                        <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">with {{ $feed->skinToSkinWith->name }}</div>
                                    </dd>
                                </div>
                            @endif

                            @if ((int) $feed->time_in_sun > 0)
                                <div class="flex items-start justify-between gap-4 px-4 py-2">
                                    <dt class="text-[#706f6c] dark:text-[#A1A09A]">Sun</dt>
                                    <dd class="text-right">
                                        <div>{{ (int) $feed->time_in_sun }} min</div>
                                        @if ($feed->timeInSunWith)
                                            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">with {{ $feed->timeInSunWith->name }}</div>
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if ($feed->change_of_clothes)
                                <div class="flex items-start justify-between gap-4 px-4 py-2">
                                    <dt class="text-[#706f6c] dark:text-[#A1A09A]">Change of clothes</dt>
                                    <dd class="text-right">
                                        @if ($feed->changedBy)
                                            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">by {{ $feed->changedBy->name }}</div>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-violet-100 px-2 py-0.5 text-xs font-medium text-violet-800 dark:bg-violet-900/40 dark:text-violet-200">Yes</span>
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            <div class="flex items-start justify-between gap-4 px-4 py-2">
                                <dt class="text-[#706f6c] dark:text-[#A1A09A]">Cry level</dt>
                                <dd>{{ $feed->cry_level }} / 10</dd>
                            </div>

                            @if ($feed->temperature)
                                <div class="flex items-start justify-between gap-4 px-4 py-2">
                                    <dt class="text-[#706f6c] dark:text-[#A1A09A]">Temperature</dt>
                                    <dd>{{ number_format((float) $feed->temperature, 2) }} &deg;C</dd>
                                </div>
                            @endif

                            @if ($feed->table_wee || $feed->table_poo)
                                <div class="flex items-start justify-between gap-4 px-4 py-2">
                                    <dt class="text-[#706f6c] dark:text-[#A1A09A]">Other</dt>
                                    <dd class="flex flex-wrap justify-end gap-1">
                                        @if ($feed->table_wee)
                                            <span class="inline-flex items-center rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-800 dark:bg-sky-900/40 dark:text-sky-200">Table wee</span>
                                        @endif
                                        @if ($feed->table_poo)
                                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900/40 dark:text-orange-200">Table poo</span>
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if ($feed->notes)
                                <div class="px-4 py-2">
                                    <dt class="mb-1 text-[#706f6c] dark:text-[#A1A09A]">Notes</dt>
                                    <dd>{{ $feed->notes }}</dd>
                                </div>
                            @endif
                        </dl>
                    </article>
                @endforeach
            </div>

            {{-- Tablet & desktop: scrollable table with sticky header --}}
            <div class="hidden md:block max-h-[calc(100vh-12rem)] overflow-auto rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] shadow-sm">
                <table class="min-w-full text-left text-sm">
                    <thead class="sticky top-0 z-10 bg-[#FDFDFC] dark:bg-[#1b1b1a] text-xs uppercase tracking-wider text-[#706f6c] dark:text-[#A1A09A] shadow-[inset_0_-1px_0_#19140020] dark:shadow-[inset_0_-1px_0_#3E3E3A]">
                        <tr>
                            <th class="px-4 py-3">When</th>
                            <th class="px-4 py-3">Nappy</th>
                            <th class="px-4 py-3">Breast fed</th>
                            <th class="px-4 py-3">Formula (oz)</th>
                            <th class="px-4 py-3">Fed by</th>
                            <th class="px-4 py-3">Changed by</th>
                            <th class="px-4 py-3">Skin-to-skin</th>
                            <th class="px-4 py-3">Cry</th>
                            <th class="px-4 py-3">Temp (&deg;C)</th>
                            <th class="px-4 py-3">Sun</th>
                            <th class="px-4 py-3">Other</th>
                            <th class="px-4 py-3">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#19140020] dark:divide-[#3E3E3A]">
                        @foreach ($feeds as $feed)
                            <tr class="hover:bg-[#FDFDFC] dark:hover:bg-[#1b1b1a]">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="font-medium">{{ $feed->created_at?->format('M j, Y') }}</div>
                                    <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $feed->created_at?->format('H:i') }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if ($feed->nappy_wet)
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">Wet</span>
                                        @endif
                                        @if ($feed->nappy_poo)
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">Poo</span>
                                        @endif
                                        @if (! $feed->nappy_wet && ! $feed->nappy_poo)
                                            <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">&mdash;</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($feed->breast_fed)
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">Yes</span>
                                    @else
                                        <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $feed->formula_ounces ? number_format((float) $feed->formula_ounces, 2) : '—' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $feed->fedBy?->name ?? '—' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $feed->changedBy?->name ?? '—' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ($feed->skinToSkinWith)
                                        <div>{{ $feed->skinToSkinWith->name }}</div>
                                        <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $feed->skin_to_skin_minutes }} min</div>
                                    @else
                                        <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $feed->cry_level }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $feed->temperature ? number_format((float) $feed->temperature, 2) : '—' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ((int) $feed->time_in_sun > 0)
                                        <div>{{ (int) $feed->time_in_sun }} min</div>
                                        @if ($feed->timeInSunWith)
                                            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">with {{ $feed->timeInSunWith->name }}</div>
                                        @endif
                                    @else
                                        <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if ($feed->change_of_clothes)
                                            <span class="inline-flex items-center rounded-full bg-violet-100 px-2 py-0.5 text-xs font-medium text-violet-800 dark:bg-violet-900/40 dark:text-violet-200">Clothes</span>
                                        @endif
                                        @if ($feed->table_wee)
                                            <span class="inline-flex items-center rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-800 dark:bg-sky-900/40 dark:text-sky-200">Table wee</span>
                                        @endif
                                        @if ($feed->table_poo)
                                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900/40 dark:text-orange-200">Table poo</span>
                                        @endif
                                        @if (! $feed->change_of_clothes && ! $feed->table_wee && ! $feed->table_poo)
                                            <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">&mdash;</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 max-w-xs">
                                    <span class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $feed->notes ?: '—' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
