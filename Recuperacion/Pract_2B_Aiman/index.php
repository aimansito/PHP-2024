<?php
session_start();
require "src/ctes_funciones.php";

if (isset($_POST["btnContBorrarFoto"])) {
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
    try {
        $consulta = "update usuarios set foto='no_imagen.png' WHERE id_usuario='" . $_POST["id_usuario"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
    if (file_exists("Img/" . $_POST["foto_bd"])) unlink("Img/" . $_POST["foto_bd"]);
    $_POST["foto_bd"] = "no_imagen.png";
    $_SESSION["mensaje"]="La imagen ha sido borrada con éxito";
}

if (isset($_POST["btnContEditar"])) {
    //Errores cuándo edito
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 30;
    if (!$error_usuario) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["id_usuario"]);

        if (is_string($error_usuario)) {
            mysqli_close($conexion);
            die(error_page("Error page", "<p>Ha habido un error: " . $error_usuario . "</p>"));
        }
    }

    $error_clave = strlen($_POST["clave"]) > 15;
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 50;
    $error_dni = $_POST["dni"] == "" || strlen($_POST["dni"]) > 10 || !dni_bien_escrito(strtoupper($_POST['dni'])) ||
        !dni_valido($_POST['dni']);
    if (!$error_dni) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        $error_dni = repetido($conexion, "usuarios", "dni", $_POST["dni"], "id_usuario", $_POST["id_usuario"]);

        if (is_string($error_dni)) {
            mysqli_close($conexion);
            die(error_page("Error page", "<p>Ha habido un error: " . $error_usuario . "</p>"));
        }
    }

    $error_archivo = $_FILES['archivo']['name'] != '' && ($_FILES['archivo']['error'] || !getimagesize($_FILES['archivo']['tmp_name']) || !explode('.', $_FILES['archivo']['name']) || $_FILES['archivo']['size'] > 500 * 1024);
    $error_form = $error_usuario || $error_clave || $error_nombre || $error_dni || $error_archivo;

    if (!$error_form) {
        try {
            if ($_POST["clave"] == "" && $_FILES['archivo']['name'] == "")
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', dni='" . $_POST["dni"] . "', sexo='" . $_POST["sexo"] . "' where id_usuario='" . $_POST["id_usuario"] . "'";
            else if ($_POST["clave"] == "" && $_FILES['archivo']['name'] != "") {
                $array_nombre = explode('.', $_FILES['archivo']['name']);
                $ext = '.' . end($array_nombre); // El último sería la extensión
                $nombre_nuevo = "img_" . $_POST["id_usuario"] . $ext;
                @$var = move_uploaded_file($_FILES['archivo']['tmp_name'], 'Img/' . $nombre_nuevo);
                if ($var)
                    $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', dni='" . $_POST["dni"] . "', sexo='" . $_POST["sexo"] . "', foto='" . $nombre_nuevo . "' where id_usuario='" . $_POST["id_usuario"] . "'";
            } else if (($_POST["clave"] != "" && $_FILES['archivo']['name'] == ""))
                $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', dni='" . $_POST["dni"] . "', sexo='" . $_POST["sexo"] . "', clave='" . md5($_POST["clave"]) . "' where id_usuario='" . $_POST["id_usuario"] . "'";
            else {
                $array_nombre = explode('.', $_FILES['archivo']['name']);
                $ext = '.' . end($array_nombre); // El último sería la extensión
                $nombre_nuevo = "img_" . $_POST["id_usuario"] . $ext;
                @$var = move_uploaded_file($_FILES['archivo']['tmp_name'], 'Img/' . $nombre_nuevo);
                if ($var) {

                    if ($_POST["foto_bd"] != $nombre_nuevo) {
                        unlink("Img/" . $_POST["foto_bd"]);
                    }
                    $consulta = "update usuarios set nombre='" . $_POST["nombre"] . "', usuario='" . $_POST["usuario"] . "', dni='" . $_POST["dni"] . "', sexo='" . $_POST["sexo"] . "', foto='" . $nombre_nuevo . "', clave='" . md5($_POST["clave"]) . "' where id_usuario='" . $_POST["id_usuario"] . "'";
                }
            }

            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            unlink("Img/" . $nombre_nuevo);
            mysqli_close($conexion);
            die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
        }

        mysqli_close($conexion);
    $_SESSION["mensaje"]="El usuario ha sido editado con éxito";
        header("Location:index.php");
        exit;
    }
}

if (isset($_POST["btnContBorrar"])) {
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Práctica 8", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Práctica 8", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
    if ($_POST["foto_usuario"] != 'Img/no_imagen.png') unlink($_POST["foto_usuario"]);
    mysqli_close($conexion);

    $_SESSION["mensaje"]="El usuario ha sido borrado con éxito";
    header("Location:index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Rec 2B</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 100%;
        }

        table img {
            height: 70px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline
        }

        .error {
            color: red
        }

        .paralelo {
            display: flex;
        }

        .column {
            display: flex;
            flex-flow: column;
        }

        .centrar_flex {
            align-items: center;
        }
    </style>
</head>

<body>
    <h1>Práctica Rec 2B</h1>
    <?php

    if (isset($_SESSION["mensaje"])) {
        echo "<p>".$_SESSION["mensaje"]."</p>";
        session_destroy();
    }

    if (isset($_POST["btnDetalle"])) {
        require "vistas/vista_detalle.php";
    }
    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_conf_borrar.php";
    }
    if (
        isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"])
        || isset($_POST["btnContBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"])
    ) {
        require "vistas/vista_editar.php";
    }
    if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
        require "vistas/vista_nuevo.php";
    }
    require "vistas/vista_tabla.php";

    mysqli_close($conexion);

    ?>
</body>

</html>