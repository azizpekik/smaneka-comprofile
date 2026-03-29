<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Situs (Old)';

    protected static ?string $modelLabel = 'Pengaturan Situs';

    protected static ?string $pluralModelLabel = 'Daftar Pengaturan';

    protected static ?string $slug = 'pengaturan-old';

    protected static ?int $navigationSort = 99;
    
    public static function canAccess(): bool
    {
        return false; // Disable old settings page
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Kunci Pengaturan')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled(fn ($record) => $record !== null)
                    ->default(fn ($record) => $record?->key ?? ''),
                Forms\Components\Select::make('type')
                    ->label('Tipe Input')
                    ->options([
                        'text' => 'Teks',
                        'textarea' => 'Teks Panjang',
                        'image' => 'Gambar',
                        'email' => 'Email',
                        'url' => 'URL',
                    ])
                    ->default('text')
                    ->required()
                    ->disabled(fn ($record) => $record !== null)
                    ->helperText('Menentukan tipe input form untuk pengaturan ini'),
                Forms\Components\TextInput::make('value')
                    ->label('Nilai')
                    ->required()
                    ->columnSpanFull()
                    ->default(fn ($record) => $record?->value ?? '')
                    ->visible(fn ($record) => $record === null || in_array($record?->type ?? 'text', ['text', 'email', 'url'])),
                Forms\Components\Textarea::make('value')
                    ->label('Nilai')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull()
                    ->default(fn ($record) => $record?->value ?? '')
                    ->visible(fn ($record) => $record && $record->type === 'textarea'),
                Forms\Components\FileUpload::make('value')
                    ->label('Gambar')
                    ->image()
                    ->directory('settings')
                    ->required()
                    ->columnSpanFull()
                    ->default(fn ($record) => $record?->value ?? '')
                    ->visible(fn ($record) => $record && $record->type === 'image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Kunci')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50)
                    ->copyable()
                    ->copyMessage('Nilai disalin'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => [
                        'text' => 'Teks',
                        'textarea' => 'Teks Panjang',
                        'image' => 'Gambar',
                        'email' => 'Email',
                        'url' => 'URL',
                    ][$state] ?? $state)
                    ->colors([
                        'text' => 'text',
                        'textarea' => 'info',
                        'image' => 'success',
                        'email' => 'warning',
                        'url' => 'primary',
                    ]),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Teks',
                        'textarea' => 'Teks Panjang',
                        'image' => 'Gambar',
                        'email' => 'Email',
                        'url' => 'URL',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->modalHeading('Edit Pengaturan')
                    ->modalSubmitActionLabel('Simpan Perubahan')
                    ->modalCancelActionLabel('Batal')
                    ->slideOver()
                    ->icon('heroicon-m-pencil-square'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->modalHeading('Hapus Pengaturan')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal')
                    ->icon('heroicon-m-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Dipilih')
                        ->modalHeading('Hapus Pengaturan')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal'),
                ]),
            ])
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
            'index' => Pages\ListSettings::route('/'),
        ];
    }
}
