<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Income Chart';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 25;
    protected function getData(): array
    {
        $startDate = request()->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = request()->query('end_date', Carbon::now()->endOfMonth()->toDateString());

        $incomeData = DB::table('transactions')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(final_price) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $incomeData->pluck('date')->toArray();
        $values = $incomeData->pluck('total')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => $values,
                ],
            ],
        ];
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
