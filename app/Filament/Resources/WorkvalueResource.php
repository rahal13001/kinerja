<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkvalueResource\Pages;
use App\Filament\Resources\WorkvalueResource\RelationManagers;
use App\Models\Workvalue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;

class WorkvalueResource extends Resource
{
    protected static ?string $model = Workvalue::class;

    protected static ?string $navigationIcon = 'heroicon-c-trophy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('period_id')
                    ->relationship('period', 'periode')
                    ->required(),
                Forms\Components\TextInput::make('nilai_kinerja')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tahun_kinerja')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('tahun_kinerja')
                ->label('Tahun')
                ->collapsible(),
                Group::make('period.periode')
                ->label('Periode')
                ->collapsible(),
            ])
                  
            ->columns([
                
                Tables\Columns\TextColumn::make('tahun_kinerja')
                    ->label('Tahun')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('period.periode')
                    ->searchable()
                    ->label('Periode')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_kinerja')
                    ->numeric()
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Average::make()
                        ->numeric()
                    ]),
               
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
            'index' => Pages\ListWorkvalues::route('/'),
            'create' => Pages\CreateWorkvalue::route('/create'),
            'view' => Pages\ViewWorkvalue::route('/{record}'),
            'edit' => Pages\EditWorkvalue::route('/{record}/edit'),
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
            return "Nilai Kinerja Organisasi";
        }
        else
        {
            return "Organization Work Values";
        }
    }
}
