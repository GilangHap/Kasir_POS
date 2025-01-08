<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\transactions;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 3;
    protected function getStats(): array
    {
        $todayBestSeller = DB::table('transaction_items')
            ->join('menus', 'transaction_items.menu_id', '=', 'menus.id')
            ->select('menus.name', DB::raw('SUM(transaction_items.quantity) as total_quantity'))
            ->whereDate('transaction_items.created_at', now()->toDateString())
            ->groupBy('menus.name')
            ->orderBy('total_quantity', 'desc')
            ->first();

            $today = Carbon::today();
            $transactionsCount = transactions::whereDate('created_at', $today)->count();


            $todayIncome = DB::table('transactions')
            ->whereDate('created_at', now()->toDateString())
            ->sum('final_price');
        

        return [
            Stat::make('Best Seller Today', $todayBestSeller ? $todayBestSeller->name : 'No transaction today')
                ->description($todayBestSeller ? 'Total Sold: ' . $todayBestSeller->total_quantity : '')
                ->icon('heroicon-o-shopping-cart')
                ->color('success'),

            Stat::make('Transactions Today', $transactionsCount)
                ->description('Number of transactions today')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('success'),

            Stat::make('Income Today', 'Rp ' . number_format($todayIncome, 0, ',', '.'))
            ->description('Total income today')
            ->descriptionIcon('heroicon-o-currency-dollar')
            ->color('success'),
        ];

    }
}
