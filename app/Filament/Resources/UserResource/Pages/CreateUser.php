<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return \Filament\Notifications\Notification::make()
            ->title('User berhasil dibuat')
            ->body('User baru telah ditambahkan dengan role yang sesuai')
            ->success()
            ->seconds(3);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['email_verified_at'] = now();
        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Debug: Log the data being received
        \Log::info('Create User - Data received:', ['data' => $data]);
        
        $roles = $data['roles'] ?? [];
        
        \Log::info('Create User - Roles:', ['roles' => $roles]);
        
        unset($data['roles']);
        
        $record = static::getResource()::create($data);
        
        \Log::info('Create User - User created:', ['user_id' => $record->id]);
        
        if (!empty($roles)) {
            $record->syncRoles($roles);
            \Log::info('Create User - Roles synced:', ['user_id' => $record->id, 'roles' => $roles]);
        }
        
        return $record;
    }
}
