
// --- CONFIGURACIÓN Y ARRANQUE ---
// Definimos la configuración que conecta el HTML con la lógica
const CONFIG = {
    ui: {
        masterSelector: 'perfil-usuario', // ID del <select> de roles
        categoryClass: 'check-marca',     // Clase de los checkboxes del modal de marcas
        feedbackId: 'info-seleccion',     // ID donde mostrar mensajes de error/info
        protectedIds: []                  // IDs de checkboxes que no se deben limpiar automáticamente
    },
    labels: {
        errorNoCategory: '⚠️ Selecciona al menos una marca en "Configurar Áreas"'
    },
    // Matriz de Permisos: Define qué se marca para cada Rol y Marca
    matrix: (typeof window !== 'undefined' && window.SERVER_MATRIX) ? window.SERVER_MATRIX : {},
    // Reglas de dependencia (Ej: Si marcas VPN, debes tener Nube)
    dependencies: [
        {
            ifChecked: '#permiso-vpn',
            mustHave: '#permiso-nube',
            errorMessage: '⚠️ El acceso VPN requiere Cloud Storage habilitado.'
        }
    ]
};

// IMPORTANTE: Instanciar la clase para que el script funcione
new PermisosEngine(CONFIG);