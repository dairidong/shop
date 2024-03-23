<?php

namespace App\Livewire\Products;

use App\Enums\ProductSort;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    #[Url(as: 's', history: true, except: '')]
    public string $search = '';

    #[Url]
    public ProductSort|string $sort = ProductSort::DEFAULT;

    public function render(): View
    {
        $query = Product::whereOnSale(true);

        if ($this->search !== '') {
            $query->where(function (Builder $query) {
                return $query->where('title', 'like', "%$this->search%")
                    ->orWhere('long_title', 'like', "%$this->search%");
            });
        }

        switch ($this->sort) {
            case ProductSort::RATING_ASC:
                $query->orderBy('rating');
                break;
            case ProductSort::RATING_DESC:
                $query->orderByDesc('rating');
                break;
            case ProductSort::PRICE_ASC:
                $query->orderBy('price');
                break;
            case ProductSort::PRICE_DESC:
                $query->orderByDesc('price');
                break;
            default:
        }
        $products = $query->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('livewire.products.product-list', [
            'products' => $products,
        ])->title(__('Shop'));
    }
}
