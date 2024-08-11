<?php

namespace App\Filament\Resources\WorkplanResource\Pages;

use App\Filament\Resources\WorkplanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkplan extends EditRecord
{
    protected static string $resource = WorkplanResource::class;

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
