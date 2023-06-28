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
        Schema::create('rumble_video', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rumble_channel_id');
            $table->unsignedBigInteger('video_category_id')->nullable();
            $table->text('html');
            $table->string('url', 255)->unique();
            $table->string('title', 255)->unique();
            $table->string('thumbnail', 255);
            $table->string('duration', 15);
            $table->dateTime('uploaded_at');
            $table->unsignedBigInteger('likes_count')->nullable();
            $table->unsignedBigInteger('dislikes_count')->nullable();
            $table->unsignedBigInteger('views_count')->nullable();
            $table->unsignedBigInteger('comments_count')->nullable();
            $table->timestamps();

            $table->foreign('rumble_channel_id')
                ->references('id')
                ->on('rumble_channel')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreign('video_category_id')
                ->references('id')
                ->on('video_category')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumble_video');
    }
};