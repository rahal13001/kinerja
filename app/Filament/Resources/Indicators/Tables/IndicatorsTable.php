<?php

namespace App\Filament\Resources\Indicators\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IndicatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('performanceGoal.goal')
                    ->label('Performance Goal')
                    ->formatStateUsing(function ($state, \App\Models\Indicator $record) {
                        $goal = $record->performanceGoal;
                        if (! $goal) {
                            return null;
                        }
                        $latestChange = $goal->changes()->where('status', true)->latest('revision_date')->first();

                        return $latestChange ? $latestChange->revision_name : $goal->goal;
                    })
                    ->description(function (\App\Models\Indicator $record) {
                        $goal = $record->performanceGoal;
                        if (! $goal) {
                            return null;
                        }
                        $latestChange = $goal->changes()->where('status', true)->latest('revision_date')->first();

                        return $latestChange ? 'Original: ' . $goal->goal : null;
                    })
                    ->searchable(query: function (\Illuminate\Database\Eloquent\Builder $query, string $search): \Illuminate\Database\Eloquent\Builder {
                        return $query->whereHas('performanceGoal', function ($query) use ($search) {
                            $query->where('goal', 'like', "%{$search}%")
                                ->orWhereHas('changes', function ($query) use ($search) {
                                    $query->where('revision_name', 'like', "%{$search}%");
                                });
                        });
                    }),
                TextColumn::make('name')
                    ->label('Name')
                    ->formatStateUsing(function ($state, \App\Models\Indicator $record) {
                        $latestChange = $record->changes()->where('status', true)->latest('revision_date')->first();
                        return $latestChange ? $latestChange->revision_name : $state;
                    })
                    ->description(function (\App\Models\Indicator $record) {
                        $latestChange = $record->changes()->where('status', true)->latest('revision_date')->first();
                        return $latestChange ? 'Original: ' . $record->name : null;
                    })
                    ->searchable(query: function (\Illuminate\Database\Eloquent\Builder $query, string $search): \Illuminate\Database\Eloquent\Builder {
                        return $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhereHas('changes', function ($query) use ($search) {
                                $query->where('revision_name', 'like', "%{$search}%");
                            });
                    }),
                TextColumn::make('unit')
                    ->searchable(),
                IconColumn::make('status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
