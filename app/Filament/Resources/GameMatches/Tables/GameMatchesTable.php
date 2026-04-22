<?php

namespace App\Filament\Resources\GameMatches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GameMatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('booking_id')
                    ->label('Booking')
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label('Creator')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('total_players')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price_per_person')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gender_preference')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('gender_preference')
                    ->options([
                        'mixed' => 'Mixed',
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'full' => 'Full',
                        'finished' => 'Finished',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
