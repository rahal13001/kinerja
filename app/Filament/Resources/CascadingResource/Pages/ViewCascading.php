<?php

namespace App\Filament\Resources\CascadingResource\Pages;

use App\Filament\Resources\CascadingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCascading extends ViewRecord
{
    protected static string $resource = CascadingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
