<?php

use App\Models\Product;
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
        Schema::create('product_skus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('规格名称');
            $table->string('bar_no')->comment('sku 编号');
            $table->json('attributes')->comment('商品属性');
            $table->unsignedInteger('stock')->default(0)->comment('库存');
            $table->unsignedDecimal('price', 10, 2)->comment('价格');
            $table->unsignedInteger('compare_at_price', 10, 2)->comment('商品比较原价');
            $table->unsignedInteger('cost', 10, 2)->comment('成本价');
            $table->boolean('on_sale')->default(false)->comment('是否上架');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->foreignIdFor(Product::class)->comment('商品 ID');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_skus');
    }
};
