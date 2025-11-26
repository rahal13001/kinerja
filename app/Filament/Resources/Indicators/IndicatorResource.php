<?php

namespace App\Filament\Resources\Indicators;

use App\Filament\Resources\Indicators\Pages\CreateIndicator;
use App\Filament\Resources\Indicators\Pages\EditIndicator;
use App\Filament\Resources\Indicators\Pages\ListIndicators;
use App\Filament\Resources\Indicators\Pages\ViewIndicator;
use App\Filament\Resources\Indicators\Schemas\IndicatorForm;
use App\Filament\Resources\Indicators\Schemas\IndicatorInfolist;
use App\Filament\Resources\Indicators\Tables\IndicatorsTable;
use App\Models\Indicator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IndicatorResource extends Resource
{
    protected static ?string $model = Indicator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return IndicatorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IndicatorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IndicatorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AchievementsRelationManager::class,
            RelationManagers\ChangesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIndicators::route('/'),
            'create' => CreateIndicator::route('/create'),
            'view' => ViewIndicator::route('/{record}'),
            'edit' => EditIndicator::route('/{record}/edit'),
        ];
    }
}
