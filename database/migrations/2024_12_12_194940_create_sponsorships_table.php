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
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();
            $table->string('rid')->unique()->comment('Record ID');
            $table->json('esports_orgs')->nullable()->comment('Esports Organization ID');
            $table->string('industry_rid')->nullable()->comment('Industry ID');
            $table->string('name');
            $table->json('logo')->nullable();
            $table->text('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorships');
    }
};
