<?php

namespace App\Filament\Resources\EvaluationreportResource\Pages;

use App\Filament\Resources\EvaluationreportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluationreport extends EditRecord
{
    protected static string $resource = EvaluationreportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
