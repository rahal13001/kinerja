<?php

namespace App\Filament\Resources\WorkplanResource\Pages;

use App\Filament\Resources\WorkplanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkplans extends ListRecords
{
    protected static string $resource = WorkplanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
