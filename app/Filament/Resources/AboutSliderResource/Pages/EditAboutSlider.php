<?php

namespace App\Filament\Resources\AboutSliderResource\Pages;

use App\Filament\Resources\AboutSliderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutSlider extends EditRecord
{
    protected static string $resource = AboutSliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
