<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_ingresos', function (Blueprint $table) {
            $table->id();

            // 1. Datos Personales
            $table->string('nombre');
            $table->string('apellido_1');
            $table->string('apellido_2');
            $table->string('dni_nie');
            $table->string('email_personal')->nullable();
            $table->string('telefono1');
            $table->string('telefono2')->nullable();

            // 2. Datos Laborales
            $table->string('lugar_trabajo');
            $table->string('centro_coste')->nullable();
            $table->string('responsable_1');
            $table->string('responsable_2')->nullable();
            $table->string('motivo_alta');
            $table->string('categoria');
            $table->string('departamento');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

            // 3. Configuración de Roles y Permisos
            $table->string('perfil_usuario');
            $table->json('marcas')->nullable(); // Para guardar el array de marcas seleccionadas

            // Permisos específicos (Checks)
            $table->boolean('p_cloud')->default(false);
            $table->boolean('p_vpn')->default(false);
            $table->boolean('p_ventas')->default(false);
            $table->boolean('p_laboral')->default(false);

            // 4. Equipamiento
            $table->boolean('permiso_movil')->default(false);
            $table->boolean('permiso_email')->default(false);
            $table->boolean('permiso_vehiculo')->default(false);
            $table->boolean('ordenador_sobremesa')->default(false);
            $table->boolean('ordenador_portatil')->default(false);
            $table->boolean('monitor')->default(false);
            $table->boolean('impresora')->default(false);

            // 5. Observaciones
            $table->text('observaciones')->nullable();

            // Remitente
            $table->string('nombre_remitente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_ingresos');
    }
};
