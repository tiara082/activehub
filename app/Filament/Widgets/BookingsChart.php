<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;
use Illuminate\Support\Carbon;

class BookingsChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Pemesanan (7 Hari Terakhir)';
    
    // Sort to position it effectively on the dashboard
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->translatedFormat('d M');
            $data[] = Booking::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pemesanan',
                    'data' => $data,
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
