<?php

namespace App\Filament\Resources\Matches;

use App\Filament\Resources\Matches\Pages\CreateMatch;
use App\Filament\Resources\Matches\Pages\EditMatch;
use App\Filament\Resources\Matches\Pages\ListMatches;
use App\Filament\Resources\GameMatches\Schemas\GameMatchForm;
use App\Filament\Resources\GameMatches\Tables\GameMatchesTable;
use App\Models\GameMatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MatchResource extends Resource
{
    protected static ?string $model = GameMatch::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static ?string $modelLabel = 'Pertandingan';
    protected static ?string $pluralModelLabel = 'Pertandingan';

    public static function form(Schema $schema): Schema
    {
        return GameMatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GameMatchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMatches::route('/'),
            'create' => CreateMatch::route('/create'),
            'edit' => EditMatch::route('/{record}/edit'),
        ];
    }
}
