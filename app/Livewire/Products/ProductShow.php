<?php

namespace App\Livewire\Products;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Models\ProductSku;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class ProductShow extends Component
{
    #[Locked]
    public Product $product;

    public int $skuId;

    public int $quantity = 1;

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
        return $this->product->skus->filter(fn (ProductSku $sku) => $sku->valid);
    }

    #[Computed]
    public function attributeGroups()
    {
        return $this->product->attribute_groups->filter(function (ProductAttributeGroup $group) {
            return $group->attributes->isNotEmpty();
        });
    }

    #[Renderless]
    public function addToCart(Redirector $redirector): void
    {
        if (! Auth::check()) {
            session()->flash('status', __('You need to login!'));
            $redirector->setIntendedUrl(route('products.show', ['product' => $this->product]));
            $this->redirectRoute('login', navigate: true);

            return;
        }

        if (! $this->product->on_sale) {
            return;
        }

        $this->validate();

        $sku = $this->product->skus()->find($this->skuId);
        if (! $sku || ! $sku->valid) {
            return;
        }

        if ($this->quantity > 0 && $sku->stock < $this->quantity) {
            return;
        }

        $user = Auth::user();
        if ($cart = $user->cartItems()->where('product_sku_id', $sku->id)->first()) {
            $cart->increment('quantity', $this->quantity);
        } else {
            $cart = new CartItem([
                'quantity' => $this->quantity,
                'checked' => true,
            ]);
            $cart->product_sku()->associate($sku);
            $cart->user()->associate($user);
            $cart->product()->associate($sku->product_id);
            $cart->save();
        }

        $this->dispatch('add-to-cart');
        $this->dispatch('cart-update');
    }

    public function createOrder()
    {

    }

    public function rules(): array
    {
        return [
            'skuId' => 'required',
            'quantity' => 'required|integer|min:1',

        ];
    }

    public function render(): View
    {
        return view('livewire.products.product-show')
            ->title($this->product->long_title);
    }
}
