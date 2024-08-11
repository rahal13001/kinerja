<?php

namespace App\Filament\Resources\WorkagreementResource\Pages;

use App\Filament\Resources\WorkagreementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkagreements extends ListRecords
{
    protected static string $resource = WorkagreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
