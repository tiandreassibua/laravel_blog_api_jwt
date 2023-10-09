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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('article_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('article_id')->constrained("articles")->onUpdate('cascade')->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_comments');
        Schema::dropIfExists('articles');
    }
};
