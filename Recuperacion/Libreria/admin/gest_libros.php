<?php
session_name("examen3_22_23");
session_start();
require "../src/ctes_funciones.php";

if (isset($_SESSION["usuario"])) {
    $salto = "gest_libros.php";
    require "../src/seguridad.php";
    if ($datos_usuario_logueado["tipo"] == "admin") {
        // vista admin
        require "../vistas/vista_admin.php";
    } else {
        // Vista normal
        header("Location: ../index.php");
        exit();
    }

} else {
    header("Location: ../index.php");
        exit();
}

?>