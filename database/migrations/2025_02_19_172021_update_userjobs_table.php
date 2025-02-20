<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user_jobs', callback: function (Blueprint $table) {
            $table->renameColumn('response_message', 'interview_time');
        });

        Schema::table('user_jobs', function (Blueprint $table) {
            $table->dateTime('interview_time')->nullable()->change();
            $table->tinyInteger('is_seen')->nullable()->after('job_id')->default(0);
            $table->string('cv', 255)->nullable()->after('is_seen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('user_jobs', function (Blueprint $table) {
            $table->string('interview_time', 255)->nullable()->change();
        });

        Schema::table('user_jobs', function (Blueprint $table) {
            $table->renameColumn('interview_time', 'response_message');
            $table->dropColumn('is_seen');
            $table->dropColumn('cv');
        });
    }
};
