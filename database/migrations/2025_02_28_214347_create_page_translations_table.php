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
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
			$table->string('locale');
            $table->text('title');
            $table->longText('body')->nullable();
			$table->timestamps();
			
            $table->unique(['page_id', 'locale']);
			$table->foreign('page_id')->references('id')->on('pages')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_translations');
    }
};
