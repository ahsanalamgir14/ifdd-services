<?php

namespace App\Filament\Resources\CategorieOddResource\Pages;

use App\Filament\Resources\CategorieOddResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategorieOdds extends ListRecords
{
    protected static string $resource = CategorieOddResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
