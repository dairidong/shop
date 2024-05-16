<?php

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Order::class)->index();
            $table->string('method')->comment('支付方式');
            $table->string('no')->comment('支付平台订单号');
            $table->json('notify_content')->comment('支付平台查询响应');
            $table->string('notify_mode')->comment('支付平台响应方式：异步通知 callback / 主动查询 query');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
