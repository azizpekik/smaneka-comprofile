<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuggestionResource\Pages;
use App\Models\Suggestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SuggestionResource extends Resource
{
    protected static ?string $model = Suggestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Sekolah';

    protected static ?string $navigationLabel = 'Kritik & Saran';

    protected static ?string $modelLabel = 'Kritik & Saran';

    protected static ?string $pluralModelLabel = 'Daftar Kritik & Saran';

    protected static ?string $slug = 'kritik-saran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengirim')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label('No. HP')
                            ->required()
                            ->disabled(),
                    ])->columns(3),
                Forms\Components\Section::make('Pesan')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->label('Kritik & Saran')
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'baru' => 'Baru',
                                'dibaca' => 'Dibaca',
                            ])
                            ->required(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. HP')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'baru',
                        'success' => 'dibaca',
                    ])
                    ->icons([
                        'heroicon-o-envelope' => 'baru',
                        'heroicon-o-envelope-open' => 'dibaca',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'baru' => 'Baru',
                        'dibaca' => 'Dibaca',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Lihat Detail')
                        ->modalHeading('Detail Kritik & Saran')
                        ->modalSubmitActionLabel('Tandai Dibaca')
                        ->modalCancelActionLabel('Tutup')
                        ->slideOver()
                        ->icon('heroicon-m-eye')
                        ->after(function (Suggestion $record): void {
                            $record->markAsRead();
                        }),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Status')
                        ->modalHeading('Edit Status')
                        ->modalSubmitActionLabel('Simpan')
                        ->modalCancelActionLabel('Batal')
                        ->slideOver()
                        ->icon('heroicon-m-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->modalHeading('Hapus Kritik & Saran')
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
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Tandai Dibaca')
                        ->icon('heroicon-m-envelope-open')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Tandai Dibaca')
                        ->modalDescription('Apakah Anda yakin ingin menandai kritik & saran yang dipilih sebagai dibaca?')
                        ->modalSubmitActionLabel('Ya, Tandai')
                        ->modalCancelActionLabel('Batal')
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                $record->markAsRead();
                            }
                        }),
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Dipilih')
                        ->modalHeading('Hapus Kritik & Saran')
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
            'index' => Pages\ListSuggestions::route('/'),
        ];
    }
}
