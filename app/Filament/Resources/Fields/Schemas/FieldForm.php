<?php

namespace App\Filament\Resources\Fields\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FieldForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sport_type')
                    ->maxLength(100),
                TextInput::make('price_per_hour')
                    ->numeric()
                    ->required()
                    ->minValue(0),
                TextInput::make('capacity')
                    ->numeric()
                    ->minValue(0),
                Toggle::make('is_indoor')
                    ->default(false),
            ]);
    }
}
