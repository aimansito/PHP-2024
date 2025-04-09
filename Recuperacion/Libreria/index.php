<?php
session_name("examen3_22_23");
session_start();
require "src/ctes_funciones.php";

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    $salto = "index.php";
    require "src/seguridad.php";

    if ($datos_usuario_logueado["tipo"] == "admin") {
        // vista admin
        header("Location: admin/gest_libros.php");
        exit();
    } else {
        // Vista normal
        require "vistas/vista_normal.php";
    }

} else {
    require "vistas/vista_login.php";
}

