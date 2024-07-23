<?php

namespace App\Filament\Resources\CategorieThematiqueResource\Pages;

use App\Filament\Resources\CategorieThematiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCategorieThematique extends ViewRecord
{
    protected static string $resource = CategorieThematiqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
