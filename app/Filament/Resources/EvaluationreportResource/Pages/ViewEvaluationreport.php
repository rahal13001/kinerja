<?php

namespace App\Filament\Resources\EvaluationreportResource\Pages;

use App\Filament\Resources\EvaluationreportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEvaluationreport extends ViewRecord
{
    protected static string $resource = EvaluationreportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
