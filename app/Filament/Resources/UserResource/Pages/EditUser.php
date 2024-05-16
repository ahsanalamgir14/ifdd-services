<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        return UserResource::form(app(UserResource::class)->getForm())->getSchema();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($data['role'] == 9) {
            $data['client_id'] = $data['client_id'];
        } else {
            $data['client_id'] = null;
        }

        return $data;
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
