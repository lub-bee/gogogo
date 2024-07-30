<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //events
     public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug',128)->nullable(false)->unique();
        });
    }
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn("slug");
        });
    }

    //topics
    public function up(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->string('slug',128)->nullable(false)->unique();
        });
    }
    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn("slug");
        });
    }

    //locations
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('slug',128)->nullable(false)->unique();
        });
    }
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn("slug");
        });
    }
};
    /**
     * Reverse the migrations.
     */
//     public function down(): void
//     {
//         Schema::table('events', function (Blueprint $table) {
//             $table->dropColumn("slug");
//         });

//         Schema::table('topics', function (Blueprint $table) {
//             $table->dropColumn("slug");
//         });

//         Schema::table('locations', function (Blueprint $table) {
//             $table->dropColumn("slug");
//         });
//     }
// };
