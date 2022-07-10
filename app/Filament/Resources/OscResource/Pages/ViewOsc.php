<?php

namespace App\Filament\Resources\OscResource\Pages;

use App\Filament\Resources\OscResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOsc extends ViewRecord
{
    protected static string $resource = OscResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
