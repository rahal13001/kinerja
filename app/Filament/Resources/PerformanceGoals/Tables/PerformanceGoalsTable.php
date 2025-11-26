<?php

namespace App\Filament\Resources\PerformanceGoals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PerformanceGoalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('goal')
                    ->label('Goal')
                    ->formatStateUsing(function ($state, \App\Models\PerformanceGoal $record) {
                        $latestChange = $record->changes()->where('status', true)->latest('revision_date')->first();
                        return $latestChange ? $latestChange->revision_name : $state;
                    })
                    ->description(function (\App\Models\PerformanceGoal $record) {
                        $latestChange = $record->changes()->where('status', true)->latest('revision_date')->first();
                        return $latestChange ? 'Original: ' . $record->goal : null;
                    })
                    ->searchable(query: function (\Illuminate\Database\Eloquent\Builder $query, string $search): \Illuminate\Database\Eloquent\Builder {
                        return $query
                            ->where('goal', 'like', "%{$search}%")
                            ->orWhereHas('changes', function ($query) use ($search) {
                                $query->where('revision_name', 'like', "%{$search}%");
                            });
                    })
                    ->sortable(),
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
