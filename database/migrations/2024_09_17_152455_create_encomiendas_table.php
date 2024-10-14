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
        Schema::create('encomiendas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('transportista_id')->constrained('transportistas')->onDelete('cascade')->nullable();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade')->nullable();

            //remitente
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');

            //destinatario
            $table->unsignedBigInteger('customer_dest_id');
            $table->foreign('customer_dest_id')->references('id')->on('customers');
            $table->unsignedBigInteger('sucursal_dest_id');
            $table->foreign('sucursal_dest_id')->references('id')->on('sucursals');

            $table->integer('cantidad');
            $table->decimal('monto', 8, 2);

            $table->boolean('estado_pago')->default(true);
            $table->string('tipo_pago');
            $table->string('tipo_comprobante');
            $table->string('doc_traslado')->nullable();
            $table->string('glosa')->nullable();

            $table->string('estado_encomienda');
            $table->integer('pin')->unsigned();
            $table->boolean('isHome')->default(false);
            $table->boolean('isReturn')->default(false);
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomiendas');
    }
};
