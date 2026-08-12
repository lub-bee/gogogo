<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('gogogo');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->text('description_en')->nullable();
            $table->text('description_ja')->nullable();
            $table->dateTime('published_at')->nullable()->index();
            $table->unsignedInteger('cost')->nullable();
            $table->string('source_doc_id')->nullable()->unique();
            $table->foreignId('topic_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
