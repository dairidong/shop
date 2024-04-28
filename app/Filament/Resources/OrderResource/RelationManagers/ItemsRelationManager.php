<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\OrderItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = '订单项';

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('name')
    //                 ->required()
    //                 ->maxLength(255),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('product.title')
                    ->label('商品')
                    ->formatStateUsing(fn (OrderItem $record) => new HtmlString(
                        sprintf(
                            '<a href="%s" wire:navigate class="text-primary-600">%s</a>',
                            route('filament.admin.products.resources.products.edit', [$record->product]),
                            $record->product->title
                        )
                    )),
                Tables\Columns\TextColumn::make('sku_snapshot.name')
                    ->label('商品规格'),
                Tables\Columns\TextColumn::make('price')
                    ->label('购买价格')
                    ->money('CNY'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('购买数量')
                    ->numeric(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
