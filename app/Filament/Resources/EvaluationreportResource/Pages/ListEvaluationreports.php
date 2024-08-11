<?php

namespace App\Filament\Resources\EvaluationreportResource\Pages;

use App\Filament\Resources\EvaluationreportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluationreports extends ListRecords
{
    protected static string $resource = EvaluationreportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
