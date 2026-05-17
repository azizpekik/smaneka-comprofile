<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtracurricularResource\Pages;
use App\Filament\Resources\ExtracurricularResource\RelationManagers;
use App\Models\Extracurricular;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExtracurricularResource extends Resource
{
    protected static ?string $model = Extracurricular::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Sekolah';

    protected static ?string $navigationLabel = 'Ekstrakurikuler';

    protected static ?string $modelLabel = 'Ekstrakurikuler';

    protected static ?string $pluralModelLabel = 'Daftar Ekstrakurikuler';

    protected static ?string $slug = 'ekstrakurikuler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Ekstrakurikuler')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Ekstrakurikuler')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Deskripsi & Foto')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label('Foto')
                            ->image()
                            ->disk('public')
                            ->directory('extracurriculars')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Manfaat Bergabung')
                    ->description('Daftar manfaat yang didapatkan siswa saat bergabung')
                    ->schema([
                        Forms\Components\Repeater::make('benefits')
                            ->label('')
                            ->schema([
                                Forms\Components\TextInput::make('item')
                                    ->label('Manfaat')
                                    ->placeholder('Contoh: Mengembangkan bakat dan minat')
                                    ->required(),
                            ])
                            ->minItems(1)
                            ->maxItems(10)
                            ->addActionLabel('Tambah Manfaat')
                            ->reorderable()
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Kontak & Ajakan')
                    ->schema([
                        Forms\Components\TextInput::make('wa_number')
                            ->label('Nomor WhatsApp')
                            ->placeholder('0812-3456-7890')
                            ->prefix('+62')
                            ->tel()
                            ->helperText('Nomor WA untuk info lebih lanjut'),
                        Forms\Components\TextInput::make('cta_text')
                            ->label('Kalimat Ajakan')
                            ->placeholder('Tertarik? Hubungi kami untuk info lebih lanjut!')
                            ->helperText('Teks yang muncul di tombol/modal'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(80)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state ?? '') > 80 ? $state : null;
                    })
                    ->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->modalHeading('Edit Ekstrakurikuler')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelActionLabel('Batal')
                        ->slideOver()
                        ->icon('heroicon-m-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->modalHeading('Hapus Ekstrakurikuler')
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
                        ->modalHeading('Hapus Ekstrakurikuler')
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
            'index' => Pages\ListExtracurriculars::route('/'),
        ];
    }
}
