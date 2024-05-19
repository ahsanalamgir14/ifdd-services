<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Role;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user->role && Role::find($user->role)->role_type == 'client';
    }
}
