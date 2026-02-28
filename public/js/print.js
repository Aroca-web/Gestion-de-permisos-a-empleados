
// --- LÓGICA DE IMPRESIÓN ---

// Función que prepara el HTML para ser impreso (oculta/muestra cosas según filtros)
const prepareDOMForPrint = (allowedModalIds) => {
        try {
            // 1. Expandir todos los acordeones para que el contenido sea visible
            // Buscamos todos los contenidos de acordeón
            document.querySelectorAll('.accordion-content').forEach(content => {
                // Forzamos la altura automática para que se vea todo al imprimir
                content.style.height = 'auto';
                // Añadimos clase activa al padre para estilos visuales
                content.parentElement.classList.add('active');
            });
             // 2. Ocultar la sección de Observaciones si está vacía
            const obsText = document.getElementById('observaciones');
            const obsAccordion = document.querySelector('#Observaciones .accordion');
            if (obsText && obsAccordion) {
                // Si no hay texto en observaciones
                if (obsText.value.trim() === '') {
                    // Añadimos clase de Bootstrap para ocultar en impresión
                    obsAccordion.classList.add('d-print-none');
                } else {
                    obsAccordion.classList.remove('d-print-none');
                }
            }
            // 3. Generar un resumen visual de los checks marcados (SOLO LOS MARCADOS)
            // Buscamos el contenedor donde pondremos el resumen
            const summaryDiv = document.getElementById('print-summary');
            if (summaryDiv) {
                summaryDiv.innerHTML = ''; // Limpiar contenido previo
                
                // Creamos un contenedor temporal
                const tempContainer = document.createElement('div');
                let hayContenido = false;

                // Creamos el título del anexo
                const header = document.createElement('h4');
                header.className = 'mb-3 border-bottom pb-2';
                header.innerText = 'Anexo: Detalle de Permisos Seleccionados';
                tempContainer.appendChild(header);

                // IDs de los modales que contienen checkboxes
                const allModalIds = ['modalCategorias'];
                // Si hay filtro usamos el filtro, si no, usamos todos
                const targetIds = allowedModalIds || allModalIds;

                 // Recorremos los IDs de modales que queremos incluir
                targetIds.forEach(id => {
                    const modal = document.getElementById(id);
                    if (!modal) return;

                    // Buscar checkboxes marcados dentro de este modal
                    const checkedInputs = modal.querySelectorAll('input[type="checkbox"]:checked');
                    
                    // Si hay algo marcado en este grupo
                    if (checkedInputs.length > 0) {
                        hayContenido = true;
                        // Obtenemos el título del modal para usarlo de subtítulo
                        const title = modal.querySelector('.modal-title')?.innerText || id;
                        
                        // Contenedor de la sección
                        const section = document.createElement('div');
                        section.className = 'mb-4';
                        section.innerHTML = `<h5 class="text-primary fw-bold mt-3">${title}</h5>`;
                        
                        // Crear un contenedor tipo grid para los checks
                        const grid = document.createElement('div');
                        grid.className = 'row g-2';

                        // Por cada check marcado, creamos una representación visual para imprimir
                        checkedInputs.forEach(input => {
                            // Buscar el label asociado para obtener el texto correcto
                            let labelText = input.value;
                            // Fallback si el value es "on" o vacío
                            if (!labelText || labelText === 'on') labelText = input.id || 'Seleccionado';

                            // Intentamos buscar el elemento <label> asociado por el atributo 'for'
                            if (input.id) {
                                try {
                                    const label = modal.querySelector(`label[for="${input.id}"]`);
                                    if (label) labelText = label.innerText;
                                } catch (e) { /* Ignorar errores de selector */ }
                            }
                            
                            const col = document.createElement('div');
                            col.className = 'col-6 col-md-4'; // Ajuste de columnas
                            
                            // Recrear visualmente el check con un SPAN para asegurar que se imprima (los inputs a veces se ocultan)
                            col.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <span style="display: inline-flex; justify-content: center; align-items: center; width: 20px; height: 20px; border: 2px solid #000; margin-right: 8px; font-weight: bold; font-size: 16px; line-height: 1; color: #000;">✓</span>
                                    <span>${labelText}</span>
                                </div>
                            `;
                            grid.appendChild(col);
                        });
                        
                        section.appendChild(grid);
                        tempContainer.appendChild(section);
                    }
                });
                // Solo añadimos el resumen al DOM si encontramos algo marcado
                if (hayContenido) {
                    summaryDiv.appendChild(tempContainer);
                }
            }
        } catch (error) {
            console.error("Error preparando DOM:", error);
        }
};

// Funcion para imprimir
// Vinculamos el botón correcto definido en el HTML (btn-print-smart)
document.addEventListener('DOMContentLoaded', () => {
    const btnImprimir = document.getElementById('btn-print-smart');
    if (btnImprimir) {
        btnImprimir.addEventListener('click', (e) => {
            e.preventDefault(); // Evita comportamientos por defecto
            prepareDOMForPrint(); // Llamada correcta a la función (con paréntesis)
            window.print();
        });
    }
});