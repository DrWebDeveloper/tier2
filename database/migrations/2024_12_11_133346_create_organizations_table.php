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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('rid')->unique();
            $table->string('name');
            $table->text('sponsorships')->nullable();
            $table->text('sponsorship_logos')->nullable();
            $table->text('sponsorship_names')->nullable();
            $table->text('sponsorship_websites')->nullable();
            $table->text('logo')->nullable();
            $table->string('country')->nullable();
            $table->text('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
