<?php
$url = DIR_SERV . "/obtenerLibros";
$respuesta = consumir_servicios_REST($url, "GET");
$json_obtenerLibros = json_decode($respuesta, true);

if (!$json_obtenerLibros) {
    session_destroy();
    die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}
if (isset($json_obtenerLibro["error"])) {
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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Libros</title>
    <style>
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

        section {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 3rem;
        }

        article {
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        img {
            width: 10rem;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["lector"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <?php
    echo "<h2>Listado de Libros</h2>";
    echo "<section>";
    foreach ($json_obtenerLibros["libros"] as $tupla) {
        echo "<article>";
        echo "<picture>";
        echo "<img src='images/" . $tupla["portada"] . "' title='Portada' alt='Portada'>";
        echo "</picture>";
        echo "<div>";
        echo  $tupla["titulo"] . " - " . $tupla["precio"] . " €";
        echo "</div>";
        echo "</article>";
    }
    echo "</section>";

    if (isset($_SESSION["mensaje_seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["mensaje_seguridad"] . "</p>";
        unset($_SESSION["mensaje_seguridad"]);
    }
    ?>
</body>

</html>