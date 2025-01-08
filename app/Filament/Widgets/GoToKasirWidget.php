<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class GoToKasirWidget extends Widget
{
    protected static string $view = 'filament.widgets.go-to-kasir-widget';
    protected int | string | array $columnSpan = '2';
    protected static ?int $sort = 1;

    public function getRedirectUrl(): string
    {
        return url('/kasir');
    }
}
