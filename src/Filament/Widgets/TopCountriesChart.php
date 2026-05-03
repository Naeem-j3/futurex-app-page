<?php

namespace FutureX\AppPage\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use FutureX\AppPage\Models\AppPageVisit;

class TopCountriesChart extends ChartWidget
{
    protected static ?string $heading   = 'Top 5 Countries';
    protected static ?string $maxHeight = '280px';
    protected static ?int    $sort      = 5;

    protected function getData(): array
    {
        $data = AppPageVisit::selectRaw('country, COUNT(*) as count')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return [
            'datasets' => [[
                'label'           => 'Visitors',
                'data'            => $data->pluck('count')->toArray(),
                'backgroundColor' => 'rgba(99,102,241,0.8)',
                'borderColor'     => 'rgba(99,102,241,1)',
                'borderWidth'     => 1,
                'borderRadius'    => 6,
                'hoverBackgroundColor' => 'rgba(99,102,241,1)',
            ]],
            'labels' => $data->pluck('country')->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins'   => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(156,163,175,0.1)'],
                    'ticks'       => ['precision' => 0],
                ],
                'y' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
