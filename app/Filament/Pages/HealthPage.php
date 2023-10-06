<?php

namespace App\Filament\Pages;

use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults as BaseHealthCheckResults;

class HealthPage extends BaseHealthCheckResults
{
    public static function shouldRegisterNavigation(): bool
{
    return auth()->user()->role == 1;
}
}
