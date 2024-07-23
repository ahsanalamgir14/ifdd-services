<?php

namespace App\Filament\Resources\InnovationResource\Pages;

use App\Filament\Resources\InnovationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInnovation extends ViewRecord
{
    protected static string $resource = InnovationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
