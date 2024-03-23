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
            $table->id();
            $table->string('name',255);
            $table->dateTime("start_at", $precision = 8)->required();
            $table->dateTime("end_at", $precision = 8)->nullable();
            $table->text("description_en")->nullable();
            $table->text("description_ja")->nullable();
            $table->text("cost")->nullable();
            $table->timestamps();

            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("topic_id")->nullable()->constrained("topics");
            $table->foreignId("location_id")->nullable()->constrained("locations");
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
