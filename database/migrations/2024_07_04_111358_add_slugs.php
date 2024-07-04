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
        //events
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug',128)->nullable(false)->unique();
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->string('slug',128)->nullable(false)->unique();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->string('slug',128)->nullable(false)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn("slug");
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn("slug");
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn("slug");
        });
    }
};
