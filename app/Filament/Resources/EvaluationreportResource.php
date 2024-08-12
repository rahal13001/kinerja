<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Team;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Indicator;
use Filament\Tables\Table;
use App\Models\Evaluationreport;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EvaluationreportResource\Pages;
use App\Filament\Resources\EvaluationreportResource\RelationManagers;

class EvaluationreportResource extends Resource
{
    protected static ?string $model = Evaluationreport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('period_id')
                    ->required()
                    ->relationship('period', 'periode')
                    ->searchable()
                    ->preload()
                    ->label('Periode'),
                Forms\Components\Select::make('indicator_id')
                    ->label('IKU')
                    ->preload()
                    ->searchable()
                    ->options(Indicator::where('status_iku', 'aktif')->pluck('nama_iku', 'id'))
                    ->required(),
                
                
                Forms\Components\Select::make('team_id')
                    ->relationship('teams', 'team_id')
                    ->label('Tim Kerja')
                    ->options(Team::where('status_tim', 'aktif')->pluck('nama_tim', 'id'))
                    ->preload()
                    ->searchable()
                    ->searchPrompt('Cari Tim Kerja'),
                    
                Forms\Components\TextInput::make('tahun_laporan')
                    ->required()
                    ->label('Tahun Laporan')
                    ->numeric(),

                Forms\Components\TextInput::make('nama_laporan')
                    ->required()
                    ->label('Judul Laporan')
                    ->maxLength(255)
                    ->columnSpanFull(),

              
                Forms\Components\TextInput::make('data_laporan')
                    ->label('Link Data Laporan')
                    ->maxLength(255),
                Forms\Components\Select::make('status_laporan')
                    ->required()
                    ->label('Status Laporan')
                    ->options([
                        '0' => 'Tidak Selesai',
                        '1' => 'Belum Selesai',
                        '2' => 'Selesai',
                        '3' => 'Tidak Berlaku',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('period_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_laporan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_laporan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_laporan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_laporan')
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
            'index' => Pages\ListEvaluationreports::route('/'),
            'create' => Pages\CreateEvaluationreport::route('/create'),
            'view' => Pages\ViewEvaluationreport::route('/{record}'),
            'edit' => Pages\EditEvaluationreport::route('/{record}/edit'),
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
            return "Laporan Evaluasi";
        }
        else
        {
            return "Evaluation Report";
        }
    }
}
