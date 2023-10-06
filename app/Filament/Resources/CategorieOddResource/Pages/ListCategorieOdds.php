<?php

namespace App\Filament\Resources\CategorieOddResource\Pages;

use App\Filament\Resources\CategorieOddResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategorieOdds extends ListRecords
{
    protected static string $resource = CategorieOddResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
