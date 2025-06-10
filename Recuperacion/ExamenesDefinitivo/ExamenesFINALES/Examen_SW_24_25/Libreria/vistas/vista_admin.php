<?php
if (isset($_POST['btnContEditar'])) {
    $error_titulo = $_POST['titulo'] == "";
    $error_autor = $_POST['autor'] == "";
    $error_descripcion = $_POST['descripcion'] == "";
    $error_precio = $_POST['precio'] == "" ||  !is_numeric($_POST['precio']) || $_POST['precio'] < 0;

    if (!$_FILES['portada']['name'] == "") {
        $error_portada = !getimagesize($_FILES['portada']['tmp_name']) || $_FILES['portada']['error'] || $_FILES['portada']['size'] < 500 * 1024;
        $errores_form = $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;
    } else {
        $errores_form = $error_titulo || $error_autor || $error_descripcion || $error_precio;
    }

    if (!$errores_form) {
        //Si llegamos aquí significa que la referencia no está repetida
        //Se va a agregar sin portada
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/actualizarLibro/" . urlencode($_POST['btnContEditar']);

        $respuesta_actualizar = json_decode(consumir_servicios_JWT_REST($url, "PUT", $headers, $_POST), true);

        if (!$respuesta_actualizar) {
            session_destroy();
            die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
        }

        if (isset($respuesta_actualizar['error'])) {
            session_destroy();
            die("Error realizando el servicio. " . $respuesta_actualizar['error']);
        }

        $_SESSION['mensaje_acc'] = $respuesta_actualizar['mensaje'];

        if (!$_FILES['portada']['name'] == "") {
            //Si tenemos foto actualizaremos para meter la foto
            //ruta ["tmp_name"]
            $arr = explode(".", $_FILES['portada']['full_path']);
            $ext = end($arr);
            $nuevo_nombre = "img_" . $_POST['btnContEditar'] . "." . $ext;

            @$file = move_uploaded_file($_FILES['portada']['tmp_name'], "images/" . $nuevo_nombre);
            if (!$file) {
                echo "<p>No ha podido añadirse a la carpeta images</p>";
            } else {
                $headers[] = "Authorization: Bearer " . $_SESSION["token"];
                $url = DIR_SERV . "/actualizarPortada/" . urlencode($_POST['btnContEditar']);

                $datos['referencia'] = $_POST['referencia'];
                $datos['portada'] = $nuevo_nombre;
                $respuesta_portada = json_decode(consumir_servicios_JWT_REST($url, "PUT", $headers, $datos), true);

                if (!$respuesta_portada) {
                    session_destroy();
                    die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
                }

                if (isset($respuesta_portada['error'])) {
                    session_destroy();
                    die("Error realizando el servicio. " . $respuesta_portada['error']);
                }

                $_SESSION['mensaje_acc'] = "Libro actualizado correctamente con su portada";
            }
        }
    }
}

if (isset($_POST['btnContAgregar'])) {
    $error_referencia = $_POST['referencia'] == "" || !is_numeric($_POST['referencia']) || $_POST['referencia'] < 0;
    if (!$error_referencia) {
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/repetido/libros/referencia/" . urlencode($_POST['referencia']);
        $respuesta_repetido = json_decode(consumir_servicios_JWT_REST($url, "GET", $headers), true);

        if (!$respuesta_repetido) {
            session_destroy();
            die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest de repetido"));
        }

        if (isset($respuesta_repetido['error'])) {
            session_destroy();
            die("Error realizando el servicio. " . $respuesta_repetido['error']);
        }

        //respuesta_repetido --> true o false

        $error_referencia = $respuesta_repetido['repetido'];
    }

    $error_titulo = $_POST['titulo'] == "";
    $error_autor = $_POST['autor'] == "";
    $error_descripcion = $_POST['descripcion'] == "";
    $error_precio = $_POST['precio'] == "" ||  !is_numeric($_POST['precio']) || $_POST['precio'] < 0;

    if (!$_FILES['portada']['name'] == "") {
        $error_portada = !getimagesize($_FILES['portada']['tmp_name']) || $_FILES['portada']['error'] || $_FILES['portada']['size'] > 500 * 1024;
        $errores_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;
    } else {
        $errores_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;
    }

    if (!$errores_form) {
        //Si llegamos aquí significa que la referencia no está repetida
        //Se va a agregar sin portada
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $url = DIR_SERV . "/crearLibro";

        $respuesta_insertar = json_decode(consumir_servicios_JWT_REST($url, "POST", $headers, $_POST), true);

        if (!$respuesta_insertar) {
            session_destroy();
            die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
        }

        if (isset($respuesta_insertar['error'])) {
            session_destroy();
            die("Error realizando el servicio. " . $respuesta_insertar['error']);
        }

        $_SESSION['mensaje_acc'] = $respuesta_insertar['mensaje'];

        if (!$_FILES['portada']['name'] == "") {
            //Si tenemos foto actualizaremos para meter la foto
            //ruta ["tmp_name"]
            $arr = explode(".", $_FILES['portada']['full_path']);
            $ext = end($arr);
            $nuevo_nombre = "img_" . $_POST['referencia'] . "." . $ext;

            @$file = move_uploaded_file($_FILES['portada']['tmp_name'], "images/" . $nuevo_nombre);
            if (!$file) {
                echo "<p>No ha podido añadirse a la carpeta images</p>";
            } else {
                $headers[] = "Authorization: Bearer " . $_SESSION["token"];
                $url = DIR_SERV . "/actualizarPortada/" . urlencode($_POST['referencia']);

                $datos['referencia'] = $_POST['referencia'];
                $datos['portada'] = $nuevo_nombre;
                $respuesta_portada = json_decode(consumir_servicios_JWT_REST($url, "PUT", $headers, $datos), true);

                if (!$respuesta_portada) {
                    session_destroy();
                    die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
                }

                if (isset($respuesta_portada['error'])) {
                    session_destroy();
                    die("Error realizando el servicio. " . $respuesta_portada['error']);
                }

                $_SESSION['mensaje_acc'] = "Libro insertado correctamente con su portada";
            }
        }
    }
}

//Llamada a libro
if (isset($_POST['btnEditar'])) {
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $url = DIR_SERV . "/obtenerLibro/" . urlencode($_POST['btnEditar']);
    $json_detalles = json_decode(consumir_servicios_JWT_REST($url, "GET", $headers), true);

    if (!$json_detalles) {
        session_destroy();
        die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
    }

    if (isset($json_detalles['error'])) {
        session_destroy();
        die("Error realizando el servicio. " . $json_detalles['error']);
    }
}


//Llamada a Borrar
if (isset($_POST['btnContBorrar'])) {
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $url = DIR_SERV . "/borrarLibro/" . urlencode($_POST['btnContBorrar']);
    $respuesta_borrar = json_decode(consumir_servicios_JWT_REST($url, "DELETE", $headers), true);

    if (!$respuesta_borrar) {
        session_destroy();
        die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
    }

    if (isset($respuesta_borrar['error'])) {
        session_destroy();
        die("Error realizando el servicio. " . $respuesta_borrar['error']);
    }

    $_SESSION['mensaje_acc'] = $respuesta_borrar['mensaje'];
}

$url = DIR_SERV . '/obtenerLibros';
$json_libros = json_decode(consumir_servicios_REST($url, 'GET'), true);

if (!$json_libros) {
    session_destroy();
    die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
}

if (isset($json_libros['error'])) {
    session_destroy();
    die("Error realizando el servicio. " . $json_libros['error']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Libros</title>
    <style>
        td {
            padding: 1rem
        }

        .enlinea {
            display: inline
        }

        .enlace {
            cursor: pointer;
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        .mensaje {
            color: blue;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["lector"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Listado de los libros</h2>
    <table border="1" style='border-collapse:collapse'>
        <tr>
            <th style='padding:1rem'>Ref</th>
            <th>Título</th>
            <th>Acción</th>
        </tr>
        <?php
        foreach ($json_libros['libros'] as $tupla) {
            echo "<form method='post' action='index.php'>";
            echo "<tr>";
            echo "<td>" . $tupla['referencia'] . "</td>";

            echo "<td>";
            echo $tupla['titulo'];
            echo "</td>";

            echo "<td>";
            echo "<button class='enlace' type='submit' name='btnBorrar' value='" . $tupla['referencia'] . "'>Borrar</button> - ";
            echo "<button class='enlace' type='submit' name='btnEditar' value='" . $tupla['referencia'] . "'>Editar</button>";

            echo "</td>";
            echo "</tr>";
            echo "</form>";
        }
        ?>
    </table>
    <?php
    if (isset($_SESSION['mensaje_acc'])) {
        echo "<p class='mensaje'>¡" . $_SESSION['mensaje_acc'] . "!</p>";
        //Igualamos $_POST a predefinido para que no se guarden los datos en agregar
        $_POST = [];
        unset($_SESSION['mensaje_acc']);
    }

    if (isset($_POST['btnBorrar'])) {
        require "vistas/vista_borrar.php";
    } else if (isset($_POST['btnEditar'])) {
        require "vistas/vista_editar.php";
    } else {
        require "vistas/vista_agregar.php";
    }
    ?>
</body>

</html>