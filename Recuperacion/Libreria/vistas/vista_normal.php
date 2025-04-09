<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
    <style>
        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
        div form{
            display: inline-block;
        }
        img {
            width: 100%;
            height: auto;
        }

        div#flex {
            display: flex;
            flex-flow: row wrap;
        }

        .flex33 {
            flex: 0 33%;
        }

        .flex33>p {
            text-align: center;
        }
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <em><strong><?php echo $datos_usuario_logueado["lector"] ?></strong></em> - <form action="index.php" method="post"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
    </div>
    <h2>Listado de los Libros</h2>
    <?php
    // Conexion
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
    }

    // Consulta
    try {
        $consulta = "select * from libros";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
    }

    // Mostramos
    echo "<div id='flex'>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<div class=flex33>";
        echo '<img src="Images/' . $tupla["portada"] . '" alt="Portada del libro ' . $tupla["titulo"] . '">';
        echo "<p>" . $tupla["titulo"] . " - " . $tupla["precio"] . "€</p>";
        echo "</div>";
    }
    echo "</div>";

    // Liberamos y cerramos
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>