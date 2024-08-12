<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Team;
use Filament\Tables;
use App\Models\Workplan;
use Filament\Forms\Form;
use App\Models\Indicator;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use RelationManagers\WorplanRelationManager;
use App\Filament\Resources\WorkplanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WorkplanResource\RelationManagers\WorkplanRelationManager;

class WorkplanResource extends Resource
{
    protected static ?string $model = Workplan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->label('Penanggung Jawab')
                    ->preload()
                    ->searchable()
                    ->relationship('user', 'name'),

                  Forms\Components\Select::make('indicator_id')
                    ->label('IKU')
                    ->preload()
                    ->searchable()
                    ->options(Indicator::where('status_iku', 'aktif')->pluck('nama_iku', 'id'))
                    ->required(),
                
                
                Forms\Components\Select::make('team_id')
                    ->label('Tim Kerja')
                    ->options(Team::where('status_tim', 'aktif')->pluck('nama_tim', 'id'))
                    ->preload()
                    ->searchable()
                    ->searchPrompt('Cari Tim Kerja'),
                    
                Forms\Components\TextInput::make('nama_kegiatan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('tgl_rencana')
                    ->required(),

                Forms\Components\Select::make('kategori_kegiatan')
                    ->options([
                        'internal' => 'Internal',
                        'eksternal' => 'Eksternal',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penanggung Jawab')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('team.nomor_tim')
                    ->label('Tim Kerja')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('indicator.nomor_iku')
                    ->label('No IKU')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_rencana')
                    ->label('Tanggal Rencana')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori_kegiatan')
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
            WorkplanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkplans::route('/'),
            'create' => Pages\CreateWorkplan::route('/create'),
            'view' => Pages\ViewWorkplan::route('/{record}'),
            'edit' => Pages\EditWorkplan::route('/{record}/edit'),
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
            return "Rencana Kerja";
        }
        else
        {
            return "Work Plan";
        }
    }
}
