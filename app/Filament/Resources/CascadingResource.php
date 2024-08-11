<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CascadingResource\Pages;
use App\Filament\Resources\CascadingResource\RelationManagers;
use App\Models\Cascading;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CascadingResource extends Resource
{
    protected static ?string $model = Cascading::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_cascading')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun_cascading')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('data_cascading')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_cascading')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_cascading')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_cascading')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_cascading')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_cascading')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCascadings::route('/'),
            'create' => Pages\CreateCascading::route('/create'),
            'view' => Pages\ViewCascading::route('/{record}'),
            'edit' => Pages\EditCascading::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();
        if ($locale === 'id') {
            return "Cascading Eselon 1";
        }
        else
        {
            return "Cascading Level 1";
        }
    }
}
