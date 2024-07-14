<?php

namespace App\Filament\Resources\CategorieThematiqueResource\Pages;

use App\Filament\Resources\CategorieThematiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategorieThematique extends EditRecord
{
    protected static string $resource = CategorieThematiqueResource::class;

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