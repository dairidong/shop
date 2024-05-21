<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarouselResource\Pages;
use App\Models\Carousel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Arr;

class CarouselResource extends Resource
{
    protected static ?string $model = Carousel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = '轮播图';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\Repeater::make('text_columns')
                        ->label('图片文本')
                        ->schema([
                            Forms\Components\TextInput::make('key')
                                ->label('字段标识')
                                ->rule('alpha_num:ascii')
                                ->required()
                                ->distinct(),
                            Forms\Components\TextInput::make('name')
                                ->label('字段名')
                                ->required()
                                ->nullable()
                                ->distinct(),
                            Forms\Components\Toggle::make('required')
                                ->label('是否必须'),
                        ])->columns()
                        ->live(onBlur: true),
                    Forms\Components\Toggle::make('has_link')
                        ->label('是否拥有链接')
                        ->required()
                        ->live(onBlur: true),
                ])->columnSpan(2),

                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->label('轮播图名称')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('key')
                        ->label('标识')
                        ->helperText('全局唯一，使用英文或数字组成')
                        ->unique(ignoreRecord: true)
                        ->rule('alpha_num:ascii')
                        ->required()
                        ->maxLength(255),
                ])->columnSpan(1),

                Forms\Components\Section::make([
                    Forms\Components\Repeater::make('items')
                        ->relationship()
                        ->label('轮播图')
                        ->schema(function (Forms\Get $get) {
                            $components = [
                                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                    ->label('图片')
                                    ->required()
                                    ->disk('public')
                                    ->imageEditor()
                                    ->collection('carousel')
                                    ->responsiveImages()
                                    ->columnSpanFull(),
                            ];

                            $columns = $get('text_columns') ?: [];

                            foreach ($columns as $column) {
                                if ($column['key']) {
                                    $components[] = Forms\Components\TextInput::make($column['key'])
                                        ->label($column['name'] ?: $column['key'])
                                        ->required(fn () => $column['required']);
                                }
                            }

                            if ($get('has_link')) {
                                $components[] = Forms\Components\TextInput::make('link')
                                    ->label('链接')
                                    ->required()
                                    ->url()
                                    ->columnSpanFull();
                            }

                            return $components;
                        })
                        ->mutateRelationshipDataBeforeFillUsing(function (array $data) {
                            return [...$data, ...$data['texts']];
                        })
                        ->mutateRelationshipDataBeforeSaveUsing(function (array $data) {
                            $data['texts'] = Arr::except($data, ['link', 'texts', 'image']);

                            return $data;
                        })
                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                            $data['texts'] = Arr::except($data, ['link', 'texts', 'image']);

                            return $data;
                        })
                        ->columns()
                        ->live(onBlur: true),
                ])->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCarousels::route('/'),
            'create' => Pages\CreateCarousel::route('/create'),
            'edit' => Pages\EditCarousel::route('/{record}/edit'),
        ];
    }
}
