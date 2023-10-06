<?php

namespace App\Filament\Resources\OddResource\Pages;

use App\Filament\Resources\OddResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOdd extends ViewRecord
{
    protected static string $resource = OddResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
