// Función auxiliar para validar el email (se usa en el envío y en tiempo real)
function validarEmailPersonal() {
    const emailInput = document.getElementById('email-personal');
    if (!emailInput) return true;

    const email = emailInput.value;
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const errorDiv = document.getElementById('errorEmail');
    const esValido = regexEmail.test(email);

    if (!esValido) {
        if (errorDiv) errorDiv.innerText = "Email no válido";
        emailInput.style.border = '2px solid red';
    } else {
        if (errorDiv) errorDiv.innerText = "";
        emailInput.style.border = '';
    }
    return esValido;
}

//Validar numero de telf
function validarTelefono() {
    const telefonoInput = document.getElementById('telefono1');
    if (!telefonoInput) return true;
    const telefono = telefonoInput.value;
    const regexTelefono = /^\d{9}$/;
    const errorDiv = document.getElementById('errorTelefono');
    const esValido = regexTelefono.test(telefono);

    if (!esValido) {
        if (errorDiv) errorDiv.innerText = "Telefono no válido";
        telefonoInput.style.border = '2px solid red';
    } else {
        if (errorDiv) errorDiv.innerText = "";
        telefonoInput.style.border = '';
    }
    return esValido;
}

// Función de validación
function validarFormulario() {
    // Inicializamos una variable bandera asumiendo que el formulario es válido
    let esValido = true;

    // 1. Validar todos los campos con atributo 'required'
    // Seleccionamos todos los inputs/selects que tengan el atributo HTML 'required'
    const camposRequeridos = document.querySelectorAll('[required]');
    // Recorremos cada campo encontrado
    camposRequeridos.forEach(campo => {
        // Si el valor está vacío (quitando espacios en blanco al inicio/final)
        if (!campo.value.trim()) {
            // Marcamos el formulario como inválido
            esValido = false;
            // Ponemos un borde rojo al campo para avisar al usuario
            campo.style.border = '2px solid red';
        } else {
            // Si tiene valor, quitamos el borde rojo (por si lo tenía de antes)
            campo.style.border = '';
        }
    });

    // 2. Validación específica de Email
    if (!validarEmailPersonal()) {
        esValido = false;
    }

    // 3. Validación específica de Teléfono
    if (!validarTelefono()) {
        esValido = false;
    }

    // Si hubo algún error, mostramos una alerta general
    if (!esValido) {
        alert("No se puede continuar: Faltan datos obligatorios marcados en rojo.");
    }

    // Devolvemos true o false para que quien llame a la función sepa si continuar
    return esValido;
}

// Validación en tiempo real (se activa al cargar la página)
document.addEventListener('DOMContentLoaded', () => {
    // Para todos los campos requeridos
    // Buscamos de nuevo todos los campos obligatorios
    document.querySelectorAll('[required]').forEach(campo => {
        // Escuchamos dos eventos: 'input' (mientras escribes) y 'change' (al salir del campo)
        ['input', 'change'].forEach(evento => {
            campo.addEventListener(evento, () => {
                // Si el usuario escribe algo, quitamos el borde rojo inmediatamente
                if (campo.value.trim()) {
                    campo.style.border = '';
                } else {
                    // Si lo borra, vuelve el borde rojo
                    campo.style.border = '2px solid red';
                }
            });
        });
    });

    // Para el email específicamente
    // Validación en tiempo real específica para el formato de correo
    const emailInput = document.getElementById('email-personal');
    if (emailInput) {
        emailInput.addEventListener('input', validarEmailPersonal);
    }

    // Para el teléfono específicamente
    const telefonoInput = document.getElementById('telefono1');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', validarTelefono);
    }
});

