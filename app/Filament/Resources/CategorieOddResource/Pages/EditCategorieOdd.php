<?php

namespace App\Filament\Resources\CategorieOddResource\Pages;

use App\Filament\Resources\CategorieOddResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategorieOdd extends EditRecord
{
    protected static string $resource = CategorieOddResource::class;


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
