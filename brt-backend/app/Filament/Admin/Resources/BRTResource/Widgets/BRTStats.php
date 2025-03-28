<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\BRT;
use Carbon\Carbon;

class BRTStats extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getCards(): array
    {
        $todayCount = BRT::whereDate('created_at', Carbon::today())->count();
        $yesterdayCount = BRT::whereDate('created_at', Carbon::yesterday())->count();

        $weeklyCount = BRT::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $lastWeekCount = BRT::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();

        $monthlyCount = BRT::whereMonth('created_at', Carbon::now()->month)->count();
        $lastMonthCount = BRT::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

        $todayTrend = $yesterdayCount > 0 ? (($todayCount - $yesterdayCount) / $yesterdayCount) * 100 : 0;
        $weeklyTrend = $lastWeekCount > 0 ? (($weeklyCount - $lastWeekCount) / $lastWeekCount) * 100 : 0;
        $monthlyTrend = $lastMonthCount > 0 ? (($monthlyCount - $lastMonthCount) / $lastMonthCount) * 100 : 0;

        return [
            Card::make('Total BRTs', BRT::count()),

            Card::make('Active BRTs', BRT::where('status', 'active')->count()),

            Card::make('Expired BRTs', BRT::where('status', 'expired')->count()),

            Card::make('Total Reserved Amount', number_format(BRT::sum('reserved_amount')) . ' BLM'),

            Card::make('BRTs Created Today', $todayCount)
                ->description($todayTrend >= 0 ? "+$todayTrend% from yesterday" : "$todayTrend% from yesterday")
                ->color($todayTrend >= 0 ? 'success' : 'danger'),

            Card::make('BRTs Created This Week', $weeklyCount)
                ->description($weeklyTrend >= 0 ? "+$weeklyTrend% from last week" : "$weeklyTrend% from last week")
                ->color($weeklyTrend >= 0 ? 'success' : 'danger'),

            Card::make('BRTs Created This Month', $monthlyCount)
                ->description($monthlyTrend >= 0 ? "+$monthlyTrend% from last month" : "$monthlyTrend% from last month")
                ->color($monthlyTrend >= 0 ? 'success' : 'danger'),
        ];
    }
}
