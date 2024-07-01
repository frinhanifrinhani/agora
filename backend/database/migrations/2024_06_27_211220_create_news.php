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
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('news_body');
            $table->string('alias')->unique();
            $table->boolean('status')->default(true);
            $table->date('publication_date');

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreignId('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
