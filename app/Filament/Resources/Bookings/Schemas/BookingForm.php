<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('field_id')
                    ->relationship('field', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('time_slot_id')
                    ->relationship('timeSlot', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record): string => sprintf(
                        '#%d - %s (%s - %s)',
                        $record->id,
                        $record->date?->format('Y-m-d') ?? '-',
                        $record->start_time,
                        $record->end_time,
                    ))
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('total_price')
                    ->numeric()
                    ->required()
                    ->minValue(0),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),
                Toggle::make('is_public_match')
                    ->default(false),
            ]);
    }
}
