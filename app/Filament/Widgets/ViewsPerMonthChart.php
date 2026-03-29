<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ViewsPerMonthChart extends ChartWidget
{
    protected static ?string $heading = '📈 Views per Bulan';

    protected static ?int $sort = 3;

    protected static string $color = 'success';

    protected function getData(): array
    {
        // Get all posts from current year
        $posts = Post::whereYear('created_at', date('Y'))
            ->orderBy('created_at')
            ->get();

        // Group by month manually for better SQLite compatibility
        $monthlyViews = [];
        $monthNames = [];
        
        foreach ($posts as $post) {
            $monthKey = $post->created_at->format('m-Y');
            $monthLabel = $post->created_at->format('F Y');
            
            if (!isset($monthlyViews[$monthKey])) {
                $monthlyViews[$monthKey] = 0;
                $monthNames[$monthKey] = $monthLabel;
            }
            
            $monthlyViews[$monthKey] += $post->views_count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Views',
                    'data' => array_values($monthlyViews),
                    'backgroundColor' => 'rgba(49, 53, 117, 0.2)',
                    'borderColor' => 'rgba(49, 53, 117, 1)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => array_values($monthNames),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.raw + " views"; }',
                    ],
                ],
                'datalabels' => [
                    'align' => 'top',
                    'anchor' => 'end',
                    'color' => '#313575',
                    'font' => [
                        'weight' => 'bold',
                        'size' => 12,
                    ],
                    'formatter' => 'function(value) { return value.toLocaleString() + " views"; }',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return value.toLocaleString() + " views"; }',
                    ],
                ],
            ],
        ];
    }
}
