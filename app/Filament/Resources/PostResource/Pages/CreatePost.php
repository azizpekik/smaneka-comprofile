<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected static bool $shouldSaveFormStateInSession = true;

    public function getBreadcrumb(): string
    {
        return 'Tambah Berita Baru';
    }

    public static function getNavigationLabel(): string
    {
        return 'Tambah Berita Baru';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return Notification::make()
            ->title('Berita berhasil dibuat')
            ->body('Berita baru telah ditambahkan')
            ->success()
            ->seconds(3);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
