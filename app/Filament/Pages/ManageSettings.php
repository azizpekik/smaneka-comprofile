<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Livewire\Attributes\Locked;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?int $navigationSort = 1;
    
    protected static ?string $slug = 'pengaturan';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('super-admin');
    }

    public array $settings = [];

    public function mount(): void
    {
        $this->settings = Setting::all()
            ->pluck('value', 'key')
            ->toArray();
    }

    public function save(): void
    {
        foreach ($this->settings as $key => $value) {
            // Handle file uploads for image settings
            if (is_object($value) && method_exists($value, 'store')) {
                // This is a file upload
                $path = $value->store('settings', 'public');
                Setting::where('key', $key)->update(['value' => $path]);
            } else {
                // This is a text value
                Setting::where('key', $key)->update(['value' => $value]);
            }
        }
        
        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
