<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->datetime('due_date')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            // $table->unsignedBigInteger('user_id')->nullable();           // implicit default handling
            // $table->foreign('user_id')->references('id')->on('users');
            //$table->foreignId('user_id')->nullable()->constrained();   // second way
            $table->boolean('terms')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
