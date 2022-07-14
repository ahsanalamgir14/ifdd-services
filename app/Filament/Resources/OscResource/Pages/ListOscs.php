<?php

namespace App\Filament\Resources\OscResource\Pages;

use App\Filament\Resources\OscResource;
use App\Filament\Resources\OscResource\Widgets\OscOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOscs extends ListRecords
{
    protected static string $resource = OscResource::class;



    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
