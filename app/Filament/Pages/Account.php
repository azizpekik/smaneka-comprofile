<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class Account extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.account';

    protected static ?string $title = 'Pengaturan Akun';

    protected static ?string $navigationLabel = 'Pengaturan Akun';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        
        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->disabled()
                    ->helperText('Email tidak dapat diubah'),
                TextInput::make('current_password')
                    ->label('Kata Sandi Saat Ini')
                    ->password()
                    ->required()
                    ->revealable(),
                TextInput::make('password')
                    ->label('Kata Sandi Baru')
                    ->password()
                    ->nullable()
                    ->minLength(8)
                    ->rules([Password::defaults()])
                    ->revealable()
                    ->helperText('Kosongkan jika tidak ingin mengubah kata sandi'),
                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Kata Sandi Baru')
                    ->password()
                    ->nullable()
                    ->same('password')
                    ->revealable(),
            ])
            ->statePath('data')
            ->columns(1);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function save(): void
    {
        $user = Auth::user();
        
        try {
            $data = $this->form->getState();
            
            // Validate current password
            if (!Hash::check($data['current_password'], $user->password)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'current_password' => 'Kata sandi saat ini tidak sesuai',
                ]);
            }
            
            // Validate password confirmation
            if (filled($data['password']) && $data['password'] !== $data['password_confirmation']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'password_confirmation' => 'Konfirmasi kata sandi tidak sesuai',
                ]);
            }
            
            $user->update([
                'name' => $data['name'],
                'password' => filled($data['password']) ? Hash::make($data['password']) : $user->password,
            ]);

            Notification::make()
                ->title('✅ Akun berhasil diperbarui')
                ->body('Data akun Anda telah disimpan')
                ->success()
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->seconds(3)
                ->send();
                
            // Reset password fields
            $this->form->fill([
                'name' => $user->fresh()->name,
                'email' => $user->fresh()->email,
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Notification::make()
                ->title('❌ Gagal Memperbarui Akun')
                ->body($e->getMessage())
                ->danger()
                ->icon('heroicon-o-exclamation-circle')
                ->color('danger')
                ->seconds(5)
                ->send();
            
            throw $e;
        } catch (\Exception $e) {
            Notification::make()
                ->title('❌ Terjadi Kesalahan')
                ->body('Gagal memperbarui akun. Silakan coba lagi.')
                ->danger()
                ->icon('heroicon-o-exclamation-circle')
                ->color('danger')
                ->seconds(5)
                ->send();
            
            throw $e;
        }
    }
}
