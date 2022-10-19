<?php

namespace App\Filament\Resources\OddResource\Pages;

use App\Filament\Resources\OddResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOdd extends ViewRecord
{
    protected static string $resource = OddResource::class;

    protected static ?string $title = 'Objectifs de Developpement Durable';

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
