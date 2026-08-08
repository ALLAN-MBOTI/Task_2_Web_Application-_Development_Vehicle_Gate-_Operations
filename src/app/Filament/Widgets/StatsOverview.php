<?php

namespace App\Filament\Widgets;

use App\Models\Driver;
use App\Models\GateRecord;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Vehicles', Vehicle::count())
                ->description('Registered vehicles in system')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Total Employees / Drivers', Driver::count())
                ->description('Registered drivers')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Vehicles Currently In', GateRecord::where('status', 'GATED_IN')->count())
                ->description('Active inside premises')
                ->descriptionIcon('heroicon-m-arrow-left-on-rectangle')
                ->color('warning'),

            Stat::make('Vehicles Gated Out', GateRecord::where('status', 'GATED_OUT')->count())
                ->description('Completed exits')
                ->descriptionIcon('heroicon-m-arrow-right-on-rectangle')
                ->color('success'),
        ];
    }
}