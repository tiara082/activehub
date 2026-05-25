<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\GameMatch;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan';
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Semua pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
                
            Stat::make('Total Pemesanan', Booking::count())
                ->description('Total transaksi masuk')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart([3, 5, 2, 7, 5, 8, 12])
                ->color('primary'),
                
            Stat::make('Jumlah Fasilitas', Venue::count())
                ->description('Fasilitas olahraga aktif')
                ->descriptionIcon('heroicon-m-map')
                ->color('warning'),

            Stat::make('Main Bareng', GameMatch::count())
                ->description('Kegiatan sedang/telah berjalan')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('info'),
        ];
    }
}
