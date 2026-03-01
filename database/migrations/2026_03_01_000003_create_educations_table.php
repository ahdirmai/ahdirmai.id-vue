<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('university');
            $table->string('degree_id');
            $table->string('degree_en');
            $table->decimal('gpa', 3, 2)->nullable();
            $table->json('awards')->nullable();
            $table->string('research_title')->nullable();
            $table->string('research_link')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
