<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('field.name')
                    ->label('Field')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('timeSlot.id')
                    ->label('Time Slot')
                    ->sortable(),

                TextColumn::make('timeSlot.date')
                    ->date()
                    ->sortable(),

                TextColumn::make('timeSlot.start_time')
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('timeSlot.end_time')
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                        
                IconColumn::make('is_public_match')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])

            ->filters([
                // 🔥 TABS STYLE FILTER
                Tables\Filters\Filter::make('scheduled')
                    ->label('Terjadwal')
                    ->query(fn ($query) => $query->where('status', 'pending')),

                Tables\Filters\Filter::make('ongoing')
                    ->label('Berlangsung')
                    ->query(fn ($query) => $query->where('status', 'confirmed')),

                Tables\Filters\Filter::make('done')
                    ->label('Selesai')
                    ->query(fn ($query) => $query->where('status', 'completed')),

                Tables\Filters\Filter::make('cancelled')
                    ->label('Dibatalkan')
                    ->query(fn ($query) => $query->where('status', 'cancelled')),

                // 🔧 FILTER TAMBAHAN (BIAR TETAP ADA)
                TernaryFilter::make('is_public_match')
                    ->label('Public Match'),
            ])

            ->filtersLayout(FiltersLayout::AboveContent)

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