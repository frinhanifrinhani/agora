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
        Schema::create('news_history', function (Blueprint $table) {

            $table->enum('action', ['create', 'update', 'status_true','status_false', 'publish','unpublish']);

            $table->foreignId('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('restrict');

            $table->foreignId('news_id')
            ->references('id')
            ->on('news')
            ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_history');
    }
};
