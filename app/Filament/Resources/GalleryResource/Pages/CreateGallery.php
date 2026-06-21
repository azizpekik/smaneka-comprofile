<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Models\Gallery;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateGallery extends CreateRecord
{
    protected static string $resource = GalleryResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('album_id')
                ->label('Album')
                ->relationship('album', 'name')
                ->required()
                ->searchable()
                ->preload()
                ->columnSpanFull(),
            Repeater::make('galleries')
                ->label('Foto-foto')
                ->schema([
                    FileUpload::make('image_path')
                        ->label('Pilih Foto')
                        ->image()
                        ->disk('public')
                        ->directory('galleries')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('caption')
                        ->label('Keterangan (opsional)')
                        ->columnSpan(1),
                ])
                ->columns(3)
                ->columnSpanFull()
                ->addActionLabel('Tambah Foto Lagi')
                ->defaultItems(1)
                ->minItems(1)
                ->reorderable(),
        ];
    }

    protected function handleRecordCreation(array $data): Gallery
    {
        $albumId = $data['album_id'];
        $galleries = $data['galleries'] ?? [];

        $firstRecord = null;

        foreach ($galleries as $gallery) {
            $record = Gallery::create([
                'album_id' => $albumId,
                'image_path' => $gallery['image_path'],
                'caption' => $gallery['caption'] ?? null,
            ]);

            if (!$firstRecord) {
                $firstRecord = $record;
            }
        }

        $count = count($galleries);
        Notification::make()
            ->title("{$count} foto berhasil ditambahkan")
            ->success()
            ->send();

        return $firstRecord;
    }
}
