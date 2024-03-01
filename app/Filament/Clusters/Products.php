<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;

class Products extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    /**
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    public function getHeading(): string | Htmlable
    {
        return __('Products');
    }

    public function getTitle(): string | Htmlable
    {
        return  __('Products');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return  __('Products');
    }
}
