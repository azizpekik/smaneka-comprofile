<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Force load value from database
        $setting = $this->getRecord();
        $data['value'] = $setting->value ?? '';
        $data['type'] = $setting->type ?? 'text';
        $data['key'] = $setting->key ?? '';
        
        return $data;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure value is not null
        if (!isset($data['value'])) {
            $data['value'] = '';
        }
        return $data;
    }
}
