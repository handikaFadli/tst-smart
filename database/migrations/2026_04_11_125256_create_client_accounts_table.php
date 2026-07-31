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
        Schema::create('client_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_app_id')
                ->constrained('client_apps')
                ->cascadeOnDelete();

            $table->string('username');
            $table->string('password');
            $table->enum('tipe_akun', ['sekolah', 'support'])->default('support');
            $table->text('catatan')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('client_app_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_accounts');
    }
};
