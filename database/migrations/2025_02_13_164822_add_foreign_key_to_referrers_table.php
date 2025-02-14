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
        Schema::table('referrers', function (Blueprint $table) {
            $table->foreignId('cv_id')->change()->constrained('cvs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrers', function (Blueprint $table) {
            $table->dropForeign(['cv_id']);
        });
    }
};
