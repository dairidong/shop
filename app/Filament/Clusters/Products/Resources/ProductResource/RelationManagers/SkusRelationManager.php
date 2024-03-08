<?php

namespace App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers;

use App\Models\ProductAttributeGroup;
use App\Models\ProductSku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Unique;

class SkusRelationManager extends RelationManager
{
    protected static string $relationship = 'skus';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->disabled()
                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                        $rule->where('product_id', $this->getOwnerRecord()->id);
                    })
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)->live(),
                Forms\Components\TextInput::make('bar_no')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Toggle::make('on_sale'),

                Forms\Components\Fieldset::make('attributes')
                    ->schema(function (RelationManager $livewire, ?ProductSku $record, $operation) {
                        $product = $livewire->getOwnerRecord()->load('attribute_groups.attributes');

                        return $product->attribute_groups->map(function (ProductAttributeGroup $group) use ($livewire, $record, $operation) {
                            return Forms\Components\Select::make($group->name)
                                ->required()
                                ->options($group->attributes->pluck('value', 'id'))
                                ->live()
                                ->dehydrated(false)
                                ->afterStateUpdated(function (RelationManager $livewire, Forms\Get $get, Forms\Set $set) {
                                    $groups = $livewire->getOwnerRecord()->load('attribute_groups.attributes')->attribute_groups;
                                    $selectedAttributes = $groups
                                        ->map(fn (ProductAttributeGroup $group) => $group->attributes->firstWhere('id', $get($group->name)))
                                        ->filter();
                                    $set('name', $selectedAttributes->pluck('value')->join('+'));
                                    $set('attributes', $selectedAttributes->each->only('id', 'value', 'product_attribute_group_id')->all());
                                });
                        })->all();
                    })->columns(3),

                Forms\Components\Hidden::make('attributes')
                    ->required()
                    ->dehydrated(),

                Forms\Components\TextInput::make('stock')
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->required(),

                Forms\Components\Fieldset::make('price')
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
                            ->label(__('product.cost'))
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
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('stock'),
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
