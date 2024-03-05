<?php

namespace App\Filament\Clusters\Products\Resources;

use App\Filament\Clusters\Products;
use App\Filament\Clusters\Products\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Products::class;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('title')
                            ->label(__('product.title'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('product_no')
                            ->label(__('product.product_no'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('long_title')
                            ->label(__('product.long_title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\KeyValue::make('extra')
                            ->label(__('product.extra'))
                            ->reorderable()
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label(__('product.description'))
                            ->dehydrateStateUsing(fn ($state) => $state ?? '')
                            ->fileAttachmentsDirectory('product_description_images')
                            ->columnSpanFull(),
                    ])->columns(),

                    Forms\Components\Section::make([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                            ->multiple()
                            ->reorderable()
                            ->responsiveImages()
                            ->collection('product-images')
                            ->hiddenLabel(),
                    ])->heading(__('Image')),

                ])->columns()->columnSpan(2),

                Forms\Components\Group::make([
                    Forms\Components\Section::make([
                        Forms\Components\Toggle::make('on_sale')
                            ->label(__('product.on_sale'))
                            ->required(),
                    ])->heading(__('Status')),

                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('price')
                            ->label(__('product.price'))
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->prefix('￥'),
                        Forms\Components\TextInput::make('compare_at_price')
                            ->label(__('product.compare_at_price'))
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->prefix('￥'),
                    ]),

                    Forms\Components\Section::make([
                        Forms\Components\Placeholder::make('rating')
                            ->default(0),
                        Forms\Components\Placeholder::make('sold_count')
                            ->default(0),
                        Forms\Components\Placeholder::make('review_count')
                            ->default(0),
                    ])->hidden(fn ($operation) => $operation === 'create'),
                ]
                )->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('long_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_no')
                    ->searchable(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->boolean(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sold_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('review_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('compare_at_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
