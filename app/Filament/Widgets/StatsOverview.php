<?php

namespace App\Filament\Widgets;

use App\Models\TransportJob;
use App\Models\Expense;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Trabajos (Mes)', TransportJob::whereMonth('date', now()->month)->whereYear('date', now()->year)->count())
                ->description('Histórico total: ' . TransportJob::count())
                ->color('success'),
            Stat::make('Usuarios Activos', User::role('user')->count())
                ->description('Total de usuarios')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Gastos Subidos', Expense::count())
                ->description('Gastos en el sistema')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }
}
