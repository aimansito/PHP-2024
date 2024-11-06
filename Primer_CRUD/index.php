<?php
// Inicia una sesión para almacenar mensajes temporales o datos de usuario
session_start();
require "src/ctes_funciones.php"; // Incluye un archivo con constantes y funciones necesarias

// Comienza el bloque para manejar el envío del formulario de edición de usuario
if (isset($_POST["btnContEditar"])) {
    
    // Validaciones de errores en los campos de nombre y usuario
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;

    if (!$error_usuario) {
        // Intenta conectar con la base de datos para verificar el nombre de usuario
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarme a la base de datos: " . $e->getMessage() . "</p>"));
        }
        
        // Llama a la función para verificar si el usuario existe
        $error_usuario = repetido_editando($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["btnContEditar"]);
            
        // Verifica si hay errores en la verificación de usuario
        if (is_string($error_usuario))
            die($error_usuario);
    }

    // Validación de longitud en la clave y formato en el email
    $error_clave = strlen($_POST["clave"]) > 15;
    $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    
    if (!$error_email) {
        // Establece la conexión si aún no existe
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarme a la base de datos: " . $e->getMessage() . "</p>"));
            }
        }
        // Llama a la función para verificar si el email está repetido
        $error_email = repetido_editando($conexion, "usuarios", "email", $_POST["email"], "id_usuario", $_POST["btnContEditar"]);
        
        if (is_string($error_email))
            die($error_email);
    }

    // Define si el formulario contiene algún error en los campos
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    // Si no hay errores en el formulario, actualiza el usuario en la base de datos
    if (!$error_form) {
        try {
            // Si la clave está vacía, se actualizan solo los campos nombre, usuario y email
            if ($_POST["clave"] == "")
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', email='" . $_POST["email"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";
            else
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', clave='" . md5($_POST["clave"]) . "', email='" . $_POST["email"] . "' where id_usuario='" . $_POST["btnContEditar"] . "'";
            
            // Ejecuta la consulta
            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion); // Cierra conexión
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
        }
        
        mysqli_close($conexion);

        // Guarda un mensaje de éxito en la sesión y redirige a la página principal
        $_SESSION["mensaje"] = "Se ha actualizado con éxito";
        header("Location:index.php");
        exit;
    }
}

// Bloque para gestionar la eliminación de usuarios
if (isset($_POST["btnContBorrar"])) {
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
    }

    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
    }

    mysqli_close($conexion);

    $_SESSION["mensaje"] = "El usuario ha sido borrado con éxito";
    header("Location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1º CRUD</title>
    <style>
        table,td,th { border:1px solid black; }
        table { border-collapse:collapse; text-align:center; }
        th { background-color:#CCC; }
        table img { width:50px; }
        .enlace { border:none; background:none; cursor:pointer; color:blue; text-decoration:underline; }
        .error { color:red; }
    </style>
</head>
<body>
    <h1>Listado de los usuarios</h1>
    <?php
    require "vistas/vista_tabla.php"; // Incluye la vista principal de la tabla de usuarios

    // Muestra la vista según el botón presionado en el formulario
    if (isset($_POST["btnDetalle"])) {
        require "vistas/vista_detalle.php";
    } elseif (isset($_POST["btnBorrar"])) {
        require "vistas/vista_conf_borrar.php";
    } elseif (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"])) {
        require "vistas/vista_editar.php";
    } else {
        require "vistas/vista_nuevo.php";
    }

    mysqli_close($conexion); // Cierra conexión

    ?>
</body>
</html>
