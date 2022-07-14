<?php

namespace App\Filament\Resources\OddResource\Pages;

use App\Filament\Resources\OddResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOdds extends ListRecords
{
    protected static string $resource = OddResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
