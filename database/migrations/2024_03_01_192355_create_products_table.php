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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('商品名称');
            $table->string('long_title')->comment('商品长标题');
            $table->string('product_no')->unique()->comment('商品编号');
            $table->text('description')->comment('商品详情');
            $table->boolean('on_sale')->comment('是否上架');
            $table->float('rating')->default(0)->comment('商品价格');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->unsignedInteger('review_count')->default(0)->comment('评论数量');
            $table->decimal('price')->default(0)->comment('sku 最低价格');
            $table->decimal('compare_at_price')->default(0)->comment('商品比较原价');
            $table->json('extra')->comment('额外信息');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
