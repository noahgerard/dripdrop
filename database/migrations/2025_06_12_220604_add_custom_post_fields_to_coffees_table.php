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
        Schema::table('coffees', function (Blueprint $table) {
            $table->boolean('is_custom')->default(false);
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->string('img_url')->nullable();
            $table->string('del_img_url')->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coffees', function (Blueprint $table) {
            $table->dropColumn([
                'is_custom',
                'title',
                'desc',
                'img_url',
                'del_img_url',
                'type',
            ]);
        });
    }
};
