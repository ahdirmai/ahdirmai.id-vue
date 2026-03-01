<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('role')->default('Software Engineer');
            $table->text('summary_id');
            $table->text('summary_en');
            $table->string('focus_text_id');
            $table->string('focus_text_en');
            $table->integer('years_of_experience')->default(2);
            $table->json('position_tags')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
    }
};
