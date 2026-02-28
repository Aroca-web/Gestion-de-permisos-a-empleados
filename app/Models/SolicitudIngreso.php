<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudIngreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido_1',
        'apellido_2',
        'dni_nie',
        'email_personal',
        'telefono1',
        'telefono2',
        'lugar_trabajo',
        'centro_coste',
        'responsable_1',
        'responsable_2',
        'motivo_alta',
        'categoria',
        'departamento',
        'fecha_inicio',
        'fecha_fin',
        'perfil_usuario',
        'marcas',
        'p_cloud',
        'p_vpn',
        'p_ventas',
        'p_laboral',
        'permiso_movil',
        'permiso_email',
        'permiso_vehiculo',
        'ordenador_sobremesa',
        'ordenador_portatil',
        'monitor',
        'impresora',
        'observaciones',
        'nombre_remitente',
    ];

    protected $casts = [
        'marcas' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'p_cloud' => 'boolean',
        'p_vpn' => 'boolean',
        'p_ventas' => 'boolean',
        'p_laboral' => 'boolean',
        'permiso_movil' => 'boolean',
        'permiso_email' => 'boolean',
        'permiso_vehiculo' => 'boolean',
        'ordenador_sobremesa' => 'boolean',
        'ordenador_portatil' => 'boolean',
        'monitor' => 'boolean',
        'impresora' => 'boolean',
    ];
}
