<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected static bool $shouldSaveFormStateInSession = true;

    protected static string $view = 'filament.post-resource.pages.edit-post';

    public function getBreadcrumb(): string
    {
        return 'Edit Berita';
    }

    public static function getNavigationLabel(): string
    {
        return 'Edit Berita';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus Berita')
                ->modalHeading('Hapus Berita')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal')
                ->after(fn () => redirect($this->getResource()::getUrl('index'))),
            Actions\Action::make('view')
                ->label('Lihat Berita')
                ->icon('heroicon-m-eye')
                ->url(fn (Model $record): string => route('posts.show', $record->slug))
                ->openUrlInNewTab(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    #[On('save')]
    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $this->beginDatabaseTransaction();

        try {
            $this->callHook('beforeSave');
            $this->callHook('beforeFill');

            $data = $this->form->getState();
            $data = $this->mutateFormDataBeforeSave($data);

            $this->record->update($data);

            $this->callHook('afterSave');

            $this->commitDatabaseTransaction();

            $this->dispatch('saved');

            // Send success notification (auto-close after 3 seconds)
            Notification::make()
                ->title('✅ Perubahan Berhasil Disimpan')
                ->body('Berita telah disimpan pada ' . now()->format('H:i:s'))
                ->success()
                ->seconds(3)
                ->send();

        } catch (\Exception $e) {
            $this->rollBackDatabaseTransaction();

            Notification::make()
                ->title('❌ Gagal Menyimpan Berita')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->seconds(5)
                ->send();

            throw $e;
        }
    }

    protected function getSavedNotification(): ?\Filament\Notifications\Notification
    {
        return null;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
