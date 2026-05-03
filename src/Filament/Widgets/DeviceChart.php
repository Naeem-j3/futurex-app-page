<?php

namespace FutureX\AppPage\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use FutureX\AppPage\Models\AppPageVisit;

class DeviceChart extends ChartWidget
{
    protected static ?string $heading   = 'Visitors by Device';
    protected static ?string $maxHeight = '280px';
    protected static ?int    $sort      = 4;

    protected function getData(): array
    {
        $data = AppPageVisit::selectRaw('device, COUNT(*) as count')
            ->groupBy('device')
            ->get();

        $colors = [
            'mobile'  => 'rgba(16,185,129,0.85)',
            'desktop' => 'rgba(99,102,241,0.85)',
            'tablet'  => 'rgba(245,158,11,0.85)',
        ];

        $bgColors = $data->map(fn($row) =>
            $colors[strtolower($row->device)] ?? 'rgba(156,163,175,0.85)'
        )->toArray();

        return [
            'datasets' => [[
                'label'           => 'Devices',
                'data'            => $data->pluck('count')->toArray(),
                'backgroundColor' => $bgColors,
                'borderWidth'     => 2,
                'borderColor'     => '#ffffff',
                'hoverOffset'     => 6,
            ]],
            'labels' => $data->pluck('device')->map(fn($d) => ucfirst($d))->toArray(),
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
