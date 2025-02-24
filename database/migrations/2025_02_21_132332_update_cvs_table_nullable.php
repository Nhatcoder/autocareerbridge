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
        Schema::table('cvs', function (Blueprint $table) {
            $table->string('template')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('username')->nullable()->change();
            $table->string('font')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('birthdate')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->string('template')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->string('username')->nullable(false)->change();
            $table->string('font')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
            $table->string('position')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('birthdate')->nullable(false)->change();
        });
    }
};
