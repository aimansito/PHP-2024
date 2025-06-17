<?php
$url = DIR_SERV . "/obtenerLibros";
$respuesta = consumir_servicios_REST($url, "GET");
$json_obtenerLibros = json_decode($respuesta, true);

if (!$json_obtenerLibros) {
    session_destroy();
    die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}
if (isset($json_obtenerLibros["error"])) {
    session_destroy();
    die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_obtenerLibros["error"] . "</p>"));
}

if (isset($json_obtenerLibros["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}
if (isset($json_obtenerLibros["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnContinuar"])) {
    $url = DIR_SERV . "/borrarLibro/" . $_POST["btnContinuar"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "DELETE", $headers);
    $json_borrarLibro = json_decode($respuesta, true);

    if (!$json_borrarLibro) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }
    if (isset($json_borrarLibro["error"])) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_borrarLibro["error"] . "</p>"));
    }

    if (isset($json_borrarLibro["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if (isset($json_borrarLibro["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["mensaje_accion"] = $json_borrarLibro["mensaje"];
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnEditar"])) {
    $url = DIR_SERV . "/obtenerLibro/" . $_POST["btnEditar"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_obtenerLibro_editar = json_decode($respuesta, true);

    if (!$json_obtenerLibro_editar) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }
    if (isset($json_obtenerLibro_editar["error"])) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_obtenerLibro_editar["error"] . "</p>"));
    }

    if (isset($json_obtenerLibro_editar["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if (isset($json_obtenerLibro_editar["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
}

if (isset($_POST["btnCntEditar"])) {

    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] < 0;

    $errores_form_editar = $error_titulo || $error_autor || $error_precio;

    if (!$errores_form_editar) {
        $url = DIR_SERV . "/actualizarLibro/" . $_POST["btnCntEditar"];
        $datos_libro["titulo"] = $_POST["titulo"];
        $datos_libro["autor"] = $_POST["autor"];
        $datos_libro["descripcion"] = $_POST["descripcion"];
        $datos_libro["precio"] =  $_POST["precio"];
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $respuesta = consumir_servicios_JWT_REST($url, "PUT", $headers, $datos_libro);
        $json_actualizarLibro = json_decode($respuesta, true);

        if (!$json_actualizarLibro) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_actualizarLibro["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_actualizarLibro["error"] . "</p>"));
        }

        if (isset($json_actualizarLibro["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_actualizarLibro["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"] = $json_actualizarLibro["mensaje"];
        header("Location:index.php");
        exit;
    }
}

if (isset($_POST["btnAgregar"])) {

    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]);
    if (!$error_referencia) {
        $tabla = "libros";
        $columna = "referencia";
        $url = DIR_SERV . "/repetido/" . $tabla . "/" . $columna . "/" . $_POST["referencia"];
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_repetido = json_decode($respuesta, true);

        if (!$json_repetido) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_repetido["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_repetido["error"] . "</p>"));
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

        $error_referencia = $json_repetido["repetido"];
    }
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] < 0;

    $errores_form_crear = $error_referencia || $error_titulo || $error_autor || $error_precio;

    if (!$errores_form_crear) {
        $url = DIR_SERV . "/crearLibro";
        $datos_libro["referencia"] = $_POST["referencia"];
        $datos_libro["titulo"] = $_POST["titulo"];
        $datos_libro["autor"] = $_POST["autor"];
        $datos_libro["descripcion"] = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
        $datos_libro["precio"] =  $_POST["precio"];
        $headers[] = "Authorization: Bearer " . $_SESSION["token"];
        $respuesta = consumir_servicios_JWT_REST($url, "POST", $headers, $datos_libro);
        $json_crearLibro = json_decode($respuesta, true);

        if (!$json_crearLibro) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_crearLibro["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_crearLibro["error"] . "</p>"));
        }

        if (isset($json_crearLibro["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_crearLibro["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"] = $json_crearLibro["mensaje"];
        header("Location:index.php");
        exit;
    }
}

if (isset($_POST["btnDetalle"])) {
    $url = DIR_SERV . "/obtenerLibro/" . $_POST["btnDetalle"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_obtenerLibro_detalle = json_decode($respuesta, true);

    if (!$json_obtenerLibro_detalle) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }
    if (isset($json_obtenerLibro_detalle["error"])) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_obtenerLibro_detalle["error"] . "</p>"));
    }

    if (isset($json_obtenerLibro_detalle["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if (isset($json_obtenerLibro_detalle["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Libros</title>
    <style>
        .error {
            color: red;
        }

        .enlinea {
            display: inline
        }

        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        table.tBordes,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table.tBordes {
            margin: auto;
            width: 50%;
        }

        th {
            background-color: lightgrey;
        }

        td {
            text-align: center;
        }

        .tMedio {
            padding: 0 2rem 0 2rem;
        }

        .noBorde {
            border: none;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido
        <strong><?php echo $datos_usu_log["lector"]; ?></strong> -
        <form class="enlinea" action="index.php" method="post">
            <button class="enlace" type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php
    if (isset($_SESSION["mensaje_accion"])) {
        echo "<p>" . $_SESSION["mensaje_accion"] . "</p>";
        unset($_SESSION["mensaje_accion"]);
    }

    if (isset($_POST["btnBorrar"])) {
        echo "<h2>Borrar Libro</h2>";
        echo "<p>";
        echo "<p>¿Quiéres borrar el libro con la referencia: <strong>" . $_POST["btnBorrar"] . "</strong>?</p>";
        echo "<form action='index.php' method='post' class='enlinea'>";
        echo "<button type='submit' name='btnContinuar' value='" . $_POST["btnBorrar"] . "'>Continuar</button> - ";
        echo "<button type='submit'>Atrás</button>";
        echo "</form>";
        echo "</p>";
    }

    if (isset($_POST["btnEditar"]) || isset($_POST["btnCntEditar"])) {
        echo "<h2>Editar Libro</h2>";
        echo "<p>¿Quiéres editar el libro con la referencia: <strong>" . $_POST["btnEditar"] . "</strong>?</p>";
        echo "<form action='index.php' method='post'>";
        echo "<table>";
        echo "<tr>";
        echo "<td class='noBorde'><label for=''><strong>Título:</strong></label></td>";
        echo "<td class='noBorde'><input type='text' name='titulo' value='" . $json_obtenerLibro_editar["libro"]["titulo"] . "'></td>";
        echo "<td class='noBorde'>";
        if (isset($_POST["btnCntEditar"]) && $error_titulo) {
            echo "<span class='error'>*Campo vacio*</span>";
        }
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='noBorde'><label for=''><strong>Autor</strong></label></td>";
        echo "<td class='noBorde'><input type='text' name='autor' value='" . $json_obtenerLibro_editar["libro"]["autor"] . "'></td>";
        echo "<td class='noBorde'>";
        if (isset($_POST["btnCntEditar"]) && $error_autor) {
            echo "<span class='error'>*Campo vacio*</span>";
        }
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='noBorde'><label for=''><strong>Descripción:</strong></label></td>";
        echo "<td class='noBorde'><textarea name='descripcion' id='' rows='3' cols='21'>" . $json_obtenerLibro_editar["libro"]["descripcion"] . "</textarea></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='noBorde'><label for=''><strong>Precio:</strong></label></td>";
        echo "<td class='noBorde'><input type='text' name='precio' value='" . $json_obtenerLibro_editar["libro"]["precio"] . "'></td>";
        echo "<td class='noBorde'>";
        if (isset($_POST["btnCntEditar"]) && $error_precio) {
            if ($_POST["precio"] == "") {
                echo "<span class='error'>*Campo vacio*</span>";
            } else if (!is_numeric($_POST["precio"])) {
                echo "<span class='error'>*Debes insertar un valor númerico*</span>";
            } else {
                echo "<span class='error'>*Debe ser mayor que 0*</span>";
            }
        }
        echo "</td>";
        echo "</tr>";
        /*
        echo "<tr>";
        echo "<td class='noBorde'><label for=''><strong>Portada:</strong></label></td>";
        echo "<td class='noBorde'><input type='file'></td>";
        echo "<td class='noBorde'></td>";
        echo "</tr>";
        */
        echo "</table>";
        echo "<input type='hidden' name='btnEditar' value='" . $_POST["btnEditar"] . "'>";
        echo "<button type='submit' name='btnCntEditar' value='" . $_POST["btnEditar"] . "'>Editar</button>";
        echo "</form>";
        echo "<form action='index.php' method='post' class='enlinea'>";
        echo "<button type='submit' name='btnAtras'>Atrás</button>";
        echo "</form>";
    }

    if (isset($_POST["btnDetalle"])) {
        echo "<div>";
        echo "<p><strong>Referencia:</strong>" . $json_obtenerLibro_detalle["libro"]["referencia"] . "</p>";
        echo "<p><strong>Título:</strong>" . $json_obtenerLibro_detalle["libro"]["titulo"] . "</p>";
        echo "<p><strong>Autor:</strong>" . $json_obtenerLibro_detalle["libro"]["autor"] . "</p>";
        echo "<p><strong>Precio:</strong>" . $json_obtenerLibro_detalle["libro"]["precio"] . "</p>";
        echo "<form action='index.php' method='post' class='enlinea'>";
        echo "<button type='submit' name='btnAtras' class='enlace'>Atrás</button>";
        echo "</form>";
        echo "</div>";
    }
    ?>
    <h2>Listado de los libros</h2>
    <?php
    echo "<table class='tBordes'>";
    echo "<tr>";
    echo "<th>Ref</th>";
    echo "<th>Título</th>";
    echo "<th>Acción</th>";
    echo "</tr>";
    foreach ($json_obtenerLibros["libros"] as $tupla) {
        echo "<tr>";
        echo "<td>" . $tupla["referencia"] . "</td>";
        echo "<td class='tMedio'>";
        echo "<form action='index.php' method='post' class='enlinea'>";
        echo "<button type='submit' name='btnDetalle' value='" . $tupla["referencia"] . "' class='enlace'>" . $tupla["titulo"] . "</button>";
        echo "</form>";
        echo "</td>";
        echo "<td>";
        echo "<form action='index.php' method='post' class='enlinea'>";
        echo "<button type='submit' name='btnBorrar' value='" . $tupla["referencia"] . "' class='enlace'>Borrar</button> - ";
        echo "<button type='submit' name='btnEditar' value='" . $tupla["referencia"] . "' class='enlace'>Editar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<h2>Agregar un nuevo libro</h2>";

    echo "<form action='index.php' method='post'>";
    echo "<table>";
    echo "<tr>";
    echo "<td class='noBorde'><label for=''><strong>Referencia:</strong></label></td>";
    echo "<td class='noBorde'><input type='text' name='referencia'>";
    if (isset($_POST["btnAgregar"]) && $error_referencia) {
        if ($_POST["referencia"] == "") {
            echo "<span class='error'>*Campo vacio*</span>";
        } else if (!is_numeric($_POST["referencia"])) {
            echo "<span class='error'>*Debes introducir un número*</span>";
        } else {
            echo "<span class='error'>*Campo repetido*</span>";
        }
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='noBorde'><label for=''><strong>Título:</strong></label></td>";
    echo "<td class='noBorde'><input type='text' name='titulo'>";
    if (isset($_POST["btnAgregar"]) && $error_titulo) {
        echo "<span class='error'>*Campo vacio*</span>";
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='noBorde'><label for=''><strong>Autor</strong></label></td>";
    echo "<td class='noBorde'><input type='text' name='autor'>";
    if (isset($_POST["btnAgregar"]) && $error_autor) {
        echo "<span class='error'>*Campo vacio*</span>";
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='noBorde'><label for=''><strong>Descripción:</strong></label></td>";
    echo "<td class='noBorde'><textarea name='' id='' rows='3' cols='21'></textarea></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='noBorde'><label for=''><strong>Precio:</strong></label></td>";
    echo "<td class='noBorde'><input type='text' name='precio'>";
    if (isset($_POST["btnAgregar"]) && $error_precio) {
        if ($_POST["precio"] == "") {
            echo "<span class='error'>*Campo vacio*</span>";
        } else if (!is_numeric($_POST["precio"])) {
            echo "<span class='error'>*Debes insertar un valor númerico*</span>";
        } else {
            echo "<span class='error'>*Debe ser mayor que 0*</span>";
        }
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class='noBorde'><label for=''><strong>Portada:</strong></label></td>";
    echo "<td class='noBorde'><input type='file'></td>";
    echo "<td class='noBorde'></td>";
    echo "</tr>";
    echo "</table>";
    echo "<button type='submit' name='btnAgregar'>Agregar</button>";
    echo "</form>";
    ?>
</body>

</html>