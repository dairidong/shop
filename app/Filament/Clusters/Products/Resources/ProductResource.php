<?php

namespace App\Filament\Clusters\Products\Resources;

use App\Filament\Clusters\Products;
use App\Filament\Clusters\Products\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?int $navigationSort = 1;

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
                        Forms\Components\Select::make('categories')
                            ->searchable()
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->preload(),

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

                    Forms\Components\Section::make([
                        Forms\Components\Repeater::make('attribute_groups')
                            ->hiddenLabel()
                            ->label(__('product.attributes.group')) // For Add Action Button
                            ->relationship()
                            ->reorderable()
                            ->orderColumn('sort')
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('product.attributes.name'))
                                    ->required()
                                    ->distinct()
                                    ->maxLength(20)
                                    ->columnSpan(1),

                                Forms\Components\Repeater::make('attributes')
                                    ->label(__('product.attributes.value'))
                                    ->relationship('attributes')
                                    ->reorderable()
                                    ->orderColumn('sort')
                                    ->required()
                                    ->simple(
                                        Forms\Components\TextInput::make('value')
                                            ->required()
                                            ->distinct()
                                            ->maxLength(20)
                                    )->view('forms.components.repeater.simple')
                                    ->columnSpanFull()
                                    ->grid(3),
                            ])->columns(),
                    ])->heading(__('product.attributes.attributes')),

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
                            ->mask(RawJs::make('$money($input)'))
                            ->numeric()
                            ->default(0.00)
                            ->stripCharacters(',')
                            ->prefix('￥'),
                        Forms\Components\TextInput::make('compare_at_price')
                            ->label(__('product.compare_at_price'))
                            ->mask(RawJs::make('$money($input)'))
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->stripCharacters(',')
                            ->prefix('￥'),
                    ]),

                    Forms\Components\Section::make([
                        Forms\Components\Placeholder::make('rating')
                            ->label(__('product.rating'))
                            ->default(0),
                        Forms\Components\Placeholder::make('sold_count')
                            ->label(__('product.sold_count'))
                            ->default(0),
                        Forms\Components\Placeholder::make('review_count')
                            ->label(__('product.review_count'))
                            ->default(0),
                    ])->hiddenOn('create'),
                ]
                )->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('product.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_no')
                    ->label(__('product.product_no'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->label(__('product.on_sale'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('rating')
                    ->label(__('product.rating'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sold_count')
                    ->label(__('product.sold_count'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('review_count')
                    ->label(__('product.review_count'))
                    ->numeric()
                    ->sortable(),
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
            Products\Resources\ProductResource\RelationManagers\SkusRelationManager::make(),
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

    public static function getModelLabel(): string
    {
        return __('Product');
    }
}
