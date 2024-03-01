<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(12)
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\FileUpload::make('avatar')
                        ->directory('avatars')
                        ->translateLabel()
                        ->image()
                        ->imageEditor()
                        ->avatar()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('username')
                        ->required()
                        ->string()
                        ->maxLength(255)
                        ->rule("alpha_dash:ascii")
                        ->unique(ignoreRecord: true)
                        ->label(__('Username'))
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('name')
                        ->string()
                        ->maxLength(255)
                        ->dehydrateStateUsing(fn(?string $state) => is_null($state) ? '' : $state)
                        ->label(__('Name'))
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->string()
                        ->rule('lowercase')
                        ->email()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->translateLabel()
                        ->columnSpan(1),
                ])->columnSpan(8)->columns(),

                Forms\Components\Section::make([
                    Forms\Components\Placeholder::make('created_at')
                        ->label(__('validation.attributes.created_at'))
                        ->content(fn(User $user) => $user->created_at?->format('Y-m-d H:i:s')),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label(__('validation.attributes.updated_at'))
                        ->content(fn(User $user) => $user->updated_at?->format('Y-m-d H:i:s')),

                    Forms\Components\Placeholder::make('email_verified_at')
                        ->label(__('Email verified at'))
                        ->content(function (User $user) {
                            return $user->email_verified_at
                                ? $user->email_verified_at->toFormattedDateString()
                                : svg('heroicon-o-x-circle', 'text-danger-600 w-6 h-6');
                        }),

                    Forms\Components\Placeholder::make('email_verified_at')
                        ->label(__('validation.attributes.deleted_at'))
                        ->hidden(fn(User $user) => is_null($user->deleted_at))
                        ->content(fn(User $user) => $user->deleted_at?->format('Y-m-d H:i:s')),
                ])->columnSpan(4),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('username')
                    ->label(__('Username'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->translateLabel()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->translateLabel()
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('validation.attributes.created_at'))
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('validation.attributes.updated_at'))
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('validation.attributes.deleted_at'))
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }
}
