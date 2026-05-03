<?php

namespace FutureX\AppPage\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use FutureX\AppPage\Models\AppPageVisit;
use Illuminate\Support\Carbon;

class AppPageVisitsChart extends ChartWidget
{
    protected static ?string $heading   = 'Visits Over Time';
    protected static ?string $maxHeight = '280px';
    protected static ?int    $sort      = 2;

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7'  => 'Last 7 days',
            '14' => 'Last 14 days',
            '30' => 'Last 30 days',
        ];
    }

    protected function getData(): array
    {
        $days = (int) $this->filter;

        $raw = AppPageVisit::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $labels = [];
        $counts = [];

        for ($i = $days; $i >= 0; $i--) {
            $date     = now()->subDays($i)->toDateString();
            $labels[] = Carbon::parse($date)->format('M d');
            $counts[] = $raw[$date] ?? 0;
        }

        return [
            'datasets' => [[
                'label'                     => 'Visits',
                'data'                      => $counts,
                'borderColor'               => 'rgba(99, 102, 241, 1)',
                'backgroundColor'           => 'rgba(99, 102, 241, 0.1)',
                'fill'                      => true,
                'tension'                   => 0.4,
                'pointBackgroundColor'      => 'rgba(99, 102, 241, 1)',
                'pointRadius'               => 4,
                'pointHoverRadius'          => 6,
            ]],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => ['mode' => 'index', 'intersect' => false],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(156,163,175,0.1)'],
                    'ticks'       => ['precision' => 0],
                ],
                'x' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
