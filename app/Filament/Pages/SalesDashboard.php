<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\SalesPieChart;

class SalesDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static string $view = 'filament.pages.sales-dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            SalesPieChart::class,
        ];
    }
}