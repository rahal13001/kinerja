<?php

namespace App\Filament\Resources\AchievmentResource\Pages;

use App\Filament\Resources\AchievmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAchievment extends ViewRecord
{
    protected static string $resource = AchievmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
