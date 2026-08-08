<?php

namespace App\Filament\Widgets;

use App\Models\GateRecord;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class GateOperationsChart extends ChartWidget
{
    protected static ?string $heading = 'Gate Operations Traffic (Last 7 Days)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo)->format('Y-m-d'));

        $gatedInCounts = $days->map(function ($date) {
            return GateRecord::whereDate('date_time_in', $date)->count();
        });

        $gatedOutCounts = $days->map(function ($date) {
            return GateRecord::where('status', 'GATED_OUT')
                ->whereDate('date_time_out', $date)
                ->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Vehicles Gated In',
                    'data' => $gatedInCounts->toArray(),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Vehicles Gated Out',
                    'data' => $gatedOutCounts->toArray(),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $days->map(fn ($date) => Carbon::parse($date)->format('D, M j'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}