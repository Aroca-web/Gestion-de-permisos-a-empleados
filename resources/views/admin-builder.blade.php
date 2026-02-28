<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Configuración de Permisos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="{{ asset('img/candado.png') }}">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="py-5">
    <div class="container">
        <!-- Header -->
        <header class="d-flex justify-content-between align-items-center mb-5 fade-in">
            <div>
                <h1 class="h2 mb-1">Panel de Administración</h1>
                <p class="text-muted m-0">Gestiona roles, marcas y matrices de permisos.</p>
            </div>
            <div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Formulario
                </a>
            </div>
        </header>

        <form method="POST" onsubmit="return false;"> <!-- Prevent default submit, handled by JS -->
            <div class="row g-4">
                <!-- Left Sidebar: Definitions -->
                <div class="col-lg-4">
                    <!-- Roles Card -->
                    <div class="admin-card fade-in" style="animation-delay: 0.1s;">
                        <div class="card-header">
                            <div><i class="bi bi-people-fill card-header-icon"></i> Roles</div>
                            <span class="badge bg-light text-dark shadow-sm">Definición</span>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-4">
                                <input type="text" id="new-role" class="form-control" placeholder="Nuevo rol...">
                                <button class="btn btn-primary" type="button" id="btn-add-role">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                            <ul class="list-group list-group-flush" id="list-roles">
                                <!-- Dynamic Roles -->
                            </ul>
                        </div>
                    </div>

                    <!-- Brands Card -->
                    <div class="admin-card fade-in" style="animation-delay: 0.2s;">
                        <div class="card-header">
                            <div><i class="bi bi-tags-fill card-header-icon"></i> Marcas</div>
                            <span class="badge bg-light text-dark shadow-sm">Campañas</span>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-4">
                                <input type="text" id="new-brand" class="form-control" placeholder="Nueva marca...">
                                <button class="btn btn-primary" type="button" id="btn-add-brand">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                            <ul class="list-group list-group-flush" id="list-brands">
                                <!-- Dynamic Brands -->
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Matrix Builder -->
                <div class="col-lg-8">
                    <div class="admin-card fade-in" style="animation-delay: 0.3s;">
                        <div class="card-header">
                            <div><i class="bi bi-sliders card-header-icon"></i> Matriz de Permisos</div>
                            <button type="button" class="btn btn-success btn-sm" id="btn-save-matrix">
                                <i class="bi bi-save"></i> Guardar Configuración
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-4 p-3 bg-white rounded shadow-sm border">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Rol
                                        Seleccionado</label>
                                    <select class="form-select" id="matrix-role">
                                        <option value="" disabled selected>Seleccionar rol...</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Marca
                                        Seleccionada</label>
                                    <select class="form-select" id="matrix-brand">
                                        <option value="" disabled selected>Seleccionar marca...</option>
                                    </select>
                                </div>
                            </div>

                            <div id="permissions-container" style="display:none;">
                                <div class="alert alert-light border-start border-4 border-primary shadow-sm mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill text-primary me-2 fs-5"></i>
                                        <div>
                                            <strong>Editando:</strong> <span id="current-selection"
                                                class="text-primary fw-bold"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="permission-grid">
                                    <!-- Permission Items -->
                                    <label class="permission-item">
                                        <input class="form-check-input perm-check" type="checkbox" value="permiso-nube"
                                            id="p-nube">
                                        <span>Cloud Storage</span>
                                    </label>

                                    <label class="permission-item">
                                        <input class="form-check-input perm-check" type="checkbox" value="permiso-vpn"
                                            id="p-vpn">
                                        <span>VPN Corporativa</span>
                                    </label>

                                    <label class="permission-item">
                                        <input class="form-check-input perm-check" type="checkbox"
                                            value="permiso-ventas" id="p-ventas">
                                        <span>App Ventas</span>
                                    </label>

                                    <label class="permission-item">
                                        <input class="form-check-input perm-check" type="checkbox"
                                            value="permiso-laboral" id="p-laboral">
                                        <span>Gestión Laboral</span>
                                    </label>

                                    <label class="permission-item">
                                        <input class="form-check-input perm-check" type="checkbox"
                                            value="correo-electronico" id="p-email">
                                        <span>Email</span>
                                    </label>

                                    <label class="permission-item">
                                        <input class="form-check-input perm-check" type="checkbox"
                                            value="telefono-movil" id="p-movil">
                                        <span>Móvil</span>
                                    </label>

                                    <label class="permission-item">
                                        <input class="form-check-input perm-check" type="checkbox" value="o-portatil"
                                            id="p-portatil">
                                        <span>Portátil</span>
                                    </label>
                                </div>
                            </div>

                            <div id="placeholder-msg" class="text-center py-5">
                                <i class="bi bi-arrow-up-circle display-4 text-muted opacity-25"></i>
                                <p class="text-muted mt-3">Selecciona un Rol y una Marca arriba para configurar sus
                                    permisos.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Table -->
                    <div class="admin-card fade-in" style="animation-delay: 0.4s;">
                        <div class="card-header border-bottom-0">
                            <div><i class="bi bi-table card-header-icon"></i> Resumen Global</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table custom-table align-middle m-0" id="summary-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%">Rol</th>
                                        <th style="width: 20%">Marca</th>
                                        <th style="width: 50%">Permisos Activos</th>
                                        <th style="width: 10%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- JS will fill this -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/builder.js') }}"></script>
</body>

</html>