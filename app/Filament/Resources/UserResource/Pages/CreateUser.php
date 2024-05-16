<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getFormSchema(): array
    {
        return UserResource::form(app(UserResource::class)->getForm())->getSchema();
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['role'] == 9) {
            $data['client_id'] = $data['client_id'];
        } else {
            $data['client_id'] = null;
        }
        return $data;
    }
}
