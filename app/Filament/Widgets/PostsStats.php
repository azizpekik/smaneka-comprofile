<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostsStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $totalViews = Post::sum('views_count');
        $draftPosts = Post::where('status', 'draft')->count();
        
        return [
            Stat::make('Total Berita', $totalPosts)
                ->description('Semua berita')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Dipublikasikan', $publishedPosts)
                ->description('Berita aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Total Views', number_format($totalViews))
                ->description('Total pembacaan')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),
            Stat::make('Draft', $draftPosts)
                ->description('Belum dipublish')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
