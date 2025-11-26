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
    Schema::create('events', function (Blueprint $table) {
        $table->id();

        // the user who created/owns the event
        $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');

        $table->string('title');
        $table->string('slug')->unique()->nullable();
        $table->text('description')->nullable();
        $table->string('venue')->nullable();
        $table->boolean('is_virtual')->default(false);

        $table->dateTime('start_at');
        $table->dateTime('end_at');

        $table->integer('capacity')->nullable();
        $table->string('thumbnail')->nullable();

        // event status
        $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

        $table->timestamps();
        $table->softDeletes();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
