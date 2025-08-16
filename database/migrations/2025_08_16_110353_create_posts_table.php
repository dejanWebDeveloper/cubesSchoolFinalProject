<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('heading', 200);
            $table->string('preheading', 500);
            $table->text('text', 3000);
            $table->string('photo')->nullable();
            $table->integer('category_id');
            $table->integer('author');
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('enable')->default(1);
            $table->boolean('important')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
