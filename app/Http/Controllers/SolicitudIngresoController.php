<?php

namespace App\Http\Controllers;

use App\Models\SolicitudIngreso;
use Illuminate\Http\Request;

class SolicitudIngresoController extends Controller
{
    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        $roles = \App\Models\Role::all();
        $brands = \App\Models\Brand::all();

        $matrix = [];
        $rawPerms = \App\Models\RoleBrandPermission::with(['role', 'brand', 'permission'])->get();
        foreach ($rawPerms as $rp) {
            $roleSlug = $rp->role->slug;
            $brandSlug = $rp->brand->slug;
            $permSlug = $rp->permission->slug;

            $matrix[$roleSlug] = $matrix[$roleSlug] ?? [];
            $matrix[$roleSlug][$brandSlug] = $matrix[$roleSlug][$brandSlug] ?? [];
            $matrix[$roleSlug][$brandSlug][] = $permSlug;
        }

        return view('index', compact('roles', 'brands', 'matrix'));
    }

    /**
     * Almacena una nueva solicitud en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            // Datos Personales
            'Nombre' => 'required|string|max:255',
            'Apellido_1' => 'required|string|max:255',
            'Apellido_2' => 'required|string|max:255',
            'DNI_NIE' => 'required|string|max:20',
            'Email_Personal' => 'nullable|email|max:255',
            'telefono1' => 'required|string|max:20',
            'telefono2' => 'nullable|string|max:20',

            // Datos Laborales
            'Lugar_Trabajo' => 'required|string|max:255',
            'Centro_Coste' => 'nullable|string|max:255',
            'Responsable_1' => 'required|string|max:255',
            'Responsable_2' => 'nullable|string|max:255',
            'Motivo_de_alta' => 'required|string|max:255', // Name in HTML has spaces??
            'Categoria' => 'required|string|max:255',
            'Departamento' => 'required|string|max:255',
            'Fecha_Inicio' => 'required|date',
            'Fecha_Fin' => 'nullable|date',

            // Roles y Permisos
            'perfil_usuario' => 'required|string|max:100',
            'marcas' => 'nullable|array',

            // Observaciones y Remitente
            'observaciones' => 'nullable|string',
            'Nombre_Remitente' => 'required|string|max:255',
        ]);

        // Mapear nombres del formulario a nombres de la base de datos (si difieren)
        // y manejar los checkboxes (que pueden no venir si no están marcados)
        $data = [
            'nombre' => $request->input('Nombre'),
            'apellido_1' => $request->input('Apellido_1'),
            'apellido_2' => $request->input('Apellido_2'),
            'dni_nie' => $request->input('DNI_NIE'),
            'email_personal' => $request->input('Email_Personal'),
            'telefono1' => $request->input('telefono1'),
            'telefono2' => $request->input('telefono2'),

            'lugar_trabajo' => $request->input('Lugar_Trabajo'),
            'centro_coste' => $request->input('Centro_Coste'),
            'responsable_1' => $request->input('Responsable_1'),
            'responsable_2' => $request->input('Responsable_2'),
            'motivo_alta' => $request->input('Motivo_de_alta') ?? $request->input('Motivo_de_alta'), // Check exact name
            'categoria' => $request->input('Categoria'),
            'departamento' => $request->input('Departamento'),
            'fecha_inicio' => $request->input('Fecha_Inicio'),
            'fecha_fin' => $request->input('Fecha_Fin'),

            'perfil_usuario' => $request->input('perfil_usuario'),
            'marcas' => $request->input('marcas'),

            // Booleanos - usamos $request->has() o filter_var para asegurar true/false
            // Nota: HTML checkboxes envían "on" o nada.
            'p_cloud' => $request->has('p_cloud'),
            'p_vpn' => $request->has('p_vpn'),
            'p_ventas' => $request->has('p_ventas'),
            'p_laboral' => $request->has('p_laboral'),

            'permiso_movil' => $request->has('Permiso_Movil'),
            'permiso_email' => $request->has('Permiso_Email'),
            'permiso_vehiculo' => $request->has('Permiso_Vehiculo'),
            'ordenador_sobremesa' => $request->has('ordenador-sobremesa'),
            'ordenador_portatil' => $request->has('o-portatil'),
            'monitor' => $request->has('monitor'),
            'impresora' => $request->has('impresora'),

            'observaciones' => $request->input('observaciones'),
            'nombre_remitente' => $request->input('Nombre_Remitente'),
        ];

        // Crear el registro
        SolicitudIngreso::create($data);

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Solicitud creada correctamente.');
    }
    /**
     * Muestra el formulario de bajas.
     */
    public function bajas()
    {
        $roles = \App\Models\Role::all();
        $brands = \App\Models\Brand::all();

        $matrix = [];
        $rawPerms = \App\Models\RoleBrandPermission::with(['role', 'brand', 'permission'])->get();
        foreach ($rawPerms as $rp) {
            $roleSlug = $rp->role->slug;
            $brandSlug = $rp->brand->slug;
            $permSlug = $rp->permission->slug;

            $matrix[$roleSlug] = $matrix[$roleSlug] ?? [];
            $matrix[$roleSlug][$brandSlug] = $matrix[$roleSlug][$brandSlug] ?? [];
            $matrix[$roleSlug][$brandSlug][] = $permSlug;
        }

        return view('Bajas', compact('roles', 'brands', 'matrix'));
    }

    /**
     * Muestra el formulario de permisos.
     */
    public function permisos()
    {
        $roles = \App\Models\Role::all();
        $brands = \App\Models\Brand::all();

        $matrix = [];
        $rawPerms = \App\Models\RoleBrandPermission::with(['role', 'brand', 'permission'])->get();
        foreach ($rawPerms as $rp) {
            $roleSlug = $rp->role->slug;
            $brandSlug = $rp->brand->slug;
            $permSlug = $rp->permission->slug;

            $matrix[$roleSlug] = $matrix[$roleSlug] ?? [];
            $matrix[$roleSlug][$brandSlug] = $matrix[$roleSlug][$brandSlug] ?? [];
            $matrix[$roleSlug][$brandSlug][] = $permSlug;
        }
        // Asumiendo que la vista se llamará 'permisos' o reutilizando index por ahora si no se ha creado.
        // Pero para evitar errores si falta la vista, devolveré una cadena simple o la misma vista para pruebas si el usuario lo desea.
        // Dado que el usuario no ha creado 'permisos.blade.php', comentaré esto o devolveré un marcador de posición.
        // El usuario pidió Bajas. Incluiré el método pero tal vez solo devuelva una vista simple o la vista de Bajas si quieren reutilizarla.
        // Lo más seguro es duplicar la lógica pero devolver view('permisos') solo si presumiblemente existirá, de lo contrario dará error.
        // ¿Devolveré view('Bajas') por ahora o crearé una vista básica? No, no debo crear archivos que no me hayan pedido.
        // Me ceñiré a la lógica de 'Bajas'. Añadiré el método 'permisos' vacío o devolviendo 404/texto para evitar el error "Método no encontrado" si hacen clic en el enlace.

        return view('agregarPermisos', compact('roles', 'brands', 'matrix'));
    }
}
