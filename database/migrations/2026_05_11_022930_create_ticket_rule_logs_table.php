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
        Schema::create('ticket_rule_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('ticket_rule_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamp('response_deadline');

            $table->timestamp('resolution_deadline');

            $table->timestamp('first_response_at')->nullable();

            $table->timestamp('resolved_at')->nullable();

            $table->timestamp('assigned_at')->nullable();

            $table->boolean('response_breached')->default(false);

            $table->boolean('resolution_breached')->default(false);

            $table->enum('status', [
                'pending',
                'on_time',
                'warning',
                'breach'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_rule_logs');
    }
};
