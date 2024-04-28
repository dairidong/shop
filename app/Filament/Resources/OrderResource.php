<?php

namespace App\Filament\Resources;

use App\Enums\OrderShipStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function infolist(Infolist $infolist): Infolist
    {
        $companies = ['顺丰', '申通', '圆通'];

        return $infolist
            ->schema([
                Infolists\Components\Group::make([
                    Infolists\Components\Section::make([
                        Infolists\Components\TextEntry::make('no')
                            ->weight('bold')
                            ->label('订单号'),
                        Infolists\Components\TextEntry::make('amount')
                            ->label('订单金额（元）')
                            ->color('primary')
                            ->money('CNY'),
                        Infolists\Components\IconEntry::make('closed')
                            ->label('是否关闭')
                            ->boolean()
                            ->columnSpan(2),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('订单创建时间'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('最后更新于'),
                    ])->columnSpanFull()
                        ->columns(2),

                    Infolists\Components\Section::make('配送信息')
                        ->schema([
                            Infolists\Components\TextEntry::make('address.address')
                                ->label('配送地址')
                                ->columnSpanFull(),

                            Infolists\Components\TextEntry::make('address.zip')
                                ->label('邮编'),

                            Infolists\Components\TextEntry::make('address.contact_name')
                                ->label('收件人'),

                            Infolists\Components\TextEntry::make('address.contact_phone')
                                ->label('联系电话'),

                            Infolists\Components\TextEntry::make('ship_status')
                                ->label('配送状态')
                                ->badge()
                                ->color(fn (OrderShipStatus $state) => match ($state) {
                                    OrderShipStatus::PENDING => 'primary',
                                    OrderShipStatus::DELIVERED => 'info',
                                    OrderShipStatus::RECEIVED => 'success'
                                })
                                ->formatStateUsing(fn (OrderShipStatus $state) => match ($state) {
                                    OrderShipStatus::PENDING => '未发货',
                                    OrderShipStatus::DELIVERED => '已发货',
                                    OrderShipStatus::RECEIVED => '已签收'
                                })->hintActions([
                                    Infolists\Components\Actions\Action::make('ship')
                                        ->label('发货')
                                        ->size(ActionSize::ExtraSmall)
                                        ->button()
                                        ->hidden(fn (Order $record) => ! $record->paid_at || ! $record->isShipPending())
                                        ->form([
                                            Select::make('express_company')
                                                ->label('物流公司')
                                                ->options($companies)
                                                ->required(),
                                            TextInput::make('express_no')
                                                ->label('物流单号')
                                                ->required(),
                                        ])->action(function (array $data, Order $record) {
                                            $record->ship_data = $data;
                                            $record->ship_status = OrderShipStatus::DELIVERED;

                                            $record->save();
                                        }),
                                ]),

                            Infolists\Components\TextEntry::make('ship_data.express_company')
                                ->label('物流公司')
                                ->hidden(fn (Order $record) => $record->isShipPending())
                                ->formatStateUsing(fn ($state) => $companies[$state]),

                            Infolists\Components\TextEntry::make('ship_data.express_no')
                                ->label('物流单号')
                                ->hidden(fn (Order $record) => $record->isShipPending()),

                        ])->columns(3)->columnSpanFull(),

                    Infolists\Components\Section::make([
                        Infolists\Components\TextEntry::make('remark')
                            ->label('备注')
                            ->placeholder('无'),
                    ]),

                ])->columnSpan(2),

                Infolists\Components\Group::make([
                    Infolists\Components\Section::make([
                        Infolists\Components\TextEntry::make('user')
                            ->label('用户')
                            ->formatStateUsing(function (Order $record) {
                                $route = route('filament.admin.resources.users.edit', [$record->user]);
                                $content = $record->user->name ?: $record->user->username;

                                return new HtmlString(
                                    sprintf(
                                        '<a href="%s" wire:navigate class="text-primary-600">%s</a>',
                                        $route,
                                        $content
                                    )
                                );
                            }),
                    ]),

                    Infolists\Components\Section::make('支付信息')
                        ->schema([
                            Infolists\Components\TextEntry::make('is_paid')
                                ->hiddenLabel()
                                ->placeholder('未支付')
                                ->hidden(fn (Order $record) => ! is_null($record->paid_at)),

                            Infolists\Components\TextEntry::make('paid_at')
                                ->label('支付时间')
                                ->dateTime()
                                ->hidden(fn (Order $record) => is_null($record->paid_at)),
                        ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        Table::$defaultDateTimeDisplayFormat = 'Y-m-d H:i:s';

        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('订单号')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('订单金额（元）')
                    ->numeric(2, '.', '')
                    ->sortable(),
                Tables\Columns\IconColumn::make('closed')
                    ->label('关闭')
                    ->boolean(),
                Tables\Columns\TextColumn::make('ship_status')
                    ->label('物流状态')
                    ->badge()
                    ->color(fn (OrderShipStatus $state) => match ($state) {
                        OrderShipStatus::PENDING => 'primary',
                        OrderShipStatus::DELIVERED => 'info',
                        OrderShipStatus::RECEIVED => 'success'
                    })
                    ->formatStateUsing(fn (OrderShipStatus $state) => match ($state) {
                        OrderShipStatus::PENDING => '未发货',
                        OrderShipStatus::DELIVERED => '已发货',
                        OrderShipStatus::RECEIVED => '已签收'
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('创建时间')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('最后更新于')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('支付时间')
                    ->placeholder('未支付')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('删除时间')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
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
        return __('Order');
    }
}
