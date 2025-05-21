<?php
    // Establece el nombre personalizado de la sesión
    // Esto permite que se distinga esta sesión de otras (útil si hay varias apps en el mismo servidor)
    session_name("Examen_Rec_SW_24_25");

    // Inicia la sesión PHP (o recupera una existente con ese nombre)
    session_start();

    // Importa funciones y constantes necesarias para el funcionamiento del sistema
    require "src/funciones_ctes.php";

    // ───────────────────────────────────────────────
    // GESTIÓN DEL CIERRE DE SESIÓN
    // ───────────────────────────────────────────────

    // Si el usuario pulsa el botón "Salir", destruimos la sesión y redirigimos al login
    if (isset($_POST["btnSalir"])) {
        session_destroy(); // Elimina toda la información de sesión
        header("Location:index.php"); // Redirige al login
        exit;
    }

    // ───────────────────────────────────────────────
    // CONTROL DE ACCESO SEGÚN SI HAY TOKEN O NO
    // ───────────────────────────────────────────────

    // Si ya hay un token en la sesión → el usuario está autenticado
    if (isset($_SESSION["token"])) {
        // Se hace una comprobación de seguridad para validar el token y renovar si es válido
        require "src/seguridad.php";

        // Se muestra la vista principal (usuario logueado)
        require "vistas/vista_principal.php";
    } else {
        // Si no hay token → mostrar el formulario de login
        require "vistas/vista_login.php";
    }
?>
