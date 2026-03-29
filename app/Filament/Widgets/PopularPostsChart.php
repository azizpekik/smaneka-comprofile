<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PopularPostsChart extends ChartWidget
{
    protected static ?string $heading = '🔥 Berita Terpopuler';

    protected static ?int $sort = 2;

    protected static string $color = 'warning';

    protected function getData(): array
    {
        $popularPosts = Post::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Views',
                    'data' => $popularPosts->pluck('views_count')->toArray(),
                    'backgroundColor' => [
                        'rgba(232, 162, 2, 0.8)',   // Secondary color
                        'rgba(49, 53, 117, 0.8)',   // Primary color
                        'rgba(181, 0, 56, 0.8)',    // Accent color
                        'rgba(16, 185, 129, 0.8)',  // Success color
                        'rgba(59, 130, 246, 0.8)',  // Blue
                    ],
                    'borderColor' => [
                        'rgba(232, 162, 2, 1)',
                        'rgba(49, 53, 117, 1)',
                        'rgba(181, 0, 56, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(59, 130, 246, 1)',
                    ],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                ],
            ],
            'labels' => $popularPosts->map(function ($post) {
                return \Str::limit($post->title, 40);
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
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
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return value + " views"; }',
                    ],
                ],
            ],
        ];
    }
}
