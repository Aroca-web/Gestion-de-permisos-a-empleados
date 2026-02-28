
class PermisosEngine {
    // Constructor config
    constructor(config) {
        this.config = config; // Guardamos toda la configuración (matriz, IDs, mensajes)
        this.init(); // Iniciamos la lógica
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.bindEvents();
            this.applyDefaults(); // Inicializa con los valores por defecto
        });
    }

    //Oído del sistema
    bindEvents() {
        /*
          1. Escuchar el selector maestro (Perfil/Rol) ,Busca el desplegable (ej. "Vendedor" o "Mecánico"). Si existe, le dice: 
          "Cada vez que cambies (change), ejecuta la función applyDefaults para resetear y aplicar permisos base".
          */
        const master = document.getElementById(this.config.ui.masterSelector);
        if (master) master.addEventListener('change', () => this.applyDefaults());

        /*
        Vigila los checkboxes de CATEGORÍA (Marcas, etc). Si cambian, hay que reaplicar los defaults.
        */
        document.querySelectorAll(`.${this.config.ui.categoryClass}`).forEach(chk => {
            chk.addEventListener('change', () => this.applyDefaults());
        });

        /*
        Vigila los checksbox normales. Si el usuario marca alguno, SOLO validamos dependencias, no reseteamos.
        */
        document.querySelectorAll('input[type="checkbox"]').forEach(chk => {
            // Si NO es una categoría, solo validamos
            if (!chk.classList.contains(this.config.ui.categoryClass)) {
                chk.addEventListener('change', () => {
                    const feedbackEl = document.getElementById(this.config.ui.feedbackId);
                    this.checkDependencies(feedbackEl);
                });
            }
        });

        // 3. Botones de acción masiva (Marcar/Desmarcar)
        document.querySelectorAll('[data-action="toggle-group"]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleGroup(btn.dataset.target);
            });
        });
    }

    /*
    Metodo: Aplica los permisos por defecto según el ROL y las CATEGORIAS seleccionadas.
    Esto RESEATEA las selecciones manuales (intencionalmente).
    */
    applyDefaults() {
        const currentRole = document.getElementById(this.config.ui.masterSelector)?.value;

        // Obtiene qué categorías principales están activas (ej: marcas, departamentos, áreas)
        const activeCategories = Array.from(document.querySelectorAll(`.${this.config.ui.categoryClass}`))
            .filter(chk => chk.checked)
            .map(chk => chk.value);

        const feedbackEl = document.getElementById(this.config.ui.feedbackId);

        // LÓGICA DE ACTUALIZACIÓN DE UI (Siempre debe ejecutarse)

        // 1. Actualizar botón de marcar/desmarcar
        this.updateToggleButton();

        // 2. Actualizar texto de marcas seleccionadas (con protección)
        try {
            this.updateBrandInfo(activeCategories);
        } catch (e) {
            console.error("Error actualizando info de marcas:", e);
        }

        // VALIDACIÓN A: Selección mínima
        if (activeCategories.length === 0) {
            this.resetForm(false);
            if (feedbackEl) feedbackEl.innerHTML = `<span class="text-danger">${this.config.labels.errorNoCategory}</span>`;
            return;
        }

        // LÓGICA DE MATRIZ: Aplicar permisos basados en Rol + Categoría
        this.resetForm(true); // Limpiamos antes de marcar
        if (currentRole && currentRole !== 'default') {
            activeCategories.forEach(cat => {
                const permissions = this.config.matrix[currentRole]?.[cat];
                if (permissions) {
                    permissions.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.checked = true;
                    });
                }
            });
        }

        // VALIDACIÓN B: Dependencias Cruzadas (Si X requiere Y)
        this.checkDependencies(feedbackEl);
    }

    /*
    Método para actualizar el texto informativo de las marcas seleccionadas
    */
    updateBrandInfo(activeBrands) {
        const infoElement = document.getElementById('marcas-seleccionadas-info');
        if (infoElement) {
            if (activeBrands.length === 0) {
                infoElement.textContent = 'Ninguna marca seleccionada';
            } else {
                // Mapear valores a texto legible si es necesario
                const brandLabels = activeBrands.map(val => {
                    // Usamos un selector seguro
                    const safeVal = val.replace(/["\\]/g, '\\$&');
                    const cb = document.querySelector(`input[value="${safeVal}"].${this.config.ui.categoryClass}`);
                    if (!cb) return val;
                    const label = document.querySelector(`label[for="${cb.id}"]`);
                    return label ? label.textContent : val;
                });
                infoElement.textContent = `Marcas seleccionadas: ${brandLabels.join(', ')}`;
            }
        }
    }

    updateToggleButton() {
        const checks = document.querySelectorAll(`.${this.config.ui.categoryClass}`);
        if (checks.length === 0) return;

        const allChecked = Array.from(checks).every(c => c.checked);
        const btn = document.querySelector('[data-action="toggle-group"]');

        if (btn) {
            // Logs de depuración para verificar el estado
            console.log(`Estado Checkboxes: ${Array.from(checks).filter(c => c.checked).length}/${checks.length} marcados.`);
            btn.textContent = allChecked ? 'Desmarcar Todas' : 'Marcar Todas';
        }
    }

    // Metodo para validar dependencias sin modificar checkboxes
    checkDependencies(feedbackEl) {
        // Limpiar mensaje anterior si es solo advertencia
        if (feedbackEl) feedbackEl.innerHTML = '';

        for (const dep of this.config.dependencies) {
            const hasRequirement = Array.from(document.querySelectorAll(dep.ifChecked)).some(cb => cb.checked);
            const satisfiesMustHave = Array.from(document.querySelectorAll(dep.mustHave)).some(cb => cb.checked);

            if (hasRequirement && !satisfiesMustHave) {
                if (feedbackEl) feedbackEl.innerHTML = `<span class="text-warning">${dep.errorMessage}</span>`;
                if (dep.onFail) dep.onFail(); // Ejecuta callbacks (ej: abrir un modal)
            }
        }
    }

    //Metodo para resetear el formulario
    resetForm(keepCategories) {
        const ignore = keepCategories ? `.${this.config.ui.categoryClass}` : '';
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            // No resetear si el ID está en la lista de protegidos o es una categoría activa
            const isProtected = this.config.ui.protectedIds.includes(cb.id);

            // Si ignore está vacío, no intentamos hacer match (daría error)
            const matchesIgnore = ignore ? cb.matches(ignore) : false;

            if (!matchesIgnore && !isProtected) {
                cb.checked = false;
            }
        });
    }

    //Metodo para marcar o desmarcar todos los checkbox de un grupo
    toggleGroup(selector) {
        const checks = document.querySelectorAll(selector);
        const allChecked = Array.from(checks).every(c => c.checked);
        checks.forEach(c => c.checked = !allChecked);

        // Actualizamos estado del botón y UI
        this.applyDefaults();
    }
}