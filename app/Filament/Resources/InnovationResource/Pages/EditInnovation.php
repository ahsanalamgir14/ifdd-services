<?php

namespace App\Filament\Resources\InnovationResource\Pages;

use App\Filament\Resources\InnovationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInnovation extends EditRecord
{
    protected static string $resource = InnovationResource::class;

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
