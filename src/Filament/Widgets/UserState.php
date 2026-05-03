<?php

namespace FutureX\AppPage\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use FutureX\AppPage\Models\AppPageVisit;
use Illuminate\Support\Facades\DB;

class UserState extends BaseWidget
{
    protected static ?string $heading = 'App Page Analytics';

    protected int|string|array $columnSpan = 'full';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->getQuery())
            ->columns([

                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable(),

                Tables\Columns\TextColumn::make('device')
                    ->label('Device'),

                Tables\Columns\TextColumn::make('visits_count')
                    ->label('Visits'),

                Tables\Columns\TextColumn::make('sessions_count')
                    ->label('Sessions'),

                Tables\Columns\TextColumn::make('total_duration')
                    ->label('Total Time')
                    ->formatStateUsing(fn ($state) => $this->formatDuration($state)),

                Tables\Columns\TextColumn::make('avg_duration')
                    ->label('Avg Time')
                    ->formatStateUsing(fn ($state) => $this->formatDuration($state)),

                Tables\Columns\TextColumn::make('last_visit')
                    ->label('Last Visit')
                    ->dateTime(),

            ])
            ->defaultSort('visits_count', 'desc');
    }

    protected function getQuery(): Builder
    {
        return AppPageVisit::query()
            ->select([
                'country',
                'device',
                DB::raw('COUNT(*) as visits_count'),
                DB::raw('COUNT(DISTINCT session_id) as sessions_count'),
                DB::raw('SUM(duration) as total_duration'),
                DB::raw('AVG(duration) as avg_duration'),
                DB::raw('MAX(created_at) as last_visit'),
            ])
            ->groupBy('country', 'device');
    }
    public function getTableRecordKey($record): string
    {
        return md5($record->country . '-' . $record->device);
    }
    private function formatDuration($seconds): string
    {
        $seconds = (int) $seconds;

        if ($seconds < 60) {
            return $seconds . ' sec';
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes < 60) {
            return $minutes . ' min ' . $remainingSeconds . ' sec';
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        return $hours . ' h ' . $remainingMinutes . ' min';
    }
    protected static ?int $sort = 100;
}
