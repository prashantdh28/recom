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
        Schema::create('product_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_config_id')->constrained('accounts', 'id');
            $table->foreignId('product_file_id')->comment('Primary Key of transparency_product_files table')->constrained('transparency_product_files', 'id');
            $table->string('brand', 50);
            $table->string('product_name');
            $table->string('product_status', 20);
            $table->string('gtin', 20);
            $table->string('sku', 50)->unique();
            $table->string('asin', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_lists');
    }
};
