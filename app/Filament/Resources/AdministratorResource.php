<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdministratorResource\Pages;
use App\Models\Administrator;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdministratorResource extends Resource
{
    protected static ?string $model = Administrator::class;

    protected static ?string $navigationIcon = 'eos-admin';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(12)
            ->schema([
                Forms\Components\FileUpload::make('avatar')
                    ->hiddenLabel()
                    ->placeholder(__('Drag or click to upload', ['attribute' => __('Avatar')]))
                    ->directory('avatars')
                    ->columnStart(['lg' => 6])
                    ->extraAttributes(['class' => 'justify-center'])
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper(),

                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('username')
                        ->label(__('Username'))
                        ->maxLength(255)
                        ->required()
                        ->rule('alpha_dash:ascii')
                        ->unique(Administrator::class, 'username', ignoreRecord: true),
                    Forms\Components\TextInput::make('name')
                        ->label(__('Name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->label(__('Password'))
                        ->password()
                        ->rule(Password::default())
                        ->revealable()
                        ->maxLength(255)
                        ->dehydrated(fn ($state): bool => filled($state))
                        ->live(debounce: 500)
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->same('passwordConfirmation'),
                    Forms\Components\TextInput::make('passwordConfirmation')
                        ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
                        ->password()
                        ->revealable(filament()->arePasswordsRevealable())
                        ->required()
                        ->visible(fn (Get $get): bool => filled($get('password')))
                        ->dehydrated(false),
                ]),

                Forms\Components\Section::make([
                    // Using CheckboxList Component
                    Forms\Components\CheckboxList::make('roles')
                        ->label(__('filament-shield::filament-shield.column.roles'))
                        ->relationship('roles', 'name')
                        ->columnSpan(6)
                        ->bulkToggleable()
                        ->searchable(),

                ])->columns(12)->columnSpan(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->state(fn (Administrator $admin): ?string => $admin->avatar ?? Filament::getUserAvatarUrl($admin))
                    ->translateLabel()
                    ->circular(),
                Tables\Columns\TextColumn::make('username')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('validation.attributes.created_at'))
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('validation.attributes.updated_at'))
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('validation.attributes.deleted_at'))
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListAdministrators::route('/'),
            'create' => Pages\CreateAdministrator::route('/create'),
            'edit' => Pages\EditAdministrator::route('/{record}/edit'),
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
        return __('admin.Administrators');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.Administrators');
    }
}
