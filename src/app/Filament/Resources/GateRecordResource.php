<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GateRecordResource\Pages;
use App\Models\Driver;
use App\Models\GateRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Filament Resource for handling Gate Records and Requirement B (Vehicle Gate In Screen).
 */
class GateRecordResource extends Resource
{
    protected static ?string $model = GateRecord::class;
// 1. Force this specific page to appear in the sidebar
    protected static bool $shouldRegisterNavigation = true;

    // Update these 4 properties:
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Gate Operations';
    protected static ?string $navigationLabel = 'Gate History Logs';
    protected static ?int $navigationSort = 3;
    /**
     * Requirement B: Vehicle Gate In Screen Form Schema.
     * Contains only Vehicle Number, Driver Name, Driver ID, and Phone Number.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Vehicle Gate In Screen')
                    ->description('Record vehicle entry by selecting the vehicle plate and driver details.')
                    ->schema([
                        /*
                         * Requirement B: Vehicle Number (Searchable Dropdown)
                         */
                        Forms\Components\Select::make('vehicle_id')
                            ->label('Vehicle Number')
                            ->relationship('vehicle', 'registration_number')
                            ->searchable()
                            ->preload()
                            ->required(),

                        /*
                         * Requirement B: Driver Name (Searchable Dropdown)
                         * Triggers dynamic auto-population of Driver ID and Phone Number.
                         */
                        Forms\Components\Select::make('driver_id')
                            ->label('Driver Name')
                            ->relationship('driver', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if ($state) {
                                    $driver = Driver::find($state);
                                    if ($driver) {
                                        $set('driver_id_number', $driver->driver_id);
                                        $set('phone_number', $driver->phone_number);
                                    }
                                } else {
                                    $set('driver_id_number', null);
                                    $set('phone_number', null);
                                }
                            }),

                        /*
                         * Requirement B: Driver ID (Auto-populated, read-only)
                         */
                        Forms\Components\TextInput::make('driver_id_number')
                            ->label('Driver ID')
                            ->disabled()
                            ->dehydrated(false),

                        /*
                         * Requirement B: Phone Number (Auto-populated, read-only)
                         */
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicle.registration_number')
                    ->label('Vehicle Plate')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('driver.name')
                    ->label('Driver Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('driver.driver_id')
                    ->label('Driver ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('driver.phone_number')
                    ->label('Phone Number')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Current Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'GATED_IN'  => 'success',
                        'GATED_OUT' => 'danger',
                        default     => 'gray',
                    }),

                Tables\Columns\TextColumn::make('date_time_in')
                    ->label('Time In')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_time_out')
                    ->label('Time Out')
                    ->dateTime('d M Y, h:i A')
                    ->placeholder('Still On Site'),

                Tables\Columns\TextColumn::make('gatedInUser.name')
                    ->label('Gated In By'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGateRecords::route('/'),
            'create' => Pages\CreateGateRecord::route('/create'),
            'edit'   => Pages\EditGateRecord::route('/{record}/edit'),
        ];
    }
}