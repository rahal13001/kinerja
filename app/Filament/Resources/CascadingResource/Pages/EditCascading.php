<?php

namespace App\Filament\Resources\CascadingResource\Pages;

use App\Filament\Resources\CascadingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCascading extends EditRecord
{
    protected static string $resource = CascadingResource::class;

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
