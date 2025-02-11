<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->string('template');
            $table->string('title');
            $table->string('username');
            $table->string('font');
            $table->string('color');
            $table->string('position');
            $table->bigInteger('user_id')->unsigned();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('avatar')->default('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTF5-3YjBcXTqKUlOAeUUtuOLKgQSma2wGG1g&s')->nullable();
            $table->string('birthdate');
            $table->string('url')->nullable();
            $table->text('introduce');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
