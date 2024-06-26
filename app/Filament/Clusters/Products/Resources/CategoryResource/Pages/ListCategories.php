<?php

namespace App\Filament\Clusters\Products\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Products\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->closeModalByClickingAway(false),
        ];
    }

    public function getMaxContentWidth(): MaxWidth|string|null
    {
        return MaxWidth::ScreenTwoExtraLarge;
    }
}
