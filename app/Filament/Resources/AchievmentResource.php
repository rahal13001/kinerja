<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievmentResource\Pages;
use App\Filament\Resources\AchievmentResource\RelationManagers;
use App\Models\Achievment;
use App\Models\Indicator;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AchievmentResource extends Resource
{
    protected static ?string $model = Achievment::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('indicator_id')
                    ->options(Indicator::where('status_iku', 'aktif')->pluck('nama_iku', 'id'))
                    ->searchable()
                    ->label('IKU')
                    ->preload()
                    ->searchPrompt('Cari IKU')
                    ->required(),
                Forms\Components\Select::make('team_id')
                    ->options(Team::where('status_tim', 'aktif')->pluck('nama_tim', 'id'))
                    ->searchable()
                    ->label('Tim Kerja')
                    ->preload()
                    ->searchPrompt('Cari Tim Kerja')
                    ->required(),
                Forms\Components\TextInput::make('tahun_achievment')
                    ->label('Tahun Capaian')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('target_achievment')
                    ->label('Target Capaian')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('realisasi_achievment')
                    ->label('Realisasi Capaian')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bukti_achievment')
                    ->label('Bukti Capaian (Link Data Dukung)')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun_achievment')
                    ->label('Tahun')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('indicator.nomor_iku')
                    ->label('Nomor IKU')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('team.nomor_tim')
                    ->label('Nomor Tim')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_achievment')
                    ->label('Target')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('realisasi_achievment')
                    ->label('Realisasi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bukti_achievment')
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
            'index' => Pages\ListAchievments::route('/'),
            'create' => Pages\CreateAchievment::route('/create'),
            'view' => Pages\ViewAchievment::route('/{record}'),
            'edit' => Pages\EditAchievment::route('/{record}/edit'),
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
            return "Capaian Kinerja";
        }
        else
        {
            return "Achievment";
        }
    }
}
