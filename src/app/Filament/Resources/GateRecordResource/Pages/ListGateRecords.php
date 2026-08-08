<?php

namespace App\Filament\Resources\GateRecordResource\Pages;

use App\Filament\Resources\GateRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGateRecords extends ListRecords
{
    protected static string $resource = GateRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
