<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('super-admin');
    }

    protected static ?string $navigationLabel = 'Menu Navigasi';

    protected static ?string $modelLabel = 'Menu Navigasi';

    protected static ?string $pluralModelLabel = 'Daftar Menu';

    protected static ?string $slug = 'menu';

    public static function isSystemRoute(?string $url): bool
    {
        if (empty($url) || $url === '#') {
            return false;
        }
        return in_array(ltrim($url, '/'), config('protected-slugs'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Menu')
                    ->required(),
                Forms\Components\Select::make('page_id')
                    ->label('Halaman Statis')
                    ->relationship('page', 'title', fn ($query) => $query->where('is_active', true))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Pilih halaman statis untuk menu ini, atau biarkan kosong untuk menu dropdown/parent')
                    ->live()
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => [
                        $set('url', $state ? '/' . \App\Models\Page::find($state)?->slug : '#'),
                    ]),
                Forms\Components\TextInput::make('url')
                    ->label('URL/Link')
                    ->required()
                    ->default('#')
                    ->helperText('Gunakan # untuk menu dropdown (parent), atau pilih halaman statis di atas untuk auto-fill'),
                Forms\Components\Select::make('parent_id')
                    ->label('Menu Induk')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Pilih menu induk jika ini adalah submenu'),
                Forms\Components\TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->helperText('Angka lebih kecil akan tampil lebih dulu'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->limit(35)
                    ->formatStateUsing(fn (Menu $record): string => 
                        $record->page ? 'Halaman: ' . $record->page->title : $record->url
                    ),
                Tables\Columns\TextColumn::make('route_type')
                    ->label('Tipe Route')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'System Route' => 'warning',
                        'Static Page' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Menu Induk')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('systemRoute')
                        ->label('System Route')
                        ->icon('heroicon-m-lock-closed')
                        ->color('warning')
                        ->action(fn () => null)
                        ->requiresConfirmation()
                        ->modalHeading('System Route')
                        ->modalDescription('Ini adalah route system yang tidak dapat diubah atau dihapus.')
                        ->modalSubmitActionLabel('Mengerti')
                        ->visible(fn (Menu $record): bool => self::isSystemRoute($record->url)),

                    Tables\Actions\Action::make('moveUp')
                        ->label('Naik')
                        ->icon('heroicon-m-arrow-up')
                        ->action(function (Menu $record): void {
                            $previous = Menu::where('order', '<', $record->order)
                                ->orderBy('order', 'desc')
                                ->first();

                            if ($previous) {
                                $temp = $record->order;
                                $record->update(['order' => $previous->order]);
                                $previous->update(['order' => $temp]);
                            }
                        })
                        ->visible(fn (Menu $record): bool => $record->order > 0 && !self::isSystemRoute($record->url))
                        ->requiresConfirmation()
                        ->modalHeading('Pindahkan Menu Naik')
                        ->modalSubmitActionLabel('Ya, Pindahkan')
                        ->modalCancelActionLabel('Batal'),

                    Tables\Actions\Action::make('moveDown')
                        ->label('Turun')
                        ->icon('heroicon-m-arrow-down')
                        ->action(function (Menu $record): void {
                            $next = Menu::where('order', '>', $record->order)
                                ->orderBy('order')
                                ->first();

                            if ($next) {
                                $temp = $record->order;
                                $record->update(['order' => $next->order]);
                                $next->update(['order' => $temp]);
                            }
                        })
                        ->visible(fn (Menu $record): bool => $record->order < Menu::max('order') && !self::isSystemRoute($record->url))
                        ->requiresConfirmation()
                        ->modalHeading('Pindahkan Menu Turun')
                        ->modalSubmitActionLabel('Ya, Pindahkan')
                        ->modalCancelActionLabel('Batal'),

                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->modalHeading('Edit Menu')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelActionLabel('Batal')
                        ->slideOver()
                        ->icon('heroicon-m-pencil-square')
                        ->visible(fn (Menu $record): bool => !self::isSystemRoute($record->url)),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->modalHeading('Hapus Menu')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->icon('heroicon-m-trash')
                        ->visible(fn (Menu $record): bool => !self::isSystemRoute($record->url)),
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
                        ->modalHeading('Hapus Menu')
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
            'index' => Pages\ListMenus::route('/'),
        ];
    }
}
