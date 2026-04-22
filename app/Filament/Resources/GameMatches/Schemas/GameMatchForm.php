<?php

namespace App\Filament\Resources\GameMatches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GameMatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_id')
                    ->relationship('booking', 'id')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('creator_id')
                    ->relationship('creator', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->maxLength(255),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('total_players')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('price_per_person')
                    ->numeric()
                    ->minValue(0),
                Select::make('gender_preference')
                    ->options([
                        'mixed' => 'Mixed',
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->required()
                    ->default('mixed'),
                Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'full' => 'Full',
                        'finished' => 'Finished',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('open'),
            ]);
    }
}
