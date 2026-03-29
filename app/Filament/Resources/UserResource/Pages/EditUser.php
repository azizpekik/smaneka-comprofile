<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus User')
                ->modalHeading('Hapus User')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal')
                ->after(fn () => redirect($this->getResource()::getUrl('index'))),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?\Filament\Notifications\Notification
    {
        return \Filament\Notifications\Notification::make()
            ->title('User berhasil diupdate')
            ->body('Data user dan hak akses telah diperbarui')
            ->success()
            ->seconds(3);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $roles = $data['roles'] ?? [];
        unset($data['roles']);
        
        $record->update($data);
        
        if (!empty($roles)) {
            $record->syncRoles($roles);
        }
        
        return $record;
    }
}
