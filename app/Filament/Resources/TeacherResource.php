<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Sekolah';

    protected static ?string $navigationLabel = 'Guru & Staff';

    protected static ?string $modelLabel = 'Guru & Staff';

    protected static ?string $pluralModelLabel = 'Daftar Guru & Staff';

    protected static ?string $slug = 'guru-staff';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),
                        Forms\Components\TextInput::make('position')
                            ->label('Jabatan'),
                        Forms\Components\TextInput::make('subject')
                            ->label('Mata Pelajaran'),
                    ])->columns(2),
                Forms\Components\Section::make('Foto & Deskripsi')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto Profil')
                            ->image()
                            ->disk('public')
                            ->directory('teachers/photos')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->circleCropper()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('bio')
                            ->label('Biografi')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('PIN & Prioritas')
                    ->schema([
                        Forms\Components\Toggle::make('is_pinned')
                            ->label('PIN ke Halaman Utama')
                            ->helperText('Guru yang di-PIN akan tampil di urutan paling atas (Maksimal 10 guru)')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $set('pin_order', Teacher::getNextPinOrder());
                                } else {
                                    $set('pin_order', 0);
                                }
                            }),
                        Forms\Components\TextInput::make('pin_order')
                            ->label('Urutan PIN')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin atas posisinya')
                            ->visible(fn (Forms\Get $get) => $get('is_pinned')),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('PIN')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight(fn ($record) => $record->is_pinned ? 'bold' : 'normal'),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pin_order')
                    ->label('Urutan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Status PIN'),
            ])
            ->actions([
                Tables\Actions\Action::make('togglePin')
                    ->label(fn ($record) => $record->is_pinned ? 'Lepas PIN' : 'PIN Guru')
                    ->icon(fn ($record) => $record->is_pinned ? 'heroicon-s-star' : 'heroicon-o-star')
                    ->color(fn ($record) => $record->is_pinned ? 'gray' : 'warning')
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => $record->is_pinned ? 'Lepas PIN Guru' : 'PIN Guru')
                    ->modalDescription(fn ($record) => $record->is_pinned 
                        ? 'Guru ini tidak akan lagi tampil di urutan paling atas.' 
                        : 'Guru ini akan tampil di urutan paling atas. Maksimal 10 guru yang bisa di-PIN.')
                    ->modalSubmitActionLabel(fn ($record) => $record->is_pinned ? 'Ya, Lepas PIN' : 'Ya, PIN Guru')
                    ->action(function ($record) {
                        if ($record->is_pinned) {
                            // Unpin
                            $record->update([
                                'is_pinned' => false,
                                'pin_order' => 0,
                            ]);
                        } else {
                            // Pin
                            if (Teacher::isPinLimitReached()) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Batas PIN Tercapai')
                                    ->body('Maksimal 10 guru yang bisa di-PIN. Lepaskan PIN dari guru lain terlebih dahulu.')
                                    ->danger()
                                    ->send();
                                return;
                            }
                            
                            $record->update([
                                'is_pinned' => true,
                                'pin_order' => Teacher::getNextPinOrder(),
                            ]);
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Berhasil di-PIN')
                                ->body("{$record->name} sekarang ditampilkan di urutan paling atas.")
                                ->success()
                                ->send();
                        }
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->modalHeading('Edit Guru/Staff')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelActionLabel('Batal')
                        ->slideOver()
                        ->icon('heroicon-m-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->modalHeading('Hapus Guru/Staff')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->icon('heroicon-m-trash'),
                ])
                ->label('Aksi')
                ->icon('heroicon-m-ellipsis-vertical')
                ->dropdownPlacement('bottom-end')
                ->tooltip('Aksi'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Dipilih')
                        ->modalHeading('Hapus Guru/Staff')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal'),
                ]),
            ])
            ->reorderable('pin_order')
            ->defaultSort('is_pinned', 'desc')
            ->headerActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
        ];
    }
}
