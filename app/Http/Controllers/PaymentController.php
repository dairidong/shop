<?php

namespace App\Http\Controllers;

use App\Enums\AlipayNotifyStatus;
use App\Events\OrderPaid;
use App\Models\Order;
use Yansongda\LaravelPay\Facades\Pay;

class PaymentController extends Controller
{
    public function alipay(Order $order)
    {
        $this->authorize('own', $order);

        return Pay::alipay()->web([
            'out_trade_no' => $order->no,
            'total_amount' => $order->amount,
            'subject' => '支付 '.config('app.name').' 的订单 '.$order->no,
            'time_expire' => $order->paid_expired_at->format('Y-m-d H:i:s'),
            'request_from_url' => route('orders.show', [$order]),
            // Yansongda/Pay required an additional '_' for urls
            '_return_url' => route('payment.alipay.return'),
            '_notify_url' => route('payment.alipay.notify'),
        ]);
    }

    public function alipayReturn()
    {
        Pay::alipay()->callback();

        return redirect()->route('orders.show');
    }

    public function alipayNotify()
    {
        $request = Pay::alipay()->callback();

        $no = $request->get('out_trade_no');

        if (! AlipayNotifyStatus::success($request->get('trade_status'))) {
            return Pay::alipay()->success();
        }

        $order = Order::query()->where('no', $no)->first();

        if (! $order) {
            return 'fail';
        }

        if ($order->paid_at) {
            return Pay::alipay()->success();
        }

        event(new OrderPaid($order, $request));

        return Pay::alipay()->success();
    }
}
