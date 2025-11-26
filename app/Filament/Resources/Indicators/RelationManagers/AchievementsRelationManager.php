<?php

namespace App\Filament\Resources\Indicators\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AchievementsRelationManager extends RelationManager
{
    protected static string $relationship = 'achievements';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->required(),
                TextInput::make('target_q1')
                    ->numeric(),
                TextInput::make('target_q2')
                    ->numeric(),
                TextInput::make('target_q3')
                    ->numeric(),
                TextInput::make('target_q4')
                    ->numeric(),
                TextInput::make('achievement_q1')
                    ->numeric(),
                TextInput::make('achievement_q2')
                    ->numeric(),
                TextInput::make('achievement_q3')
                    ->numeric(),
                TextInput::make('achievement_q4')
                    ->numeric(),
                Textarea::make('description_q1')
                    ->columnSpanFull(),
                Textarea::make('description_q2')
                    ->columnSpanFull(),
                Textarea::make('description_q3')
                    ->columnSpanFull(),
                Textarea::make('description_q4')
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('year'),
                TextEntry::make('target_q1')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('target_q2')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('target_q3')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('target_q4')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('achievement_q1')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('achievement_q2')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('achievement_q3')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('achievement_q4')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('description_q1')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description_q2')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description_q3')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description_q4')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('year')
            ->columns([
                TextColumn::make('year'),
                TextColumn::make('target_q1')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('target_q2')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('target_q3')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('target_q4')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('achievement_q1')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('achievement_q2')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('achievement_q3')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('achievement_q4')
                    ->numeric()
                    ->sortable(),
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
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
