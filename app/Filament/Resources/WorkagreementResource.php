<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkagreementResource\Pages;
use App\Filament\Resources\WorkagreementResource\RelationManagers;
use App\Models\Workagreement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkagreementResource extends Resource
{
    protected static ?string $model = Workagreement::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pk')
                    ->label('Nama PK')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun_pk')
                    ->label('Tahun PK')
                    ->required()
                    ->numeric(),
                
                Forms\Components\FileUpload::make('data_pk')
                    ->required()
                    ->label('File PK')
                    ->visibility('public')
                    ->disk('public')
                    ->directory('pk')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'image/*']),
                
                Forms\Components\Select::make('status_pk')
                    ->required()
                    ->label('Status PK')
                    ->options([
                        'Berlaku' => 'Berlaku',
                        'Tidak Berlaku' => 'Tidak Berlaku',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('nama_pk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_pk')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_pk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pk')
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
            'index' => Pages\ListWorkagreements::route('/'),
            'create' => Pages\CreateWorkagreement::route('/create'),
            'view' => Pages\ViewWorkagreement::route('/{record}'),
            'edit' => Pages\EditWorkagreement::route('/{record}/edit'),
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
            return "Perjanjian Kerja";
        }
        else
        {
            return "Work Agreement";
        }
    }
}
