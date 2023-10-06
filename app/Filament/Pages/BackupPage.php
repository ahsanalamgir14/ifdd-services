<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackupsCheckResults;

class BackupPage extends BaseBackupsCheckResults
{
    public static function shouldRegisterNavigation(): bool
{
    return auth()->user()->role == 1;
}
}
