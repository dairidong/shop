<?php

use App\Enums\OrderShipStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no')->unique()->comment('订单号');
            $table->foreignIdFor(User::class)->index();
            $table->json('address')->comment('收货地址');
            $table->unsignedDecimal('amount', 10, 2)->default(0)->comment('订单总计');
            $table->text('remark')->nullable()->comment('备注');
            $table->dateTime('paid_at')->nullable()->comment('支付时间');
            $table->boolean('closed')->default(false)->comment('是否关闭');
            $table->boolean('reviewed')->default(false)->comment('是否已评论');
            $table->string('ship_status')->default(OrderShipStatus::PENDING)->comment('配送状态');
            $table->json('ship_data')->nullable()->comment('物流信息');
            $table->json('extra')->nullable()->comment('额外信息');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
