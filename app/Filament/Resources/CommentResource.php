<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Komentar';

    protected static ?string $modelLabel = 'Komentar';

    protected static ?string $pluralModelLabel = 'Moderasi Komentar';

    protected static ?string $slug = 'komentar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Komentar')
                    ->schema([
                        Forms\Components\Select::make('post_id')
                            ->label('Berita')
                            ->relationship('post', 'title')
                            ->required()
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                Comment::STATUS_PENDING => 'Pending',
                                Comment::STATUS_APPROVED => 'Approved',
                                Comment::STATUS_SPAM => 'Spam',
                                Comment::STATUS_REJECTED => 'Rejected',
                            ])
                            ->default(Comment::STATUS_PENDING)
                            ->required()
                            ->live(),
                    ])->columns(2),
                Forms\Components\Section::make('Informasi Penulis')
                    ->schema([
                        Forms\Components\TextInput::make('author_name')
                            ->label('Nama')
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('author_email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('author_website')
                            ->label('Website')
                            ->url()
                            ->disabled(),
                    ])->columns(3),
                Forms\Components\Section::make('Komentar')
                    ->schema([
                        Forms\Components\Textarea::make('comment')
                            ->label('Isi Komentar')
                            ->required()
                            ->disabled()
                            ->rows(6),
                    ]),
                Forms\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),
                        Forms\Components\TextInput::make('created_at')
                            ->label('Tanggal Komentar')
                            ->disabled()
                            ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d M Y H:i') : '-'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author_email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Berita')
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(50),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => Comment::STATUS_PENDING,
                        'success' => Comment::STATUS_APPROVED,
                        'danger' => Comment::STATUS_SPAM,
                        'secondary' => Comment::STATUS_REJECTED,
                    ])
                    ->formatStateUsing(fn (string $state): string => [
                        Comment::STATUS_PENDING => 'Pending',
                        Comment::STATUS_APPROVED => 'Approved',
                        Comment::STATUS_SPAM => 'Spam',
                        Comment::STATUS_REJECTED => 'Rejected',
                    ][$state] ?? $state),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        Comment::STATUS_PENDING => 'Pending',
                        Comment::STATUS_APPROVED => 'Approved',
                        Comment::STATUS_SPAM => 'Spam',
                        Comment::STATUS_REJECTED => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approve')
                        ->label('Approve')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Comment $record) => $record->update(['status' => Comment::STATUS_APPROVED]))
                        ->visible(fn (Comment $record) => $record->status !== Comment::STATUS_APPROVED),
                    Tables\Actions\Action::make('reject')
                        ->label('Reject')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Comment $record) => $record->update(['status' => Comment::STATUS_REJECTED]))
                        ->visible(fn (Comment $record) => $record->status !== Comment::STATUS_REJECTED),
                    Tables\Actions\Action::make('spam')
                        ->label('Mark as Spam')
                        ->icon('heroicon-m-shield-exclamation')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn (Comment $record) => $record->update(['status' => Comment::STATUS_SPAM]))
                        ->visible(fn (Comment $record) => $record->status !== Comment::STATUS_SPAM),
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->slideOver()
                        ->fillForm(fn (Comment $record): array => [
                            'status' => $record->status,
                            'comment' => $record->comment,
                            'author_name' => $record->author_name,
                            'author_email' => $record->author_email,
                            'author_website' => $record->author_website,
                            'ip_address' => $record->ip_address,
                            'created_at' => $record->created_at,
                            'post_id' => $record->post_id,
                        ]),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus'),
                ])
                ->label('Aksi')
                ->icon('heroicon-m-ellipsis-vertical')
                ->dropdownPlacement('bottom-end')
                ->tooltip('Aksi'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['status' => Comment::STATUS_APPROVED])))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['status' => Comment::STATUS_REJECTED])))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('spam')
                        ->label('Mark as Spam')
                        ->icon('heroicon-m-shield-exclamation')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['status' => Comment::STATUS_SPAM])))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Dipilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListComments::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', Comment::STATUS_PENDING)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
