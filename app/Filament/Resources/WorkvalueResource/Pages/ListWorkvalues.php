<?php

namespace App\Filament\Resources\WorkvalueResource\Pages;

use App\Filament\Resources\WorkvalueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkvalues extends ListRecords
{
    protected static string $resource = WorkvalueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
