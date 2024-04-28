<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSku;
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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->index();
            $table->foreignIdFor(Product::class)->index();
            $table->foreignIdFor(ProductSku::class)->index();
            $table->unsignedInteger('quantity')->comment('商品数量');
            $table->unsignedDecimal('price', 10, 2)->comment('商品单价');
            $table->json('sku_snapshot')->nullable();
            $table->unsignedInteger('rating')->nullable()->comment('评分');
            $table->text('review')->nullable()->comment('评价');
            $table->timestamp('reviewed_at')->nullable()->comment('评价时间');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
