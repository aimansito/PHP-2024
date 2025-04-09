<?php

if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
    if (isset($_POST["btnContInsertar"])) // compruebo errores
    {
        $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 30;
        if (!$error_usuario) {
            try {
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

            if (is_string($error_usuario))
                die($error_usuario);
        }

        $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;
        $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 50;
        $error_dni = $_POST["dni"] == "" || strlen($_POST["dni"]) > 10 || !dni_bien_escrito(strtoupper($_POST['dni'])) ||
            !dni_valido($_POST['dni']);
        if (!$error_dni) {

            $error_dni = repetido($conexion, "usuarios", "dni", $_POST["dni"]);

            if (is_string($error_dni))
                die($error_dni);
        }

        $error_archivo = $_FILES['archivo']['name'] != '' && ($_FILES['archivo']['error'] || !getimagesize($_FILES['archivo']['tmp_name']) || !explode('.', $_FILES['archivo']['name']) || $_FILES['archivo']['size'] > 500 * 1024);
        $error_sexo = !isset($_POST["sexo"]);
        $error_form = $error_usuario || $error_clave || $error_nombre || $error_dni || $error_sexo || $error_archivo;

        if (!$error_form) {

            if ($_FILES['archivo']['name'] == '') {
                try {
                    $consulta = "insert into usuarios (usuario,clave,nombre,dni, sexo) values ('" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "','" . $_POST["nombre"] . "','" . $_POST["dni"] . "','" . $_POST["sexo"] . "')";
                    mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
                }
            } else {
                try {
                    $consulta = "insert into usuarios (usuario,clave,nombre,dni, sexo) values ('" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "','" . $_POST["nombre"] . "','" . $_POST["dni"] . "','" . $_POST["sexo"] . "')";
                    mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
                }
                $array_nombre = explode('.', $_FILES['archivo']['name']);
                $ext = '.' . end($array_nombre); // El último sería la extensión
                $id = mysqli_insert_id($conexion);
                $nombre_nuevo = "img_" . $id . $ext;
                @$var = move_uploaded_file($_FILES['archivo']['tmp_name'], 'Img/' . $nombre_nuevo);
                if ($var) {
                    try {
                        $consulta = "update usuarios set foto='" . $nombre_nuevo . "' WHERE id_usuario='" . $id ."'";
                        mysqli_query($conexion, $consulta);
                    } catch (Exception $e) {
                        unlink('Img/' . $nombre_nuevo);
                        mysqli_close($conexion);
                        die(error_page("Práctica 8", "<h1>Práctica 8</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
                    }
                }
            }

    $_SESSION["mensaje"]="El usuario ha sido insertado con éxito";
            header("Location: index.php");
            exit;
        }

        //Por aquí continuo sólo si hay errores en el formulario

        // if (isset($conexion))
        //     mysqli_close($conexion);
    }
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Práctica Rec 2B</title>
        <style>
            .error {
                color: red
            }
        </style>
    </head>

    <body>
        <h2>Agregar Nuevo Usuario</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="nombre">Nombre: </label> <br>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre..." maxlength="50" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                    if ($_POST["nombre"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                }
                ?>
                <br>
                <label for="usuario">Usuario: </label> <br>
                <input type="text" name="usuario" id="usuario" maxlength="30" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    elseif (strlen($_POST["usuario"]) > 30)
                        echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
                    else
                        echo "<span class='error'> Usuario repetido</span>";
                }
                ?>
                <br>
                <label for="clave">Contraseña: </label> <br>
                <input type="password" name="clave" maxlength="15" placeholder="Contraseña..." id="clave">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_clave) {
                    if ($_POST["clave"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                }
                ?>
                <br>
                <label for="email">DNI: </label> <br>
                <input type="text" name="dni" id="dni" maxlength="50" placeholder="DNI: 11223344Z" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>">
                <?php
                if (isset($_POST['btnContInsertar']) && $error_dni) {
                    if ($_POST['dni'] == '') {
                        echo "<span class='error'> Campo vacío </span>";
                    } else if (!dni_bien_escrito(strtoupper($_POST['dni']))) {
                        echo "<span class='error'> DNI no está bien escrito </span>";
                    } else if (!dni_valido($_POST['dni'])) {
                        echo "<span class='error'> DNI no válido </span>";
                    } else {
                        echo "<span class='error'> DNI repetido </span>";
                    }
                }
                ?>
                <br>
                <label>Sexo: </label>
                <?php
                if (isset($_POST['btnContInsertar']) && $error_sexo) {
                    echo "<span class='error'> No has seleccionado ningún sexo </span>";
                }
                ?><br>
                <input type="radio" name="sexo" id="hombre" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked"; ?>> <label for="hombre"> Hombre</label> <br>
                <input type="radio" name="sexo" id="mujer" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?>> <label for="mujer"> Mujer</label>
            </p>
            <p>
                <label for="archivo">Incluir mi foto (Máx. 500KB): </label>
                <input type="file" name="archivo" id="archivo" accept="image/*">
                <?php
                if (isset($_POST['btnContInsertar']) && $error_archivo) {
                    if ($_FILES['archivo']['name'] != '') {
                        if ($_FILES['archivo']['error']) {
                            echo "<span class = 'error'> No se ha podido subir el archivo al servidor </span>";
                        } else if (!getimagesize($_FILES['archivo']['tmp_name'])) {
                            echo "<span class = 'error'> El archivo seleccionado no es una imagen </span>";
                        } else {
                            echo "<span class = 'error'> El archivo seleccionado supera los 500KB </span>";
                        }
                    }
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnContInsertar">Guardar cambios</button>
                <button type="submit">Atrás</button>
            </p>
        </form>
    </body>

    </html>
<?php
} else {
    header("Location:index.php");
    exit;
}
?>