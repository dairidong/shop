<?php

namespace App\Filament\Clusters;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Clusters\Cluster;
use Illuminate\Contracts\Support\Htmlable;

class Products extends Cluster
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getNavigationLabel(): string
    {
        return __('Product');
    }

    public function getHeading(): string|Htmlable
    {
        return __('Product');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Product');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return __('Product');
    }
}
