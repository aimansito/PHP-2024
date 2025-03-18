<?php
    // Inicia una sesión con el nombre "examen2_24_25"
    session_name("examen2_24_25");
    session_start(); // Activa el manejo de sesiones para el script

    // Se incluye un archivo que contiene constantes y funciones necesarias
    require "src/funciones_ctes.php";

    // Si el botón de cerrar sesión ha sido presionado
    if(isset($_POST["btnCerrarSesion"])){
        session_destroy(); // Se destruye la sesión actual
        header("Location:index.php"); // Redirige al usuario al archivo "index.php"
        exit; // Finaliza la ejecución del script
    }

    // Intentar abrir una conexión a la base de datos
    try{
        // Se utiliza la función `mysqli_connect` para conectarse a la base de datos usando constantes definidas previamente
        @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8"); // Configura el conjunto de caracteres a UTF-8 para evitar problemas con caracteres especiales
    }catch(Exception $e){
        // Si ocurre un error en la conexión, se destruye la sesión y se muestra un mensaje de error
        session_destroy();
        die(error_page("Examen2 Php","<p>No se ha podido conectar a la BD: ".$e-getMessage()."</p>"));
    }

    // Verifica si hay un usuario autenticado
    if(isset($_SESSION["lector"])){
        $salto_seg="index.php"; // Ruta base para redireccionamientos en caso de problemas de seguridad

        // Se incluye un archivo que maneja la seguridad y verifica los datos del usuario logueado
        require "src/seguridad.php";

        // Si el usuario logueado es de tipo "normal"
        if($datos_lector_log["tipo"]=="normal")
            // Se carga la vista para usuarios normales
            require "vistas/vista_normal.php";
        else{
            // Si el usuario no es de tipo "normal", se cierra la conexión y se redirige a la página de administración
            mysqli_close($conexion);
            header("Location:admin/gest_libros.php");
            exit; // Finaliza la ejecución del script
        }
    }else{
        // Si no hay un usuario autenticado, se muestra el formulario de login
        require "vistas/vista_login.php";
    }

    // Se cierra la conexión a la base de datos al final del script
    mysqli_close($conexion);
?>
