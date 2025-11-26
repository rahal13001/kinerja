<?php

namespace App\Filament\Resources\PerformanceGoals;

use App\Filament\Resources\PerformanceGoals\Pages\CreatePerformanceGoal;
use App\Filament\Resources\PerformanceGoals\Pages\EditPerformanceGoal;
use App\Filament\Resources\PerformanceGoals\Pages\ListPerformanceGoals;
use App\Filament\Resources\PerformanceGoals\Pages\ViewPerformanceGoal;
use App\Filament\Resources\PerformanceGoals\Schemas\PerformanceGoalForm;
use App\Filament\Resources\PerformanceGoals\Schemas\PerformanceGoalInfolist;
use App\Filament\Resources\PerformanceGoals\Tables\PerformanceGoalsTable;
use App\Models\PerformanceGoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PerformanceGoalResource extends Resource
{
    protected static ?string $model = PerformanceGoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'goal';

    public static function form(Schema $schema): Schema
    {
        return PerformanceGoalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PerformanceGoalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerformanceGoalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\IndicatorsRelationManager::class,
            RelationManagers\ChangesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPerformanceGoals::route('/'),
            'create' => CreatePerformanceGoal::route('/create'),
            'view' => ViewPerformanceGoal::route('/{record}'),
            'edit' => EditPerformanceGoal::route('/{record}/edit'),
        ];
    }
}
