<?php

namespace FutureX\AppPage\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use FutureX\AppPage\Models\AppPageClick;

class ClicksChart extends ChartWidget
{
    protected static ?string $heading   = 'Clicks by Type';
    protected static ?string $maxHeight = '280px';
    protected static ?int    $sort      = 3;

    protected function getData(): array
    {
        $data = AppPageClick::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get();

        $palette = [
            'rgba(99,102,241,0.85)',
            'rgba(16,185,129,0.85)',
            'rgba(245,158,11,0.85)',
            'rgba(239,68,68,0.85)',
            'rgba(59,130,246,0.85)',
            'rgba(168,85,247,0.85)',
        ];

        return [
            'datasets' => [[
                'label'           => 'Clicks',
                'data'            => $data->pluck('count')->toArray(),
                'backgroundColor' => array_slice($palette, 0, $data->count()),
                'borderWidth'     => 2,
                'borderColor'     => '#ffffff',
                'hoverOffset'     => 6,
            ]],
            'labels' => $data->pluck('type')->map(fn($t) => ucfirst($t))->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels'   => ['padding' => 16, 'usePointStyle' => true],
                ],
            ],
            'cutout' => '65%',
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
