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
        Schema::create('transparency_gtin_code_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transparency_product_id')->constrained('product_lists', 'id');
            $table->string('job_id', 30)->nullable()->unique();
            $table->string('location', 100)->nullable()->unique();
            $table->unsignedSmallInteger('number_of_code')->nullable();
            $table->string('gtin', 20)->nullable();
            $table->string('sku', 20)->nullable();
            $table->string('fnsku', 20)->nullable();
            $table->unsignedTinyInteger('label_type')->nullable();
            $table->longText('generated_code')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0-Pending, 1-In Progress, 2-Success, 3-Error');
            $table->text('error')->nullable();
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('updated_by')->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_gtin_code_histories');
    }
};
