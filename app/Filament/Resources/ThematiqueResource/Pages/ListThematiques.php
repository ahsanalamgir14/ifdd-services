<?php

namespace App\Filament\Resources\ThematiqueResource\Pages;

use App\Filament\Resources\ThematiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThematiques extends ListRecords
{
    protected static string $resource = ThematiqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
