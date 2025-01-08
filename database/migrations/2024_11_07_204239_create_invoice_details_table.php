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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->string('tipAfeIgv');
            $table->string('codProducto');
            $table->string('unidad');
            $table->string('descripcion');
            $table->decimal('cantidad',8,2);
            $table->decimal('mtoValorUnitario',8,2);
            $table->decimal('mtoValorVenta',8,2);
            $table->decimal('mtoBaseIgv',8,2);
            $table->decimal('porcentajeIgv',8,2);
            $table->decimal('igv',8,2);
            $table->decimal('totalImpuestos',8,2);
            $table->decimal('mtoPrecioUnitario',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
