<?php
if (isset($_POST["btnBorrar"])) {
    $_SESSION["mensaje"] = "El libro con Referencia " . $_POST["ref"] . " ha sido borrado con éxito.";
    header("Location: gest_libros.php");
    exit();
}

if (isset($_POST["btnEditar"])) {
    $_SESSION["mensaje"] = "El libro con Referencia " . $_POST["ref"] . " ha sido editado con éxito.";
    header("Location: gest_libros.php");
    exit();
}

if (isset($_POST["btnContInsertar"])) {
    $error_ref = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] <= 0;
    if (!$error_ref) {
        // Conexion
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
        }

        // Consulta
        $error_ref = repetido($conexion, "libros", "referencia", $_POST["referencia"]);
        if (is_string($error_ref)) {
            $error_ref = true;
        }
    }
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;
    $error_portada = $_FILES["portada"]["name"] != "" && ($_FILES["portada"]["error"] || !getimagesize($_FILES["portada"]["tmp_name"])
        || !explode(".", $_FILES["portada"]["name"]) || $_FILES["portada"]["size"] >= 750 * 1024);
    $error_form = $error_ref || $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;

    if (!$error_form) {
        // Conexion
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                session_destroy();
                die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
            }
        }

        // Consulta
        try {
            $consulta = "insert into libros (referencia, titulo, autor, descripcion, precio) 
            values ('".$_POST["referencia"]."','".$_POST["titulo"]."','".$_POST["autor"]."','".$_POST["descripcion"]."','".$_POST["precio"]."')";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("ERROR","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        // Comprobamos si ha subido una portada
        if ($_FILES["portada"]["name"] != "") {
            $array_nombre = explode(".", $_FILES["portada"]["name"]);
            $ext = "." . end($array_nombre);
            $nombre_nuevo = "img".$_POST["referencia"].$ext;

            if (move_uploaded_file($_FILES["portada"]["tmp_name"],"../Images/".$nombre_nuevo)) {
                
                try {
                    $consulta = "update libros set portada = '".$nombre_nuevo."' where referencia = '".$_POST["referencia"]."'";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    unlink("../Images/".$nombre_nuevo);
                    session_destroy();
                    mysqli_close($conexion);
                    die(error_page("ERROR","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
                }
            }
        }


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
        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        div form {
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

        body>table {
            border-collapse: collapse;
            width: 80%;
            text-align: center;
            margin: 0 auto;
        }

        body>table th,
        body>table tr,
        body>table td {
            border: 1px solid black;
        }

        body>table th {
            background-color: #CCC;
        }

        .mensaje {
            color: blue;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <em><strong><?php echo $datos_usuario_logueado["lector"] ?></strong></em> - <form action="../index.php" method="post"><button type="submit" name="btnSalir" class="enlace">Salir</button></form>
    </div>
    <?php
    if (isset($_SESSION["mensaje"])) {
        echo "<p class='mensaje'>" . $_SESSION["mensaje"] . "</p>";
        unset($_SESSION["mensaje"]);
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
    echo "<table>";
    echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $tupla["referencia"] . "</td>";
        echo "<td>" . $tupla["titulo"] . "</td>";
        echo "<td><form action='gest_libros.php' method='post'>
        <input type='hidden' name='ref' value='" . $tupla["referencia"] . "'>
        <button type='submit' name='btnBorrar' class='enlace'>Borrar</button> - 
        <button type='submit' name='btnEditar' class='enlace'>Editar</button>
        </form></td>";
        echo "</tr>";
    }
    echo "</table>";

    if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
    ?>
        <h2>Agregar un nuevo libro</h2>
        <form action="gest_libros.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="referencia">Referencia: </label></td>
                    <td>
                        <input type="text" id="referencia" name="referencia" maxlength="11" value="<?php if (isset($_POST["referencia"])) echo $_POST["referencia"] ?>">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_ref) {
                            if ($_POST["referencia"] == "")
                                echo "<span class='error'> Campo vacío.</span>";
                            else if (!is_numeric($_POST["referencia"]))
                                echo "<span class='error'> La referencia no es un número.</span>";
                            else if ($_POST["referencia"] <= 0)
                                echo "<span class='error'> La referencia tiene que ser mayor que 0.</span>";
                            else
                                echo "<span class='error'> Referencia repetida.</span>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label for="titulo">Título: </label></td>
                    <td>
                        <input type="text" id="titulo" name="titulo" maxlength="30" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"] ?>">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_titulo)
                            echo "<span class='error'> Campo vacío.</span>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label for="autor">Autor: </label></td>
                    <td>
                        <input type="text" id="autor" name="autor" maxlength="30" value="<?php if (isset($_POST["autor"])) echo $_POST["autor"] ?>">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_autor)
                            echo "<span class='error'> Campo vacío.</span>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label for="descripcion">Descripción: </label></td>
                    <td>
                        <textarea id="descripcion" name="descripcion" maxlength="150"><?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"] ?></textarea>
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_descripcion) 
                                echo "<span class='error'> Campo vacío.</span>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label for="precio">Precio: </label></td>
                    <td>
                        <input type="text" id="precio" name="precio" maxlength="6" value="<?php if (isset($_POST["precio"])) echo $_POST["precio"] ?>">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_precio) {
                            if ($_POST["precio"] == "")
                                echo "<span class='error'> Campo vacío.</span>";
                            else if (!is_numeric($_POST["precio"]))
                                echo "<span class='error'> El precio no es un número.</span>";
                            else 
                                echo "<span class='error'> El precio tiene que ser mayor que 0.</span>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><label for="portada">Portada: </label></td>
                    <td>
                        <input type="file" id="portada" name="portada" accept="image/*">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_portada) {
                            if ($_FILES["portada"]["error"])
                                echo "<span class='error'> Ha habido un error al subir el archivo.</span>";
                            else if (!getimagesize($_FILES["portada"]["tmp_name"]))
                                echo "<span class='error'> El archivo subido no es una imagen.</span>";
                            else if (!explode(".", $_FILES["portada"]["tmp_name"]))
                                echo "<span class='error'> El archivo subido no tiene extensión.</span>";
                            else
                                echo "<span class='error'> El archivo subido es mayor o igual a 750KB.</span>";
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <button type='submit' name='btnContInsertar'>Agregar</button>
        </form>
    <?php
    } else {
        echo "<form action='gest_libros.php' method='post'>
    <button type='submit' name='btnInsertar'>Agregar</button>
    </form>";
    }


    // Liberamos y cerramos
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>