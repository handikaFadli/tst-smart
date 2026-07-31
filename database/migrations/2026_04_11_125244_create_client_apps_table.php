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
        Schema::create('client_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->string('url_aplikasi')->nullable();
            $table->integer('jumsis')->default(0);

            $table->string('kode_examol')->nullable();
            $table->string('link_presensi')->nullable();

            $table->date('aktivasi_aplikasi')->nullable();
            $table->date('expired_aplikasi')->nullable();
            $table->date('expired_domain')->nullable();
            $table->enum('status', ['active', 'expired'])->default('active');

            $table->foreignId('server_id')->nullable()->constrained('servers')->nullOnDelete();

            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('aktivasi_aplikasi');
            $table->index('expired_aplikasi');
            $table->index('expired_domain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_apps');
    }
};
