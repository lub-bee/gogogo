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
            $table->dateTime("start_at", $precision = 5)->required();
            $table->dateTime("end_at", $precision = 5)->nullable();
            $table->text("description_en")->nullable();
            $table->text("description_ja")->nullable();
            $table->date('published_at') ->nullable();
            $table->string("cost", 255)->nullable();
            $table->timestamps();

            $table->foreignId("user_id")->nullable()->constrained("users")->onDelete("set null");
            $table->foreignId("topic_id")->nullable()->default(null)->constrained("topics")->onDelete("set null");
            $table->foreignId("location_id")->nullable()->default(null)->constrained("locations")->onDelete("set null");
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
