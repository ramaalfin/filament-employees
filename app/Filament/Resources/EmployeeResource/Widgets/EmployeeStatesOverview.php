<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\State;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class EmployeeStatesOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('All Employees', Employee::all()->count()),
            Card::make('All Countries', Country::all()->count()),
            Card::make('All States', State::all()->count()),
            Card::make('All Departments', Department::all()->count()),
        ];
    }
}
