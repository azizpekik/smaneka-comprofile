<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSliderResource\Pages;
use App\Filament\Resources\HeroSliderResource\RelationManagers;
use App\Models\HeroSlider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroSliderResource extends Resource
{
    protected static ?string $model = HeroSlider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Hero Slider';

    protected static ?string $modelLabel = 'Hero Slider';

    protected static ?string $pluralModelLabel = 'Hero Sliders';

    protected static ?string $slug = 'hero-sliders';

    protected static ?int $navigationSort = 10;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('super-admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Gambar Slider')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('sliders/hero')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Informasi Slide')
                    ->schema([
                        Forms\Components\TextInput::make('caption')
                            ->label('Caption')
                            ->placeholder('Caption minimalis (opsional)')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('link')
                            ->label('Link URL')
                            ->placeholder('https://... (opsional)')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Gambar')
                    ->size(100),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Caption')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('link')
                    ->label('Link')
                    ->limit(30)
                    ->url(fn ($record) => $record->link, true)
                    ->openUrlInNewTab()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->modalHeading('Edit Hero Slider')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelActionLabel('Batal')
                        ->slideOver()
                        ->icon('heroicon-m-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->modalHeading('Hapus Hero Slider')
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
                        ->modalHeading('Hapus Hero Slider')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal'),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Slider')
                    ->modalHeading('Tambah Hero Slider')
                    ->modalSubmitActionLabel('Simpan')
                    ->modalCancelActionLabel('Batal')
                    ->slideOver(),
            ]);
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
            'index' => Pages\ListHeroSliders::route('/'),
        ];
    }
}
