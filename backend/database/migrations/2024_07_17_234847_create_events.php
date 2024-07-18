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
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('body');
            $table->text('alias')->unique();
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->text('organizer');
            $table->text('phone');
            $table->text('email');
            $table->text('address');
            $table->text('sidebar_button_link');
            $table->boolean('publicated')->default(false);
            $table->date('publication_date')->nullable();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->comment('Autor');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
