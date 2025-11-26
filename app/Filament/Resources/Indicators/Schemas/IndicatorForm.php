<?php

namespace App\Filament\Resources\Indicators\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class IndicatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('performance_goal_id')
                    ->options(function () {
                        return \App\Models\PerformanceGoal::with(['changes' => function ($query) {
                            $query->where('status', true)->latest('revision_date');
                        }])->get()->mapWithKeys(function ($record) {
                            $latestChange = $record->changes->first();
                            $label = $latestChange ? $latestChange->revision_name : $record->goal;
                            if ($latestChange) {
                                $label .= " (Original: {$record->goal})";
                            }
                            return [$record->id => $label];
                        });
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('unit')
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
