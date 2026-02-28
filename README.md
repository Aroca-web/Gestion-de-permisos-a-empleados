<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 👥 Sistema de Gestión de Altas y Permisos Dinámicos
> **Proyecto de Digitalización de RRHH y Operaciones**

Este sistema automatiza el proceso de incorporación de nuevos empleados, eliminando el error humano al asignar accesos. La aplicación calcula y aplica permisos de software y niveles de seguridad de forma automática basándose en el binomio **Puesto + Campaña**.

## 🚀 Funcionalidades Clave

* **Asignación de Permisos Inteligente:** Dependiendo de la campaña (ej. "Campaña Ventas", "Campaña Soporte") y el puesto, el sistema marca automáticamente qué herramientas y niveles de acceso debe tener el empleado.
* **Panel de Administración:** Gestión centralizada de usuarios, roles y definición de reglas de campaña.
* **Auditoría de Accesos:** Registro de qué permisos han sido otorgados para cumplir con normativas de seguridad.
* **Interfaz Intuitiva:** Desarrollada para que el equipo de Operaciones o RRHH pueda dar de alta a un trabajador en segundos.

## 🛠️ Stack Tecnológico

* **Backend:** Laravel (PHP)
* **Base de Datos:** MySQL
* **Frontend:** Blade Templates & Bootstrap
* **Lógica de Negocio:** Motores de reglas personalizados para la segregación de funciones (SoD).

## 📋 Requisitos para Instalación Local

Si deseas probar este proyecto en tu entorno local:

1. Clonar el repositorio:
   git clone [https://github.com/Aroca-web/Proyectos.git](https://github.com/Aroca-web/Proyectos.git)
   
3. Instalar dependencias de PHP (requiere Composer):
composer install

4. Configurar el archivo de entorno:
Copia .env.example a .env
Configura tus credenciales de base de datos en el .env.

4. Generar la clave de aplicación:
php artisan key:generate

5. Ejecutar migraciones y seeders:
php artisan migrate --seed

6. Iniciar servidor:
php artisan serve


💡 Sobre el Autor
Este proyecto forma parte del ecosistema de soluciones de aroca web.
Mi enfoque es unir mi experiencia como Técnico Informático (entendiendo las necesidades de hardware y acceso) con el Desarrollo Web para crear herramientas que optimicen el día a día de las empresas.
