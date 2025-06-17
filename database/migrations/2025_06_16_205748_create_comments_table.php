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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Post
            $table->foreignId(column: 'coffee_id')->constrained()->cascadeOnDelete();
            // Commenter
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Parent comment (Reply)
            $table->foreignId('comment_id')->nullable()->constrained()->cascadeOnDelete();

            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
