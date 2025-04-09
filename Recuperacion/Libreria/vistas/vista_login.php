<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;
    if (!$error_form) {
        // Comprobamos que existe

        // Conexion
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("ERROR","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        // Consulta
        try {
            $consulta = "select * from usuarios where lector = '".$_POST["usuario"]."' and clave = '".md5($_POST["clave"])."'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("ERROR","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        // Si está en la bd
        if (mysqli_num_rows($resultado) > 0) {
            // Logueado
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = md5($_POST["clave"]);
            $_SESSION["ult_acc"] = time();
            mysqli_free_result($resultado);
            mysqli_close($conexion);
            header("Location: index.php");
            exit();
        } else { // Si no está en la bd
            $error_usuario = true;
        }

        // Liberamos y cerramos
        mysqli_free_result($resultado);
        mysqli_close($conexion);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
    <style>
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
    <form action="index.php" method="post">
        <table>
            <tr>
                <td>
                    <label for="usuario">Usuario:</label>
                </td>
                <td>
                    <input type="text" id="usuario" name="usuario" maxlength="15" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
                    <?php
                    if (isset($_POST["btnLogin"]) && $error_usuario) {
                        if ($_POST["usuario"] == "")
                            echo "<span class='error'> Campo vacío.</span>";
                        else
                            echo "<span class='error'> Usuario/Contraseña no registrado en la BD.</span>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="clave">Contraseña:</label>
                </td>
                <td>
                    <input type="password" id="clave" maxlength="15" name="clave">
                    <?php
                    if (isset($_POST["btnLogin"]) && $error_clave) {
                        echo "<span class='error'> Campo vacío.</span>";
                    }
                    ?>
                </td>
            </tr>
        </table>
        <br>
        <button type="submit" name="btnLogin">Entrar</button>
    </form>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='error'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
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