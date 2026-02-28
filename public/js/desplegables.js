// Lógica para acordeones/desplegables
// Seleccionamos todos los elementos con clase .accordion-header (los botones para abrir)
const headers = document.querySelectorAll('.accordion-header');

// Iteramos sobre cada cabecera
headers.forEach(header => {
  // Añadimos evento click
  header.addEventListener('click', () => {
    // Obtenemos el elemento padre (.accordion-item)
    const item = header.parentElement;
    // Obtenemos el contenido (.accordion-content)
    const content = item.querySelector('.accordion-content');
    
    // Si ya está activo (abierto)
    if (item.classList.contains('active')) {
      // Fijamos la altura actual en píxeles para poder animar hacia 0
      content.style.height = content.scrollHeight + 'px';
      // Quitamos la clase active
      item.classList.remove('active');
      // Pequeño retraso para que el navegador procese el cambio antes de colapsar
      setTimeout(() => {
        content.style.height = '0';
      }, 10);
    } else {
      // Si está cerrado, añadimos clase active
      item.classList.add('active');
      // Fijamos la altura al tamaño total del contenido (scrollHeight)
      content.style.height = content.scrollHeight + 'px';
      // Después de la animación (300ms), ponemos height: auto por si el contenido cambia dinámicamente
      setTimeout(() => {
        content.style.height = 'auto';
      }, 300);
    }
  });
});

// Lógica similar para otro tipo de acordeón (si existe en el HTML)
const accordionUsers = document.querySelectorAll('.accordion-user');

accordionUsers.forEach(user => {
  user.addEventListener('click', () => {
    const item = user.parentElement.parentElement;
    const content = item.querySelector('.accordion-content');
    // ajuste para que funcione igual que los otros acordeones
    if (item.classList.contains('active')) {
      content.style.height = content.scrollHeight + 'px';
      item.classList.remove('active');
      setTimeout(() => {
        content.style.height = '0';
      }, 10);
    } else {
      item.classList.add('active');
      content.style.height = content.scrollHeight + 'px';
      setTimeout(() => {
        content.style.height = 'auto';
      }, 300);
    }
  });
});


// Lógica para resaltar la página activa en las Migas de Pan
document.addEventListener('DOMContentLoaded', () => {
  // Seleccionamos todos los enlaces dentro de items de migas de pan
  const breadcrumbLinks = document.querySelectorAll('.breadcrumb-item a');
  
  breadcrumbLinks.forEach(link => {
    // Comparamos la URL completa del enlace con la URL actual del navegador
    if (link.href === window.location.href) {
      // Buscamos el elemento <li> padre
      const li = link.closest('.breadcrumb-item');
      if (li) {
        // Añadimos las clases y atributos de "activo"
        li.classList.add('active');
        li.setAttribute('aria-current', 'page');
        
        // Opcional: Cambiamos el estilo para que parezca texto y no un enlace
        link.style.color = 'inherit';
        link.style.textDecoration = 'none';
        link.style.pointerEvents = 'none'; // Deshabilita el clic
      }
    }
  });
});

// Atajo de teclado: Tecla '1' para desplegar Datos Personales
document.addEventListener('keydown', (e) => {
  // Evitamos que se active si el usuario está escribiendo en un campo de texto
  if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;

  if (e.key === '1') {
    const btnPerson = document.getElementById('btn-person');
    if (btnPerson) {
      btnPerson.click(); // Simulamos click para activar la lógica del acordeón
    }
  }
});

// Atajo de teclado: Tecla '2' para desplegar Datos Laborales
document.addEventListener('keydown', (e) => {
  // Evitamos que se active si el usuario está escribiendo en un campo de texto
  if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;

  if (e.key === '2') {
    const btnPerson = document.getElementById('btn-labo');
    if (btnPerson) {
      btnPerson.click(); // Simulamos click para activar la lógica del acordeón
    }
  }
});

// Atajo de teclado: Tecla '3' para desplegar Datos Laborales
document.addEventListener('keydown', (e) => {
  // Evitamos que se active si el usuario está escribiendo en un campo de texto
  if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;

  if (e.key === '3') {
    const btnPerson = document.getElementById('btn-permisos');
    if (btnPerson) {
      btnPerson.click(); // Simulamos click para activar la lógica del acordeón
    }
  }
});

// Atajo de teclado: Tecla '4' para desplegar Datos Laborales
document.addEventListener('keydown', (e) => {
  // Evitamos que se active si el usuario está escribiendo en un campo de texto
  if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;

  if (e.key === '4') {
    const btnPerson = document.getElementById('btn-equipo');
    if (btnPerson) {
      btnPerson.click(); // Simulamos click para activar la lógica del acordeón
    }
  }
});

// Atajo de teclado: Tecla '5' para desplegar Datos Laborales
document.addEventListener('keydown', (e) => {
  // Evitamos que se active si el usuario está escribiendo en un campo de texto
  if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;

  if (e.key === '5') {
    const btnPerson = document.getElementById('btn-obser');
    if (btnPerson) {
      btnPerson.click(); // Simulamos click para activar la lógica del acordeón
    }
  }
});