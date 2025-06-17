<?php
if (isset($_POST["btnLogin"])) {

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form_login = $error_usuario || $error_clave;

    if (!$error_form_login) {
        $url = DIR_SERV . "/login";
        $datos_env["lector"] = $_POST["usuario"];
        $datos_env["clave"] = md5($_POST["clave"]);
        $respuesta = consumir_servicios_REST($url, "POST", $datos_env);
        $json_respuesta = json_decode($respuesta, true);

        if (!$json_respuesta) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }

        if (isset($json_respuesta["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_respuesta["error"] . "</p>"));
        }

        if (isset($json_respuesta["mensaje"])) {
            $error_usuario = true;
        } else {
            $_SESSION["token"] = $json_respuesta["token"];
            $_SESSION["ultm_accion"] = time();
            header("Location:index.php");
            exit;
        }
    }
}

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
        .error {
            color: red
        }

        .mensaje {
            color: blue;
            font-size: 1.25rem
        } 

        section{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-around;
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
    <form action="index.php" method="post">
        <table>
            <tr>
                <td><label for="usuario">Usuario: </label></td>
                <td><input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>" /></td>
                <td>
                    <?php
                    if (isset($_POST["btnLogin"]) && $error_usuario) {
                        if ($_POST["usuario"] == "")
                            echo "<span class='error'>* Campo vacío *</span>";
                        else
                            echo "<span class='error'>* Usuario y/o contraseña incorrectos  *</span>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="clave">Contraseña: </label></td>
                <td><input type="password" name="clave" id="clave" /></td>
                <td>
                    <?php
                    if (isset($_POST["btnLogin"]) && $error_clave) {
                        echo "<span class='error'>* Campo vacío *</span>";
                    }
                    ?>
                </td>
            </tr>
        </table>
        <p>
            <button name="btnLogin" type="submit">Login</button>
        </p>
    </form>
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