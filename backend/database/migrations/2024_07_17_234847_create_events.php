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
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->text('organizer');
            $table->text('ddd',2)->nullable();
            $table->text('phone',9)->nullable();
            $table->text('email',80)->nullable();
            $table->text('address')->nullable();
            $table->text('location')->nullable();
            $table->text('location_alias')->nullable();
            $table->text('venue')->nullable();
            $table->text('venue_alias')->nullable();
            $table->text('sidebar_button_link')->nullable();
            $table->boolean('publicated')->default(false);
            $table->timestamp('publication_date')->nullable();

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
