<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Models\Gallery;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListGalleries extends ListRecords
{
    protected static string $resource = GalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Foto Baru')
                ->slideOver()
                ->form([
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
                ])
                ->using(function (array $data) {
                    $albumId = $data['album_id'];
                    $galleries = $data['galleries'] ?? [];

                    foreach ($galleries as $gallery) {
                        Gallery::create([
                            'album_id' => $albumId,
                            'image_path' => $gallery['image_path'],
                            'caption' => $gallery['caption'] ?? null,
                        ]);
                    }

                    $count = count($galleries);
                    Notification::make()
                        ->title("{$count} foto berhasil ditambahkan")
                        ->success()
                        ->send();
                }),
        ];
    }
}
