<?php

namespace App\Filament\Resources\Indicators\Pages;

use App\Filament\Resources\Indicators\IndicatorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIndicator extends ViewRecord
{
    protected static string $resource = IndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
