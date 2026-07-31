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
        Schema::create('ticket_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('ticket_categories')
                ->cascadeOnDelete();
            $table->string('nama_rule');
            $table->enum('priority', [
                'low',
                'medium',
                'high'
            ]);
            $table->integer('response_time');
            $table->integer('resolution_time');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['category_id', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_rules');
    }
};
