<?php

namespace App\Filament\Resources\CascadingResource\Pages;

use App\Filament\Resources\CascadingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCascadings extends ListRecords
{
    protected static string $resource = CascadingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
