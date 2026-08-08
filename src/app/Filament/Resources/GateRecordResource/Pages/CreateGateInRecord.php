<?php

namespace App\Filament\Resources\GateRecordResource\Pages;

use App\Filament\Resources\GateRecordResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateGateRecord extends CreateRecord
{
    protected static string $resource = GateRecordResource::class;

    // Force this page to register directly in the navigation sidebar
    protected static bool $shouldRegisterNavigation = true;

    // Sidebar Navigation Settings
    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-on-rectangle';
    protected static ?string $navigationGroup = 'Gate Operations';
    protected static ?string $navigationLabel = 'Vehicle Gate In';
    protected static ?int $navigationSort = 1;

    /**
     * Set the title displayed at the top of the form page.
     */
    public function getTitle(): string
    {
        return 'Vehicle Gate In';
    }

    /**
     * Requirement B: Automatically capture Date & Time In, Status,
     * and the authenticated user creating the gate record before saving.
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status']               = 'GATED_IN';
        $data['date_time_in']        = now();
        $data['gated_in_by_user_id'] = Auth::id();

        return $data;
    }

    /**
     * Redirect to the list view after creating the gate in entry.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}