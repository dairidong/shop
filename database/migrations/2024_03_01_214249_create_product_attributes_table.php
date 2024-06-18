<?php

use App\Models\ProductAttributeGroup;
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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('value')->comment('商品属性值');
            $table->foreignIdFor(ProductAttributeGroup::class)->index()->comment('商品属性组ID');
            $table->unsignedBigInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['value', 'product_attribute_group_id', 'deleted_at'], 'unique_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
