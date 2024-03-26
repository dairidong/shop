<?php

namespace App\Livewire\Products;

use App\Enums\ProductSort;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    #[Url(as: 's', history: true, except: '')]
    public string $search = '';

    #[Url(history: true)]
    public ProductSort|string $sort = ProductSort::DEFAULT;

    #[Url(as: 'categories', history: true)]
    public array $checkedCategories = [];

    #[Url(history: true)]
    public int $min = 0;

    #[Url(history: true)]
    public int $max = 0;

    public function render(): View
    {
        $products = $this->products();

        $categories = Category::query()
            ->select('id', 'name')
            ->where('is_enabled', true)
            ->orderBy('sort')
            ->has('products')
            ->withCount('products')
            ->get();

        return view('livewire.products.product-list', [
            'products' => $products,
            'categories' => $categories,
            'maxPrice' => ceil(Product::query()->max('price') ?? 0),
        ])->title(__('Shop'));
    }

    /**
     * @return LengthAwarePaginator<number,Product>
     */
    public function products(): LengthAwarePaginator
    {
        $query = Product::whereOnSale(true);

        if ($this->search !== '') {
            $query->where(function (Builder $query) {
                return $query->where('title', 'like', "%$this->search%")
                    ->orWhere('long_title', 'like', "%$this->search%")
                    ->orWhereHas('categories', function (Builder $query) {
                        return $query->where('name', 'LIKE', "%{$this->search}%");
                    });
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

        if (count($this->checkedCategories) > 0) {
            $categories = Arr::where(
                Arr::map($this->checkedCategories, function ($value) {
                    return filter_var($value, FILTER_VALIDATE_INT);
                }),
                fn ($value) => ($value !== false && $value > 0)
            );
            $query->whereHas('categories', function (Builder $query) use ($categories) {
                $query->whereIn('id', $categories);
            });
        }

        if ($this->max >= $this->min) {
            if ($this->min > 0) {
                $query->where('price', '>=', $this->min);
            }

            if ($this->max > 0) {
                $query->where('price', '<=', $this->max);
            }
        }

        return $query->paginate(12);
    }

    /**
     * Properties updated hook
     * Rest pagination after filter changed
     */
    public function updated(): void
    {
        $this->resetPage();
        $this->dispatch('close-filter-drawer');
    }
}
