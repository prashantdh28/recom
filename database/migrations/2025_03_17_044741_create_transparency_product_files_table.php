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
        Schema::create('transparency_product_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_config_id')->constrained('accounts', 'id')->comment('Primary Key of Accounts Table');
            $table->foreignId('user_id')->constrained('users', 'id')->comment('Primary Key of Users Table');
            $table->string('file_name');
            $table->unsignedTinyInteger('processing_status')->default(0);
            $table->string('error_file_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_product_files');
    }
};
