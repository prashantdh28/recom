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
        Schema::create('cron_logs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Command Name');
            $table->json('arguments')->nullable()->comment('Command Arguments|Paremeters');
            $table->string('error_msg')->nullable();
            $table->enum('status', [0, 1, 2])->default(0)->comment('0 = Pending, 1 = Success, 2 = Error');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cron_logs');
    }
};
