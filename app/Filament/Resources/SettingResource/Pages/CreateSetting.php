<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure value is not null
        if (!isset($data['value'])) {
            $data['value'] = '';
        }
        return $data;
    }
}
