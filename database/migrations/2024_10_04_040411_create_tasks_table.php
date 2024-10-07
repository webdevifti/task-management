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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('task_number')->nullable();
            $table->unsignedBigInteger('assigned_to');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['Pending','In Progress','Completed'])->nullable();
            $table->date('due_date')->nullable();
            $table->string('image')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->timestamps();
            $table->foreign('assigned_to')
            ->references('id')->on('users')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
