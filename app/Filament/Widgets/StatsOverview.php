<?php

namespace App\Filament\Widgets;

use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Page;
use App\Models\Post;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', Post::count())
                ->description('Semua berita yang diterbitkan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Total Guru', Teacher::count())
                ->description('Data guru aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Total Prestasi', Achievement::count())
                ->description('Prestasi siswa')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
            Stat::make('Total Ekstrakurikuler', Extracurricular::count())
                ->description('Kegiatan ekstrakurikuler')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
        ];
    }
}
