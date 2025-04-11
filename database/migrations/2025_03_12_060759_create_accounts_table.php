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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('client_id');
            $table->text('client_secret');
            $table->text('access_token')->nullable();
            $table->unsignedTinyInteger('api_status')->nullable()->comment('1 = Working, 2 = Error');
            $table->boolean('status')->default(false);
            $table->dateTime('token_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
