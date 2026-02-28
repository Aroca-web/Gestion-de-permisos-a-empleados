<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logodeempresa.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Ingreso nuevo a plantilla-ArocaComputers</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="container-fluid">
    <img id="logo" src="{{ asset('img/logodeempresa.png') }}" alt="*" class="mx-auto d-block mb-4 rounded" />
    <form id="formulario" action="{{ route('solicitud-ingreso.store') }}" method="POST">
        @csrf
        <!-- Boton de inicio sesion admin -->
        <div class="text-end mb-3">
            <button class="btn btn-dark shadow-sm" id="btn-admin" type="button" data-bs-toggle="modal"
                data-bs-target="#adminLoginModal">
                <i class="bi bi-shield-lock-fill me-2"></i> Administrador
            </button>
        </div>
        <!-- MIGAS DE PAN -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-center">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Altas de empleados</a></li>
                <li class="breadcrumb-item"><a href="{{ route('Bajas') }}">Bajas de empleados</a></li>
                <li class="breadcrumb-item"><a href="{{ route('agregarPermisos') }}">Agregar Permisos</a></li>
            </ol>
        </nav>
        <h2 class="mb-4">Formulario de bajas de empleados</h2>
        <!-- Datos personales -->
        <section id="Datos personales">
            <div class="accordion col-md-12">
                <div class="accordion-item">
                    <button id="btn-person" class="accordion-header" type="button">
                        <span><i class="bi bi-person-badge-fill me-2 text-primary"></i> 1. Datos Personales</span>
                        <i class="bi bi-1-square"><i class="bi bi-chevron-down text-muted ms-2"></i></i>
                    </button>
                    <div class="accordion-content">
                        <div class="text-start mx-auto row">
                            <div class="col-md-4">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="Nombre" placeholder="Nombre" required>
                            </div>
                            <div class="col-md-4">
                                <label for="1º Apellido">Primer Apellido</label>
                                <input type="text" name="Apellido_1" placeholder="1º Apellido" required>
                            </div>
                            <div class="col-md-4">
                                <label for="2º Apellido">Segundo Apellido</label>
                                <input type="text" name="Apellido_2" placeholder="2º Apellido" required>
                            </div>
                            <div class="col-md-3">
                                <label for="DNI o NIE">DNI o NIE</label>
                                <input type="text" name="DNI_NIE" id="dni" placeholder="DNI o NIE" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email-personal">E-mail personal</label>
                                <input type="text" name="Email_Personal" class="w-100" id="email-personal"
                                    placeholder="Correo Electrónico">
                                <div id="errorEmail" class="text-danger mt-1"></div>
                            </div>
                            <div class="col-md-4">
                                <div><label for="email-corporativo">Teléfonos</label></div>
                                <div class="d-flex">
                                    <input id="telefono1" class="mx-2" type="text" name="telefono1"
                                        placeholder="Telefono 1" required>
                                    <input class="mx-2" type="text" name="telefono2" placeholder="Telefono 2">
                                </div>
                                <div id="errorTelefono" class="text-danger mt-1"></div>
                            </div>
                        </div>
                    </div>
        </section>
        <!-- Datos laborales -->
        <section id="Datos laborales">
            <div class="accordion col-md-12">
                <div class="accordion-item">
                    <button id="btn-labo" class="accordion-header" type="button">
                        <span><i class="bi bi-briefcase-fill me-2 text-primary"></i> 2. Datos laborales</span>
                        <i class="bi bi-2-square"><i class="bi bi-chevron-down text-muted ms-2"></i></i>
                    </button>
                    <div class="accordion-content">
                        <div class="row text-start mx-auto">
                            <!-- Fila 1 -->
                            <div class="col-md-4">
                                <label for="Lugar de trabajo">Lugar de trabajo</label>
                                <input type="text" name="Lugar_Trabajo" placeholder="Lugar de trabajo" required>
                            </div>
                            <div class="col-md-4">
                                <label for="Responsable_1">1º Responsable</label>
                                <input type="text" name="Responsable_1" placeholder="Responsable" required>
                            </div>
                            <div class="col-md-4">
                                <label for="Responsable_2">2º Responsable</label>
                                <input type="text" name="Responsable_2" placeholder="Segundo responsable">
                            </div>

                            <!-- Fila 2 -->
                            <div class="col-md-4">
                                <label for="Motivo de alta">Motivo de alta</label>
                                <select class="form-select p-2" name="Motivo de alta" id="Motivo de alta" required>
                                    <option value="" disabled selected>Selecciona un motivo</option>
                                    <option value="Ingreso">Ingreso</option>
                                    <option value="Sustitución">Sustitución</option>
                                    <option value="Becario">Becario/Practicas</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Categoria">Categoría</label>
                                <select class="form-select p-2" name="Categoria" id="Categoria" required>
                                    <option value="" disabled selected>Selecciona una categoría</option>
                                    <option value="Administrativo">Administrativo</option>
                                    <option value="Comercial">Comercial</option>
                                    <option value="Técnico">Técnico</option>
                                    <option value="Contable">Contable</option>
                                    <option value="Mecánico">Mecánico</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Departamento">Departamento</label>
                                <select class="form-select p-2" name="Departamento" id="Departamento" required>
                                    <option value="" disabled selected>Selecciona un departamento</option>
                                    <option value="Administrativo">Administrativo</option>
                                    <option value="Comercial">Comercial</option>
                                    <option value="Taller">Taller</option>
                                    <option value="RRHH">RRHH</option>
                                    <option value="IT">IT</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Ventas">Ventas</option>
                                    <option value="Servicio Técnico">Servicio Técnico</option>
                                </select>
                            </div>

                            <!-- Fila 3 -->
                            <div class="col-md-6">
                                <label for="Fecha de inicio">Fecha de inicio</label>
                                <input class="form-control" type="date" name="Fecha_Inicio" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Fecha de fin">Fecha de fin</label>
                                <input class="form-control" type="date" name="Fecha_Fin">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Permisos -->
        <section id="configuracion-accesos">
            <div class="accordion col-md-12">
                <div class="accordion-item">
                    <button id="btn-permisos" class="accordion-header" type="button">
                        <span><i class="bi bi-shield-lock-fill me-2 text-primary"></i> 3. Configuración de Roles y
                            Permisos</span>
                        <i class="bi bi-3-square"><i class="bi bi-chevron-down text-muted ms-2"></i></i>
                    </button>
                    <div class="accordion-content">
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-4">
                                <label for="perfil-usuario" class="form-label fw-bold">Perfil Funcional</label>
                                <select class="form-select" id="perfil-usuario" name="perfil_usuario" required>
                                    <option value="defauld" disabled selected>Seleccione un rol...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->slug }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold d-block">Seleccionar Marcas Vinculadas</label>
                                <button type="button" class="btn btn-outline-dark w-100" data-bs-toggle="modal"
                                    data-bs-target="#modalCategorias">
                                    Configurar Áreas de Trabajo
                                </button>
                                <div id="marcas-seleccionadas-info" class="mt-2 text-muted small">Ninguna marca
                                    seleccionada</div>
                            </div>
                        </div>

                        <div id="grid-permisos" class="row mt-4 g-3 checks text-start">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="permiso-nube" class="form-check-input m-3"
                                        name="p_cloud">
                                    <label for="permiso-nube" class="mb-0 mt-0">Acceso Cloud Storage</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="permiso-vpn" class="form-check-input m-3" name="p_vpn">
                                    <label for="permiso-vpn" class="mb-0 mt-0">Acceso VPN Corporativa</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="permiso-ventas" class="form-check-input m-3"
                                        name="p_ventas">
                                    <label for="permiso-ventas" class="mb-0 mt-0">Acceso a aplicación de ventas</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="permiso-laboral" class="form-check-input m-3"
                                        name="p_laboral">
                                    <label for="permiso-laboral" class="mb-0 mt-0">Acceso a aplicación de gestión
                                        laboral</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Equipamiento -->
        <section id="Equipamiento">
            <div class="accordion col-md-12">
                <div class="accordion-item">
                    <button id="btn-equipo" class="accordion-header" type="button">
                        <span><i class="bi bi-laptop-fill me-2 text-primary"></i> 4. Equipamiento</span>
                        <i class="bi bi-4-square"><i class="bi bi-chevron-down text-muted ms-2"></i></i>
                    </button>
                    <div class="accordion-content">
                        <div class="row g-3 checks text-start">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-2 rounded ">
                                    <input type="checkbox" id="telefono-movil" name="Permiso_Movil"
                                        class="form-check-input m-3">
                                    <label for="telefono-movil" class="mb-0 mt-0">Teléfono Movil</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="correo-electronico" name="Permiso_Email"
                                        class="form-check-input m-3">
                                    <label for="correo-electronico" class="mb-0 mt-0">Correo Electrónico</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="v-empresa" name="Permiso_Vehiculo"
                                        class="form-check-input m-3">
                                    <label for="v-empresa" class="mb-0 mt-0">Vehículo empresa</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="o-empresa" name="ordenador-sobremesa"
                                        class="form-check-input m-3">
                                    <label for="o-empresa" class="mb-0 mt-0">Ordenador de sobremesa</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="o-portatil" name="o-portatil"
                                        class="form-check-input m-3">
                                    <label for="o-portatil" class="mb-0 mt-0">Ordenador portátil</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="monitor" name="monitor" class="form-check-input m-3">
                                    <label for="monitor" class="mb-0 mt-0">Monitor</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-2 rounded">
                                    <input type="checkbox" id="impresora" name="impresora" class="form-check-input m-3">
                                    <label for="impresora" class="mb-0 mt-0">Impresora</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal marcas/campañas que trabaja la empresa -->
        <div class="modal fade" id="modalCategorias" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Áreas / Campañas / Marcas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3" id="contenedor-categorias">
                            @foreach($brands as $brand)
                                <div class="col-6">
                                    <input class="form-check-input check-marca" type="checkbox" value="{{ $brand->slug }}"
                                        id="cat-{{ $brand->slug }}" name="marcas[]">
                                    <label for="cat-{{ $brand->slug }}">{{ $brand->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-action="toggle-group"
                            data-target=".check-marca">Marcar Todas</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Observaciones -->
        <section id="Observaciones">
            <div class="accordion col-md-12">
                <div class="accordion-item">
                    <button id="btn-obser" class="accordion-header" type="button">
                        <span><i class="bi bi-chat-text-fill me-2 text-primary"></i> 5. Observaciones</span>
                        <i class="bi bi-5-square"><i class="bi bi-chevron-down text-muted ms-2"></i></i>
                    </button>
                    <div class="accordion-content justify-content-center text-center">
                        <div class="row" id="observaciones-wrapper">
                            <div class="col-md-10 mx-auto text-start">
                                <textarea class="mb-4" name="observaciones" id="observaciones" rows="10" cols="60"
                                    placeholder="Escribe aquí tus observaciones..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contenedor de remitente -->
        <div id="remitente-field-container" class="text-start mx-auto row mt-4">
            <div class="col-md-5">
                <label for="nombre-remitente">Nombre del remitente</label>
                <input id="nombre-remitente" name="Nombre_Remitente" type="text" placeholder="Nombre" required>
            </div>
        </div>

        <!-- Contenedor oculto para el resumen de impresión -->
        <div id="print-summary" class="mb-4"></div>

        <!-- Botones -->
        <div class="mt-5 mb-4 mx-auto d-flex justify-content-between">
            <button class="text-start btn btn-secondary" type="reset">Limpiar formulario</button>
            <button class="btn btn-success" id="btn-enviar" type="submit">Enviar</button>
            <button type="button" id="btn-print-smart" class="btn btn-primary">
                Imprimir
            </button>
        </div>
    </form>

    <!-- Admin Login Modal -->
    <div class="modal fade" id="adminLoginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-dark">Acceso Administrador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="adminLoginForm">
                        <div class="mb-3 text-start">
                            <label for="adminUser" class="form-label text-dark">Usuario</label>
                            <input type="text" class="form-control" id="adminUser" placeholder="admin" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="adminPass" class="form-label text-dark">Contraseña</label>
                            <input type="password" class="form-control" id="adminPass" placeholder="******" required>
                        </div>
                        <div id="loginError" class="text-danger small mb-3 fw-bold"></div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark fw-bold">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- archivos .js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        window.SERVER_MATRIX = @json($matrix);
        window.ADMIN_BUILDER_URL = "{{ route('admin-builder') }}";
    </script>
    <script src="{{ asset('js/admin-login.js') }}"></script>
    <script src="{{ asset('js/desplegables.js') }}"></script>
    <script src="{{ asset('js/perfiles.js') }}"></script>
    <script src="{{ asset('js/config-permisos.js') }}"></script>
    <script src="{{ asset('js/validar.js') }}"></script>
    <script src="{{ asset('js/print.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>