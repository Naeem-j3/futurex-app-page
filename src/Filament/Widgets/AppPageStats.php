<?php

namespace FutureX\AppPage\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use FutureX\AppPage\Models\AppPageVisit;
use FutureX\AppPage\Models\AppPageClick;

class AppPageStats extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static string $view = 'filament-widgets::stats-overview-widget';

    protected function getStats(): array
    {
        $totalVisits      = AppPageVisit::count();
        $todayVisits      = AppPageVisit::whereDate('created_at', now())->count();
        $yesterdayVisits  = AppPageVisit::whereDate('created_at', now()->subDay())->count();
        $totalClicks      = AppPageClick::count();
        $googleClicks     = AppPageClick::where('type', 'google')->count();

        $visitTrend = $this->getTrend(AppPageVisit::class, 7);
        $clickTrend = $this->getTrend(AppPageClick::class, 7);

        $todayChange = $yesterdayVisits > 0
            ? round((($todayVisits - $yesterdayVisits) / $yesterdayVisits) * 100)
            : 100;

        $googleRate = $totalClicks > 0
            ? round(($googleClicks / $totalClicks) * 100)
            : 0;

        return [
            Stat::make('Total Visits', number_format($totalVisits))
                ->description('All time page visits')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->chart($visitTrend)
                ->color('info'),

            Stat::make('Today\'s Visits', number_format($todayVisits))
                ->description($todayChange >= 0
                    ? "{$todayChange}% more than yesterday"
                    : abs($todayChange) . "% less than yesterday")
                ->descriptionIcon($todayChange >= 0
                    ? 'heroicon-m-arrow-trending-up'
                    : 'heroicon-m-arrow-trending-down')
                ->chart($visitTrend)
                ->color($todayChange >= 0 ? 'success' : 'danger'),

            Stat::make('Total Clicks', number_format($totalClicks))
                ->description('All button & link clicks')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->chart($clickTrend)
                ->color('warning'),

            Stat::make('Google Clicks', number_format($googleClicks))
                ->description("{$googleRate}% of total clicks")
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->chart($clickTrend)
                ->color('success'),
        ];
    }

    private function getTrend(string $model, int $days): array
    {
        $data = [];
        for ($i = $days; $i >= 0; $i--) {
            $data[] = $model::whereDate('created_at', now()->subDays($i))->count();
        }
        return $data;
    }
}
