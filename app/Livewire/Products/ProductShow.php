<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Models\ProductSku;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ProductShow extends Component
{
    #[Locked]
    public Product $product;

    public int $skuId;

    public function mount(Product $product): void
    {
        $this->product = $product->loadMissing([
            'attribute_groups' => function (Builder $query) {
                $query->select('id', 'name', 'product_id')
                    ->with(['attributes' => function (Builder $query) {
                        $query->select('id', 'value', 'product_attribute_group_id')
                            ->orderBy('sort');
                    }])->orderBy('sort');
            },
            'skus' => function (Builder $query) {
                $query->select('id', 'name', 'bar_no', 'attributes', 'stock', 'price', 'compare_at_price', 'sold_count', 'product_id')
                    ->where('on_sale', true)
                    ->with('product');
            },
        ]);
    }

    #[Computed]
    public function images(): array
    {
        return $this->product
            ->getMedia('product-images')
            ->map(function ($media) {
                return [
                    'origin' => $media->getUrl(),
                    'thumb' => $media->getUrl('thumb'),
                ];
            })->all();
    }

    #[Computed]
    public function skus()
    {
        return $this->product->skus->filter(fn(ProductSku $sku) => $sku->valid());
    }

    #[Computed]
    public function attributeGroups()
    {
        return $this->product->attribute_groups->filter(function (ProductAttributeGroup $group) {
            return $group->attributes->isNotEmpty();
        });
    }

    public function createOrder()
    {
        dd($this->skuId);
    }

    public function render(): View
    {
        return view('livewire.products.product-show')
            ->title($this->product->long_title);
    }
}
