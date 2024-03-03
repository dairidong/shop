<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_attribute_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('商品属性组名称');
            $table->foreignIdFor(Product::class)->index()->comment('商品ID');
            $table->unsignedBigInteger('sort')->comment('排序');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'product_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_groups');
    }
};
