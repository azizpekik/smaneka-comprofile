<?php

namespace App\Filament\Resources\AboutSliderResource\Pages;

use App\Filament\Resources\AboutSliderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutSliders extends ListRecords
{
    protected static string $resource = AboutSliderResource::class;

    // Header actions sudah diatur di Resource table()
    // Tombol "Tambah Slider" sudah ada di sana
}
