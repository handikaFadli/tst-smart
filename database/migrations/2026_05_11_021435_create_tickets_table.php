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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('kode_ticket')->unique();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            // user pelapor
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // support yang handle
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('judul');
            $table->text('deskripsi');

            $table->foreignId('category_id')
                ->constrained('ticket_categories')
                ->cascadeOnDelete();

            $table->enum('priority', [
                'low',
                'medium',
                'high',
            ])->default('medium');

            $table->enum('status', [
                'open',
                'in_progress',
                'pending',
                'resolved',
                'closed',
                'cancelled'
            ])->default('open');

            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
