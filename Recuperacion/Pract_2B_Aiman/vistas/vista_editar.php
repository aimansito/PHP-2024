<?php
if (isset($_POST["btnEditar"]))
    $id_usuario = $_POST["btnEditar"];
else
    $id_usuario = $_POST["id_usuario"];

if (!isset($conexion)) {
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
    }
}
try {
    $consulta = "select * from usuarios where id_usuario='" . $id_usuario . "'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}
if (mysqli_num_rows($resultado) > 0) {
    if (isset($_POST["btnEditar"])) {    //Recojo datos obtenidos de la BD
        $datos_usuario = mysqli_fetch_assoc($resultado);
        $nombre = $datos_usuario["nombre"];
        $usuario = $datos_usuario["usuario"];
        //$clave=$datos_usuario["clave"];
        $dni = $datos_usuario["dni"];
        $sexo = $datos_usuario["sexo"];
        $foto = $datos_usuario["foto"];
    } else {
        $nombre = $_POST["nombre"];
        $usuario = $_POST["usuario"];
        //$clave=$datos_usuario["clave"];
        $dni = $_POST["dni"];
        $sexo = $_POST["sexo"];
        $foto = $_POST["foto_bd"];
    }
    mysqli_free_result($resultado);
} else {
    $mensaje_error_usuario = "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";
}

if (isset($mensaje_error_usuario))
    echo $mensaje_error_usuario;
else {
?>
    <h2>Editando al usuario <?php echo $id_usuario; ?></h2>
    <form action="index.php" method="post" enctype="multipart/form-data" class="paralelo">
        <div class="column">
            <p>
                <label for="nombre">Nombre: </label> <br>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre..." maxlength="50" value="<?php echo $nombre ?>">
                <?php
                if (isset($_POST["btnContEditar"]) && $error_nombre) {
                    if ($_POST["nombre"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                }
                ?>
                <br>
                <label for="usuario">Usuario: </label> <br>
                <input type="text" name="usuario" id="usuario" maxlength="30" placeholder="Usuario..." value="<?php echo $usuario ?>">
                <?php
                if (isset($_POST["btnContEditar"]) && $error_usuario) {
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
                if (isset($_POST["btnContEditar"]) && $error_clave) {
                    if ($_POST["clave"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                }
                ?>
                <br>
                <label for="email">DNI: </label> <br>
                <input type="text" name="dni" id="dni" maxlength="50" placeholder="DNI: 11223344Z" value="<?php echo $dni ?>">
                <?php
                if (isset($_POST['btnContEditar']) && $error_dni) {
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
                <label>Sexo: </label><br>
                <input type="radio" name="sexo" id="hombre" value="hombre" <?php if ($sexo == "hombre") echo "checked"; ?>> <label for="hombre"> Hombre</label> <br>
                <input type="radio" name="sexo" id="mujer" value="mujer" <?php if ($sexo == "mujer") echo "checked"; ?>> <label for="mujer"> Mujer</label>
            </p>
            <p>
                <label for="archivo">Incluir mi foto (Máx. 500KB): </label>
                <input type="file" name="archivo" id="archivo" accept="image/*">
                <?php
                if (isset($_POST['btnContEditar']) && $error_archivo) {
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
                <input type="hidden" name="foto_bd" value="<?php echo $foto ?>">
                <input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>">
                <button type="submit" name="btnContEditar">Guardar cambios</button>
                <button type="submit">Atrás</button>
            </p>
        </div>
        <div class="column centrar_flex">
            <img src="Img/<?php echo $foto ?>" alt="Imagen de <?php echo $nombre ?>" height="250px">
            <?php

            if (isset($_POST["btnBorrarFoto"])) {
                echo '<p>¿Estas seguro de eliminar esta foto?</p>
                <p><button type="submit" name="btnContBorrarFoto">Sí</button>
                <button type="submit" name="btnNoBorrarFoto">No</button></p>';
            } elseif ($foto != "no_imagen.png") {
                echo '<button type="submit" name="btnBorrarFoto">Borrar foto</button>';
            }
            ?>
        </div>
    </form>
<?php
}
?>