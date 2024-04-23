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
        Schema::table('medias', function (Blueprint $table) {
            //remove old description columns
            $table->dropColumn("description_en");
            $table->dropColumn("description_ja");

            //add new legend column, to replace description
            $table->text("legend")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medias', function (Blueprint $table) {
            //recreate the description columns
            $table->text("description_en")->nullable();
            $table->text("description_ja")->nullable();
        });
    }
};
