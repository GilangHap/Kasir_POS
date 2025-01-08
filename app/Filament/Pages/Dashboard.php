<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\IncomeChart;
use App\Filament\Widgets\IncomeToday;
use App\Filament\Widgets\BestSellerToday;
use App\Filament\Widgets\GoToKasirWidget;
use App\Filament\Widgets\TransactionToday;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | string | array
    {
        return 3;
    }
}
