<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Pages\Auth\Login;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $this->buildNavigation($builder);
            })
            ->brandName('Vehicle Management System');
    }

    protected function buildNavigation(NavigationBuilder $builder): NavigationBuilder
    {
        $user = auth()->user();

        // Navigation untuk Driver
        if ($user->role === 'driver') {
            return $builder
                ->groups([
                    NavigationGroup::make('Scheduling')
                        ->items([
                            NavigationItem::make('My Schedule')
                                ->icon('heroicon-o-calendar')
                                ->url('/admin/my-schedule')
                                ->isActiveWhen(fn(): bool => request()->routeIs('admin.my-schedule.*')),
                            NavigationItem::make('Vehicle Usage')
                                ->icon('heroicon-o-truck')
                                ->url('/admin/vehicle-usage')
                                ->isActiveWhen(fn(): bool => request()->routeIs('admin.vehicle-usage.*')),
                        ]),
                    NavigationGroup::make('Reports')
                        ->items([
                            NavigationItem::make('My Reports')
                                ->icon('heroicon-o-document-text')
                                ->url('/admin/my-reports')
                                ->isActiveWhen(fn(): bool => request()->routeIs('admin.my-reports.*')),
                        ]),
                ]);
        }

        // Navigation untuk Supervisor Driver
        if ($user->role === 'supervisor_driver') {
            return $builder
                ->groups([
                    NavigationGroup::make('Driver Management')
                        ->items([
                            NavigationItem::make('Drivers')
                                ->icon('heroicon-o-users')
                                ->resource('App\Filament\Resources\UserResource')
                                ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.resources.users.*')),
                            NavigationItem::make('Schedules')
                                ->icon('heroicon-o-calendar')
                                ->resource('App\Filament\Resources\DriverScheduleResource')
                                ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.resources.driver-schedules.*')),
                        ]),
                    NavigationGroup::make('Approvals')
                        ->items([
                            NavigationItem::make('Pending Reports')
                                ->icon('heroicon-o-clipboard-document-check')
                                ->url('/admin/pending-reports')
                                ->badge(fn() => \App\Models\VehicleUsageLog::where('status', 'pending')
                                    ->where('region_id', auth()->user()->region_id)
                                    ->count()),
                        ]),
                ]);
        }

        // Navigation untuk Vehicle Admin
        if ($user->role === 'vehicle_admin') {
            return $builder
                ->groups([
                    NavigationGroup::make('Vehicle Management')
                        ->items([
                            NavigationItem::make('Vehicles')
                                ->icon('heroicon-o-truck')
                                ->resource('App\Filament\Resources\VehicleResource'),
                            NavigationItem::make('Bookings')
                                ->icon('heroicon-o-calendar')
                                ->resource('App\Filament\Resources\VehicleBookingResource'),
                        ]),
                    NavigationGroup::make('Maintenance')
                        ->items([
                            NavigationItem::make('Fuel Logs')
                                ->icon('heroicon-o-beaker')
                                ->resource('App\Filament\Resources\FuelLogResource'),
                            NavigationItem::make('Service Logs')
                                ->icon('heroicon-o-wrench')
                                ->resource('App\Filament\Resources\ServiceLogResource'),
                        ]),
                ]);
        }

        // Navigation untuk Supervisor Admin
        if ($user->role === 'supervisor_admin') {
            return $builder
                ->groups([
                    NavigationGroup::make('Administration')
                        ->items([
                            NavigationItem::make('Users')
                                ->icon('heroicon-o-users')
                                ->resource('App\Filament\Resources\UserResource'),
                            NavigationItem::make('Departments')
                                ->icon('heroicon-o-building-office')
                                ->resource('App\Filament\Resources\DepartmentResource'),
                            NavigationItem::make('Regions')
                                ->icon('heroicon-o-map')
                                ->resource('App\Filament\Resources\RegionResource'),
                        ]),
                    NavigationGroup::make('Vehicle Management')
                        ->items([
                            NavigationItem::make('Vehicles')
                                ->icon('heroicon-o-truck')
                                ->resource('App\Filament\Resources\VehicleResource'),
                            NavigationItem::make('Maintenance')
                                ->icon('heroicon-o-wrench')
                                ->resource('App\Filament\Resources\ServiceLogResource'),
                        ]),
                    NavigationGroup::make('Reports')
                        ->items([
                            NavigationItem::make('Usage Reports')
                                ->icon('heroicon-o-document-chart-bar')
                                ->url('/admin/reports/usage'),
                            NavigationItem::make('Cost Reports')
                                ->icon('heroicon-o-banknotes')
                                ->url('/admin/reports/cost'),
                        ]),
                ]);
        }

        return $builder;
    }
}
