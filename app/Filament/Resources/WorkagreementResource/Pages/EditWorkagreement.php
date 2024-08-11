<?php

namespace App\Filament\Resources\WorkagreementResource\Pages;

use App\Filament\Resources\WorkagreementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkagreement extends EditRecord
{
    protected static string $resource = WorkagreementResource::class;

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
