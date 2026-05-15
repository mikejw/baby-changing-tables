<?php
namespace App\Support;
use Carbon\Carbon;
use Illuminate\Support\Collection;
class FeedWidgetStats
{
    public function __construct(
        private Collection $feeds,
        private int $days = 7,
    ) {}
    public function averages(): array
    {
        $tz = config('app.timezone');
        $start = now($tz)->subDays($this->days - 1)->startOfDay();
        $end = now($tz)->endOfDay();
        // Calendar days in range (so empty days count as 0 for poo/wee)
        $period = collect();
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $period->push($d->toDateString());
        }
        $byDay = $this->feeds
            ->filter(fn ($feed) => $feed->created_at?->between($start, $end))
            ->groupBy(fn ($feed) => $feed->created_at->timezone($tz)->toDateString());
        $dailyPoos = $period->map(fn (string $date) =>
            ($byDay->get($date) ?? collect())->sum(fn ($f) =>
                (int) $f->nappy_poo + (int) $f->table_poo
            )
        );
        $dailyWeees = $period->map(fn (string $date) =>
            ($byDay->get($date) ?? collect())->sum(fn ($f) =>
                (int) $f->nappy_wet + (int) $f->table_wee
            )
        );
        $dailyFormulaOz = $period->map(fn (string $date) =>
            ($byDay->get($date) ?? collect())->sum(fn ($f) =>
                $f->formula_ounces ? (float) $f->formula_ounces : 0.0
            )
        );
        $formulaDays = $dailyFormulaOz->filter(fn (float $oz) => $oz > 0);
        return [
            'windowDays' => $this->days,
            'avgPoosPerDay' => round($dailyPoos->avg() ?? 0, 1),
            'avgWeeesPerDay' => round($dailyWeees->avg() ?? 0, 1),
            'avgDailyFormulaOz' => $formulaDays->isNotEmpty()
                ? round($formulaDays->avg(), 1)
                : null,
            'daysWithFormula' => $formulaDays->count(),
            'daysInWindow' => $period->count(),
        ];
    }
}