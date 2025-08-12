# Sistema de Autenticación y Roles "Expo Joya"

Este proyecto es una aplicación web desarrollada en PHP que implementa un sistema de autenticación de usuarios robusto, con gestión de roles y funcionalidades para la recuperación de contraseñas. Sirve como una excelente base para construir aplicaciones más complejas que requieran proteger rutas y diferenciar funcionalidades por tipo de usuario.

## ✨ Características Principales

* **Sistema de Autenticación Completo:**
    * Formulario de **Registro** para nuevos usuarios (`/registro`).
    * Formulario de **Inicio de Sesión** (`/login`).
    * **Cierre de sesión** seguro (`/auth/logout`).

* **Gestión de Contraseñas:**
    * **Recuperación de contraseña** a través de un enlace enviado al correo electrónico del usuario (`/auth/password/recover`).
    * Restablecimiento de contraseña mediante un **token seguro** con tiempo de expiración para proteger las cuentas.

* **Sistema de Roles:**
    * Tres roles predefinidos: **Administrador**, **Vendedor** y **Cliente**.
    * Redirección automática a un panel de control específico (`/admin`, `/vendedor`, `/cliente`) según el rol del usuario al iniciar sesión.

* **Rutas Protegidas:**
    * Los paneles de usuario son privados y solo accesibles para usuarios autenticados y con el rol correspondiente.
    * Manejo de **errores 404** para rutas no encontradas o a las que no se tiene permiso de acceso.

## 🛠️ Tecnologías Utilizadas

* **Backend:**
    * PHP
    * PDO (PHP Data Objects) para una conexión segura a la base de datos.
* **Frontend:**
    * HTML5
    * CSS3
    * JavaScript
    * [Bootstrap](https://getbootstrap.com/) para un diseño adaptable y moderno.
    * [Font Awesome](https://fontawesome.com/) para los iconos.
* **Base de Datos:**
    * MySQL / MariaDB
* **Dependencias (gestionadas con Composer):**
    * [PHPMailer](https://github.com/PHPMailer/PHPMailer): Para el envío de correos electrónicos transaccionales (como la recuperación de contraseñas).

## 🚀 Instalación y Puesta en Marcha

Sigue estos pasos para configurar el proyecto en tu entorno de desarrollo local.

### Prerrequisitos

* Un servidor web local (como XAMPP, WAMP, MAMP o el servidor integrado de PHP).
* PHP 7.4 o superior.
* Un servidor de base de datos MySQL o MariaDB.
* [Composer](https://getcomposer.org/) instalado globalmente en tu sistema.

### Pasos

1.  **Clonar el repositorio:**
    ```bash
    git clone https://URL_DE_TU_REPOSITORIO.git
    cd nombre-del-directorio
    ```

2.  **Instalar dependencias de PHP:**
    Ejecuta Composer en la raíz del proyecto para descargar PHPMailer.
    ```bash
    composer install
    ```

3.  **Crear y configurar la Base de Datos:**
    a. Accede a tu gestor de base de datos (como phpMyAdmin) y crea una nueva base de datos llamada `expojoya`.
    b. Importa la siguiente estructura SQL para crear las tablas `rol` y `login`:

    ```sql
    -- Tabla para los roles de usuario
    CREATE TABLE `rol` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `privilegio` VARCHAR(50) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Insertar los roles básicos
    INSERT INTO `rol` (`id`, `privilegio`) VALUES
    (1, 'Administrador'),
    (2, 'Vendedor'),
    (3, 'Cliente');

    -- Tabla para los datos de los usuarios
    CREATE TABLE `login` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `usuario` VARCHAR(50) NOT NULL,
      `email` VARCHAR(100) NOT NULL UNIQUE,
      `password` VARCHAR(255) NOT NULL,
      `id_cargo` INT(11) NOT NULL,
      `token_recuperacion` VARCHAR(64) DEFAULT NULL,
      `token_expiracion` DATETIME DEFAULT NULL,
      PRIMARY KEY (`id`),
      FOREIGN KEY (`id_cargo`) REFERENCES `rol`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

4.  **Configurar la conexión a la Base de Datos:**
    Abre el archivo `model/conexion.php` y, si es necesario, ajusta las credenciales (`$host`, `$db`, `$user`, `$pass`) para que coincidan con tu configuración local.

5.  **Configurar el servidor de correo (SMTP):**
    Para que la recuperación de contraseña funcione, abre `views/auth/password/reset_password.php` y configura tus credenciales de SMTP.

    ```php
    // Dentro del bloque try/catch para la configuración del servidor
    $mail->Host       = 'smtp.example.com'; // Cambia esto por tu servidor SMTP
    $mail->Username   = 'tu_correo@example.com';
    $mail->Password   = 'tu_contraseña_smtp'; // ¡Usa una contraseña de aplicación si es necesario!
    ```

6.  **Iniciar el servidor:**
    Inicia tu servidor Apache (desde XAMPP, por ejemplo) y navega a la URL de tu proyecto.

## 📖 Uso del Sistema

* **Registro:** Para crear una nueva cuenta, navega a `/registro`.
* **Inicio de Sesión:** Para acceder, ve a `/login`.
* **Paneles de Usuario:** Al iniciar sesión, el sistema te redirigirá al panel que te corresponde según tu rol.
* **Recuperación de Contraseña:** Si olvidas tu contraseña, ve a `/auth/password/recover`, introduce tu correo electrónico y sigue las instrucciones que recibirás.

