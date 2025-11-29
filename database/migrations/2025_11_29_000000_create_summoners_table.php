<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    /**sumonners */
    public function up(): void
    {
        Schema::create('summoners', function (Blueprint $table) {
            $table->id();
            $table->string('summoner_id')->nullable(); // encrypted id from v4
            $table->string('puuid')->unique();
            $table->string('game_name'); // riot id name
            $table->string('tag_line'); // riot id tag
            $table->string('tier')->nullable(); // iron, bronze, etc
            $table->string('rank')->nullable(); // i, ii, iii, iv
            $table->integer('league_points')->default(0);
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
            $table->integer('profile_icon_id')->nullable();
            $table->integer('summoner_level')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summoners');
    }
};
