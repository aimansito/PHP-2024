<?php

if(isset($_POST["btnContEditar"]))
{
    $error_nombre=$_POST["nombre"]=="";
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/usuarios/usuario/" . urlencode($_POST["usuario"])."/id_usuario/".urlencode($_POST["btnContEditar"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $error_usuario=$json_repetido["repetido"];
    }
    $error_email=$_POST["email"]=="" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/usuarios/email/" . urlencode($_POST["email"])."/id_usuario/".urlencode($_POST["btnContEditar"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $error_email=$json_repetido["repetido"];
    }
    $error_form=$error_nombre || $error_usuario || $error_email;
    if(!$error_form)
    {
        //Actualizo valores en la BD
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        
        if($_POST["clave"]=="")
        {
            $url = DIR_SERV . "/actualizarUsuarioSinClave/";
            unset($_POST["clave"]);
        }
        else
        {
            $url = DIR_SERV . "/actualizarUsuario/";
            $_POST["clave"]=md5($_POST["clave"]);
        }
        $url.=urlencode($_POST["btnContEditar"]);

        unset($_POST["btnContEditar"]);
        $respuesta = consumir_servicios_JWT_REST($url, "PUT", $headers,$_POST);
        $json_actualizar = json_decode($respuesta, true);
        if (!$json_actualizar) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_actualizar["error"])) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>" . $json_actualizar["error"] . "</p>"));
        }

        if (isset($json_actualizar["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_actualizar["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $_SESSION["mensaje_accion"]="¡¡ Usuario actualizado con éxito !!";
        header("Location:index.php");
        exit;
    }
}



if(isset($_POST["btnContBorrar"]))
{
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $url = DIR_SERV . "/borrarUsuario/".urlencode($_POST["btnContBorrar"]);

    $respuesta = consumir_servicios_JWT_REST($url, "DELETE", $headers);
    $json_borrar = json_decode($respuesta, true);
    if (!$json_borrar) {
        session_destroy();
        die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }
    if (isset($json_borrar["error"])) {
        session_destroy();
        die(error_page("Actividad 8 - SW", "<p>" . $json_borrar["error"] . "</p>"));
    }

    if (isset($json_borrar["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if (isset($json_borrar["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje_accion"]="¡¡ Usuario borrardo con éxito !!";
    header("Location:index.php");
    exit;
}


if (isset($_POST["btnContAgregar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/usuarios/usuario/" . urlencode($_POST["usuario"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $error_usuario=$json_repetido["repetido"];
    }
    $error_clave=$_POST["clave"]=="";
    $error_email=$_POST["email"]=="" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/usuarios/email/" . urlencode($_POST["email"]);
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);
        if (!$json_repetido) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>" . $json_repetido["error"] . "</p>"));
        }

        if (isset($json_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $error_email=$json_repetido["repetido"];
    }
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;
    if (!$error_form) {
        //inserto datos en BD
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/crearUsuario";
        unset($_POST["btnContAgregar"]);
        $respuesta = consumir_servicios_JWT_REST($url, "POST", $headers,$_POST);
        $json_agregar = json_decode($respuesta, true);
        if (!$json_agregar) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_agregar["error"])) {
            session_destroy();
            die(error_page("Actividad 8 - SW", "<p>" . $json_agregar["error"] . "</p>"));
        }

        if (isset($json_agregar["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_agregar["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"]="¡¡ Usuario agregado con éxito !!";
        header("Location:index.php");
        exit;

    }
}

if (isset($_POST["btnDetalles"]) || isset($_POST["btnBorrar"]) || isset($_POST["btnEditar"])) {

    if(isset($_POST["btnDetalles"]))
        $id_usuario=$_POST["btnDetalles"];
    elseif(isset($_POST["btnBorrar"]))
        $id_usuario=$_POST["btnBorrar"];
    else
        $id_usuario=$_POST["btnEditar"];


    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $url = DIR_SERV . "/usuario/" . urlencode($id_usuario);
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_detalles = json_decode($respuesta, true);
    if (!$json_detalles) {
        session_destroy();
        die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }
    if (isset($json_detalles["error"])) {
        session_destroy();
        die(error_page("Actividad 8 - SW", "<p>" . $json_detalles["error"] . "</p>"));
    }

    if (isset($json_detalles["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if (isset($json_detalles["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

}


/// Llamada siempre para mostrar la tabla
$headers[] = "Authorization: Bearer " . $_SESSION["token"];
$url = DIR_SERV . "/usuarios";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_usuarios = json_decode($respuesta, true);
if (!$json_usuarios) {
    session_destroy();
    die(error_page("Actividad 8 - SW", "<p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}
if (isset($json_usuarios["error"])) {
    session_destroy();
    die(error_page("Actividad 8 - SW", "<p>" . $json_usuarios["error"] . "</p>"));
}

if (isset($json_usuarios["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}
if (isset($json_usuarios["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 8 - SW</title>
    <style>
        .enlinea {
            display: inline
        }

        table,
        td,
        th {
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer
        }

        .btn_img {
            border: none;
            background: none;
            cursor: pointer
        }

        .mensaje {
            font-size: 1.25rem;
            color: blue
        }

        .error {
            color: red
        }
    </style>
    </style>
</head>

<body>
    <h1>Actividad 8 - SW</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php"
            method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Listado de los usuarios (no admin)</h2>
    <?php

   require "vistas/admin/vista_tabla_principal.php";

    if(isset($_SESSION["mensaje_accion"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/admin/vista_borrar.php";
    }

    if(isset($_POST["btnEditar"]) || (isset($_POST["btnContEditar"])&& $error_form))
    {
        require "vistas/admin/vista_editar.php";    
    }



    if (isset($_POST["btnAgregar"]) || (isset($_POST["btnContAgregar"])&& $error_form )) {
       
        require "vistas/admin/vista_agregar.php";
    }


    if (isset($_POST["btnDetalles"])) {

        require "vistas/admin/vista_detalles.php";
    }
    ?>
</body>

</html>