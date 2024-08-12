<?php

namespace App\Filament\Resources\WorkvalueResource\Pages;

use App\Filament\Resources\WorkvalueResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkvalue extends ViewRecord
{
    protected static string $resource = WorkvalueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
