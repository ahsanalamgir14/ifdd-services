<?php

namespace App\Filament\Resources\OscResource\Pages;

use App\Filament\Resources\OscResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOscs extends ListRecords
{
    protected static string $resource = OscResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
