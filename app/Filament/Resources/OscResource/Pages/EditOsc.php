<?php

namespace App\Filament\Resources\OscResource\Pages;

use App\Filament\Resources\OscResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOsc extends EditRecord
{
    protected static string $resource = OscResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
