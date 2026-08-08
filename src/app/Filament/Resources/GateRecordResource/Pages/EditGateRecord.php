<?php

namespace App\Filament\Resources\GateRecordResource\Pages;

use App\Filament\Resources\GateRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGateRecord extends EditRecord
{
    protected static string $resource = GateRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
