<?php

namespace App\Filament\Resources\AchievmentResource\Pages;

use App\Filament\Resources\AchievmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAchievment extends EditRecord
{
    protected static string $resource = AchievmentResource::class;

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
