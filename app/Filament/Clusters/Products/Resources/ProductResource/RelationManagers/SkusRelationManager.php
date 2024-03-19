<?php

namespace App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers;

use App\Models\ProductAttributeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class SkusRelationManager extends RelationManager
{
    protected static string $relationship = 'skus';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('product.sku.name'))
                    ->disabled()
                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                        $rule->where('product_id', $this->getOwnerRecord()->id);
                    })
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)->live(),
                Forms\Components\TextInput::make('bar_no')
                    ->label(__('product.sku.bar_no'))
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Toggle::make('on_sale')
                    ->label(__('product.on_sale'))
                    ->required(),

                Forms\Components\Fieldset::make('attributes')
                    ->label(__('product.sku.attributes'))
                    ->schema(function (RelationManager $livewire) {
                        $product = $livewire->getOwnerRecord()->load('attribute_groups.attributes');

                        return $product->attribute_groups->map(function (ProductAttributeGroup $group) use ($livewire) {
                            return Forms\Components\Select::make($group->name)
                                ->required()
                                ->options($group->attributes->pluck('value', 'id'))
                                ->live()
                                ->native(false)
                                ->dehydrated(false)
                                ->afterStateUpdated(function (RelationManager $livewire, Forms\Get $get, Forms\Set $set) {
                                    $groups = $livewire->getOwnerRecord()->load('attribute_groups.attributes')->attribute_groups;
                                    $selectedAttributes = $groups
                                        ->map(fn (ProductAttributeGroup $group) => $group->attributes->firstWhere('id', $get($group->name)))
                                        ->filter();
                                    $set('name', $selectedAttributes->pluck('value')->join('+'));
                                    $set('attributes', $selectedAttributes->map->only('id', 'value', 'product_attribute_group_id')->all());
                                });
                        })->all();
                    })->columns(3),

                Forms\Components\Hidden::make('attributes')
                    ->required()
                    ->dehydrated(),

                Forms\Components\TextInput::make('stock')
                    ->label(__('product.sku.stock'))
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->required(),

                Forms\Components\Fieldset::make('prices')
                    ->label(__('product.prices'))
                    ->hiddenLabel()
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label(__('product.price'))
                            ->mask(RawJs::make('$money($input)'))
                            ->required()
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
                        Forms\Components\TextInput::make('cost')
                            ->label(__('product.sku.cost'))
                            ->mask(RawJs::make('$money($input)'))
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->stripCharacters(',')
                            ->prefix('￥'),
                    ])->columns(3),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('product.sku.name')),
                Tables\Columns\TextColumn::make('stock')->label(__('product.sku.stock')),
                Tables\Columns\IconColumn::make('on_sale')->label(__('product.on_sale')),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->label(__('validation.attributes.deleted_at')),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }

    protected function configureEditAction(Tables\Actions\EditAction $action): void
    {
        parent::configureEditAction($action);
        $action->mutateRecordDataUsing(function (array $data): array {
            $attributeGroups = $this->getOwnerRecord()->load('attribute_groups')->attribute_groups;

            $selectData = collect($data['attributes'])->map(function ($attribute) use ($attributeGroups) {
                $group = $attributeGroups->firstWhere('id', $attribute['product_attribute_group_id']);

                return ['label' => $group->name, 'value' => $attribute['id']];
            })->pluck('value', 'label')->all();

            return array_merge($selectData, $data);
        });
    }
}
