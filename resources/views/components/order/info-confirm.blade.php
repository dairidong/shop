@props([
    'total',
    'currentAddress' => null
])

<section class="flex flex-col items-end justify-center gap-2 my-6 bg-gray-100 py-6 px-2">
    <div class="flex items-center">
        <span>应付总额：</span>
        <strong class="text-2xl text-active">￥{{ $this->totalAmount }}</strong>
    </div>
    <div class="flex gap-6 text-gray-600">
        <div>寄送至：{{ $currentAddress?->full_address }}</div>
        <div>收件人：{{ $currentAddress?->contact_name }} {{ $currentAddress?->contact_phone }}</div>
    </div>
</section>