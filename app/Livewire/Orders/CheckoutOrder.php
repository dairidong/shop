<?php

namespace App\Livewire\Orders;

use App\Concerns\Livewire\HasAddresses;
use App\Models\ProductSku;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * @property ProductSku $sku
 * @property string $totalAmount
 */
class CheckoutOrder extends Component
{
    use HasAddresses;

    #[Url(as: 'sku')]
    public int $skuId;

    #[Url]
    public int $quantity;

    public function mount()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->redirectRoute('home');
        }
    }

    public function render()
    {
        return view('livewire.orders.checkout-order')
            ->title('确认订单');
    }

    #[Computed]
    public function sku(): ProductSku
    {
        return ProductSku::query()->find($this->skuId);
    }

    #[Computed]
    public function totalAmount(): string
    {
        return bcmul($this->sku->price, $this->quantity);
    }

    public function createOrder(OrderService $service)
    {
        $this->validate();

        $items = [
            ['sku' => $this->sku, 'quantity' => $this->quantity],
        ];

        DB::transaction(function () use ($items, $service) {
            /** @var User $user */
            $user = auth()->user();

            return $service->createOrder($items, $this->currentAddress, $user);
        });

        // todo
        $this->redirectRoute('profile', navigate: true);
    }

    public function rules(): array
    {
        return [
            'skuId' => [
                'required',
                Rule::exists('product_skus', 'id')->where('on_sale', true),
                function ($attribute, $value, $fail) {
                    if (!$this->sku->valid) {
                        $fail('商品不可用');
                    }

                    if (! $this->sku->on_sale || ! $this->sku->product->on_sale) {
                        $fail('商品未上架');
                    }

                    if ($this->sku->stock < $this->quantity) {
                        $fail('库存不足');
                    }
                },
            ],
            'quantity' => [
                'required',
                'min:1',
                'max:'.$this->sku->stock,
            ],
        ];
    }
}
