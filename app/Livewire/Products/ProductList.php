<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    #[Url(as: 's')]
    public string $search = '';

    public function render(): View
    {
        $products = Product::whereOnSale(true)
            ->when($this->search !== '', fn (Builder $query) => $query->where(function (Builder $query) {
                return $query->where('title', 'like', "%$this->search%")
                    ->orWhere('long_title', 'like', "%$this->search%");
            }))
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('livewire.products.product-list', [
            'products' => $products,
        ])->title(__('Product'));
    }
}
