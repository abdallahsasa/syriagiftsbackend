<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::count())
                ->description('All time orders')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),
            Stat::make('Orders Today', Order::whereDate('created_at', now()->today())->count())
                ->description('New orders today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Monthly Revenue', '$' . number_format(Order::whereMonth('created_at', now()->month)->sum('total'), 2))
                ->description('Revenue for ' . now()->format('F'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Total Revenue', '$' . number_format(Order::sum('total'), 2))
                ->description('All time revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),
        ];
    }
}
