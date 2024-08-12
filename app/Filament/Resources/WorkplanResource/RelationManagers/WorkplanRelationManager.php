<?php

namespace App\Filament\Resources\WorkplanResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class WorkplanRelationManager extends RelationManager
{
    protected static string $relationship = 'workevaluations';
    protected static ?string $title = 'Evaluasi Kinerja';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tgl_realisasi')
                    ->label('Tanggal Realisasi')
                    ->columnSpanFull()    
                    ->required(),

                Forms\Components\Select::make('report.what')
                    ->label('5W1H')
                    ->nullable()
                    ->relationship('report', 'what')
                    ->searchable()
                    ->searchPrompt('Cari 5W1H')
                    ->columnSpanFull()
                    ->multiple()
                    ->pivotData([
                        'is_primary' => true,
                    ]),

                TinyEditor::make('kendala')
                    ->label('Kendala')
                    ->columnSpanFull(),
                    
                TinyEditor::make('saran')
                    ->label('Saran')
                    ->columnSpanFull(),

                TinyEditor::make('tindak_lanjut')
                    ->label('Tindak Lanjut')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('bukti_tindak_lanjut')
                    ->label('Bukti Tindak Lanjut')
                    ->columnSpanFull()
                    ->maxlength(255),

                TinyEditor::make('keterangan')
                    ->label('Keterangan')
                    ->columnSpanFull(),

                TinyEditor::make('komentar')
                    ->label('Komentar')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_kegiatan')
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Tambah Evaluasi Kinerja')
                ->label('Tambah Evaluasi Kinerja')
                ->modalWidth('7x1')
                ->closeModalByClickingAway(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Edit Evaluasi Kinerja')
                ->modalWidth('7x1')
                ->closeModalByClickingAway(false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
