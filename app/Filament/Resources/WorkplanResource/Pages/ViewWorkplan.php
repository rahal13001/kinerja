<?php

namespace App\Filament\Resources\WorkplanResource\Pages;

use App\Filament\Resources\WorkplanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkplan extends ViewRecord
{
    protected static string $resource = WorkplanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
