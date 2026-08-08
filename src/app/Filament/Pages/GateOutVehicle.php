<?php

namespace App\Filament\Pages;

use App\Models\GateRecord;
use App\Models\Vehicle;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class GateOutVehicle extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.gate-out-vehicle';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-on-rectangle';
    protected static ?string $navigationGroup = 'Gate Operations';
    protected static ?string $navigationLabel = 'Vehicle Gate Out';
    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Vehicle Gate Out Screen')
                    ->description('Select a currently gated-in vehicle to view driver details and record exit.')
                    ->schema([
                        // 1. Display ONLY vehicles currently "Gated In"
                        Select::make('vehicle_id')
                            ->label('Vehicle Number')
                            ->options(function () {
                                return Vehicle::whereHas('gateRecords', function ($query) {
                                    $query->where('status', 'GATED_IN');
                                })->pluck('registration_number', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (! $state) {
                                    $set('driver_name', null);
                                    $set('driver_id_number', null);
                                    $set('phone_number', null);
                                    $set('gate_record_id', null);
                                    return;
                                }

                                // 2. Auto-populate Driver Name, ID, Phone Number, and Gate Record reference
                                $record = GateRecord::where('vehicle_id', $state)
                                    ->where('status', 'GATED_IN')
                                    ->latest()
                                    ->with('driver')
                                    ->first();

                                if ($record && $record->driver) {
                                    $set('driver_name', $record->driver->name);
                                    $set('driver_id_number', $record->driver->driver_id);
                                    $set('phone_number', $record->driver->phone_number);
                                    $set('gate_record_id', $record->id);
                                } else {
                                    $set('driver_name', null);
                                    $set('driver_id_number', null);
                                    $set('phone_number', null);
                                    $set('gate_record_id', null);
                                }
                            }),

                        Hidden::make('gate_record_id')
                            ->required(),

                        // Auto-populated fields (Disabled & Non-Dehydrated)
                        TextInput::make('driver_name')
                            ->label('Driver Name')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('driver_id_number')
                            ->label('Driver ID')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $formData = $this->form->getState();

        // 3. Automatically capture Date & Time Out, Gated Out User ID, and change status to GATED_OUT
        $gateRecord = GateRecord::findOrFail($formData['gate_record_id']);

        $gateRecord->update([
            'status'               => 'GATED_OUT',
            'date_time_out'        => now(),
            'gated_out_by_user_id' => Auth::id(),
        ]);

        Notification::make()
            ->title('Vehicle Gated Out Successfully')
            ->success()
            ->send();

        $this->form->fill();
    }
}