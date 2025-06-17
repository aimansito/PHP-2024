<?php

if (isset($_POST["btnCancelar"])) {
    unset($_POST);
}
if (isset($_POST["btnContEditando"])) {

    $error_titulo = $_POST["titulo2"] == "";
    $error_autor = $_POST["autor2"] == "";
    $error_descripcion = $_POST["descripcion2"] == "";
    $error_precio = $_POST["precio2"] == "";

    $errores_form_editar = $error_titulo || $error_autor || $error_descripcion || $error_precio;
    echo "AAA";
    if (!$errores_form_editar) {
        $datos_editar["titulo"] = $_POST["titulo2"];
        $datos_editar["autor"] = $_POST["autor2"];
        $datos_editar["descripcion"] = $_POST["descripcion2"];
        $datos_editar["precio"] = $_POST["precio2"];
        $url = DIR_SERV . "/actualizarLibro/" . $_POST["btnContEditando"];
        $respuesta = consumir_servicios_JWT_REST($url, "put", $headers, $datos_editar);
        $json_respuesta_editando = json_decode($respuesta, true);
        if (!$json_respuesta_editando) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_respuesta_editando["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_respuesta_editando["error"] . "</p>"));
        }

        if (isset($json_respuesta_editando["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_respuesta_editando["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $_SESSION["mensajeAgregado"] = $json_respuesta_editando["mensaje"];
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
        $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
        $json_usuario_repetido = json_decode($respuesta, true);
        if (!$json_usuario_repetido) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_usuario_repetido["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_usuario_repetido["error"] . "</p>"));
        }

        if (isset($json_usuario_repetido["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_usuario_repetido["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }

        $error_referencia = $json_usuario_repetido["repetido"];
        
    }
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "";

    $errores_form_agregar = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;
    if (!$errores_form_agregar) {

        $datos_añadir["referencia"] = $_POST["referencia"];
        $datos_añadir["titulo"] = $_POST["titulo"];
        $datos_añadir["autor"] = $_POST["autor"];
        $datos_añadir["descripcion"] = $_POST["descripcion"];
        $datos_añadir["precio"] = $_POST["precio"];
        $url = DIR_SERV . "/crearLibro";
        $respuesta = consumir_servicios_JWT_REST($url, "post", $headers, $datos_añadir);
        $json_respuesta_añadir = json_decode($respuesta, true);
        if (!$json_respuesta_añadir) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
        }
        if (isset($json_respuesta_añadir["error"])) {
            session_destroy();
            die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_respuesta_añadir["error"] . "</p>"));
        }

        if (isset($json_respuesta_añadir["no_auth"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if (isset($json_respuesta_añadir["mensaje_baneo"])) {
            session_unset();
            $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit;
        }
        $_SESSION["mensajeAgregado"] = $json_respuesta_añadir["mensaje"];
        header("Location:index.php");
        exit;
    }
}



if (isset($_POST["btnContBorrado"])) {
    $url = DIR_SERV . "/borrarLibro/" . $_POST["btnContBorrado"];
    $respuesta = consumir_servicios_JWT_REST($url, "DELETE", $headers);
    $json_respuesta_borrado = json_decode($respuesta, true);
    if (!$json_respuesta_borrado) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_respuesta_borrado["error"])) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_respuesta_borrado["error"] . "</p>"));
    }

    if (isset($json_respuesta_borrado["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if (isset($json_respuesta_borrado["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    $_SESSION["mensajeBorrado"] = $json_respuesta_borrado["mensaje"];
    header("Location:index.php");
        exit;
}

if (isset($_POST["btnEditar"])  || isset($_POST["btnContEditado"])) {

    $url = DIR_SERV . "/obtenerLibro/" . $_POST["btnEditar"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_datos = json_decode($respuesta, true);
    if (!$json_datos) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_datos["error"])) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_datos["error"] . "</p>"));
    }

    if (isset($json_datos["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_datos["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
    $json_datos_libro = $json_datos["libro"];
}



if (isset($_POST["btnDetalles"])) {

    $url = DIR_SERV . "/obtenerLibro/" . $_POST["btnDetalles"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_datos_libro = json_decode($respuesta, true);
    if (!$json_datos_libro) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }
    if (isset($json_datos_libro["error"])) {
        session_destroy();
        die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_datos_libro["error"] . "</p>"));
    }

    if (isset($json_datos_libro["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if (isset($json_datos_libro["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
}

// LISTADO DE LOS LIBROS
$url = DIR_SERV . "/obtenerLibros";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_lista_libros = json_decode($respuesta, true);
if (!$json_lista_libros) {
    session_destroy();
    die(error_page("Gestión Libros", "<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}
if (isset($json_lista_libros["error"])) {
    session_destroy();
    die(error_page("Gestión Libros", "<h1>Librería</h1><p>" . $json_lista_libros["error"] . "</p>"));
}

if (isset($json_lista_libros["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}
if (isset($json_lista_libros["mensaje_baneo"])) {
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

        table {
            border-collapse: collapse;
            text-align: center;
            width: 80%;
        }

        tr,
        td,
        th {
            padding: 8px;
            border: solid 1px;
            text-align: center;
        }

        th {
            background-color: lightgray;
        }

        img {
            width: 20%;
            height: auto;
        }

        .sin_bordes {
            border: none;
            background: none;
            text-align: left;
        }

        .error_form {
            color: red;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>Bienvenido Administrador <strong><?php echo $datos_usu_log["lector"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Listado de los libros</h2>
    <?php
    echo "<table border='1'>";
    echo "<tr><th>Ref</th><th>Titulo</th><th>Acción</th></tr>";
    foreach ($json_lista_libros["libros"] as $tupla) {
        echo "<tr>";
        echo "<td>" . $tupla["referencia"] . "</td>";
        echo "<td><form action='index.php' method='post'><button type='submit' class='enlace' name='btnDetalles' value='" . $tupla["referencia"] . "'>" . $tupla["titulo"] . "</button></form></td>";
        echo "<td>";
        echo "<form action='index.php' method='post'>";
        echo "<button class='enlace' type='submit' name='btnBorrar' value='" . $tupla["referencia"] . "'>Borrar</button> - ";
        echo "<button class='enlace' type='submit' name='btnEditar' value='" . $tupla["referencia"] . "'>Editar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // MENSAJES DE $SESIONS AL BORRAR,CREAR Y EDITAR
    if (isset($_SESSION["mensajeBorrado"])) {
        echo "<p>" . $_SESSION["mensajeBorrado"] . "</p>";
        unset($_SESSION["mensajeBorrado"]);
    } else if (isset($_SESSION["mensajeAgregado"])) {
        echo "<p>" . $_SESSION["mensajeAgregado"] . "</p>";
        unset($_SESSION["mensajeAgregado"]);
    }
    /////




    if (isset($_POST["btnDetalles"])) {
        echo "<h2>Detalles del libro con referencia:" . $_POST["btnDetalles"] . "</h2>";

        echo "<p>Referencia:" . $json_datos_libro["libro"]["referencia"] . "</p>";
        echo "<p>Titulo:" . $json_datos_libro["libro"]["titulo"] . "</p>";
        echo "<p>Autor:" . $json_datos_libro["libro"]["autor"] . "</p>";
        echo "<p>Descripción:" . $json_datos_libro["libro"]["descripcion"] . "</p>";
        echo "<p>portada:<img src='images/" . $json_datos_libro["libro"]["portada"] . "' alt='portada' /></p>";

        echo "<form action='index.php' method='post'><button type='submit' >Volver</button></form>";
    } else if (isset($_POST["btnBorrar"])) {
        echo "<br><form action='index.php' method='post'>";
        echo "<label>¿Estas seguro de borrar el libro con referencia:" . $_POST["btnBorrar"] . "?</label>";
        echo "<button type='submit' name='btnCancelar'>Cancelar</button> - ";
        echo "<button type='submit' name='btnContBorrado' value='" . $tupla["referencia"] . "'>Continuar</button>";
        echo "<form>";
    } else if (isset($_POST["btnEditar"])  || isset($_POST["btnContEditando"])) {


        if (isset($_POST["btnEditar"])) {
            if (isset($json_datos_libro)) {

                $referencia = $json_datos_libro["referencia"];
                $titulo = $json_datos_libro["titulo"];
                $autor = $json_datos_libro["autor"];
                $descripcion = $json_datos_libro["descripcion"];
                $precio = $json_datos_libro["precio"];
            } else {
                die("<h2>Editando el usuario " . $_POST["btnEditar"] . "</h2><p>El usuario seleccionado ya no se encuentra en la BD</p></body></html>");
            }
        } else {
            $referencia = $_POST["referencia"];
            $titulo = $_POST["titulo2"];
            $autor = $_POST["autor2"];
            $descripcion = $_POST["descripcion2"];
            $precio = $_POST["precio2"];
        }
    ?>
        <div>
            <h2><strong>Editando el libro con referencia:</strong> <?php echo $referencia ?></h2>
            <form action="index.php" method="post">
                <p>
                    <label for="referencia">Referencia</label>
                    <input type="text" name="referencia" id="referencia" value="<?php echo $referencia ?>">
                </p>
                <p>
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo2" id="titulo" value="<?php echo $titulo ?>">
                    <?php
                    if (isset($_POST["btnContEditando"]) && $error_titulo) {
                        echo "<span class='error_form'>***Campo Vacio***</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="autor">Autor</label>
                    <input type="text" name="autor2" id="autor" value="<?php echo $autor ?>">
                    <?php
                    if (isset($_POST["btnContEditando"]) && $error_autor) {
                        echo "<span class='error_form'>***Campo Vacio***</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="descripcion">Descripcion</label>
                    <textarea name="descripcion2" id="descripcion" cols="30"><?php echo $descripcion ?></textarea>
                    <?php
                    if (isset($_POST["btnContEditando"]) && $error_descripcion) {
                        echo "<span class='error_form'>***Campo Vacio***</span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="precio">Precio</label>
                    <input type="number" name="precio2" id="precio" min='0' value="<?php echo $precio ?>">
                    <?php
                    if (isset($_POST["btnContEditando"]) && $error_precio) {
                        echo "<span class='error_form'>***Campo Vacio***</span>";
                    }
                    ?>
                </p>

                <!--<p><label for="portada">Portada</label><input type="file" name="portada" id="portada" accept="image/*"></p>-->
                <button type="submit" name="btnContEditando" value="<?php echo $referencia ?>">Guardar Cambios</button>
                <button type="submit" name="cancelar">Cancelar</button>
            </form>
        </div>
    <?php
    } else {
    ?>
        <div>
            <h2>Agregar un nuevo libro</h2>
            <form action="index.php" method="post">
                <p>
                    <label for="referencia">Referencia</label>
                    <input type="text" name="referencia" id="referencia" value="<?php if (isset($_POST["referencia"])) echo $_POST["referencia"]; ?>">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_referencia) {
                        if ($_POST["referencia"] == "") {
                            echo "<span class='error_form'>***Campo Vacio***</span>";
                        } else if (!is_numeric($_POST["referencia"])) {
                            echo "<span class='error_form'>***la referencia tiene que ser un numero***</span>";
                        } else {
                            echo "<span class='error_form'>***Referencia repetida***</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["titulo"]) && !isset($_POST["cancelarAgregar"])) echo $_POST["titulo"]; ?>">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_titulo) {
                        if ($_POST["titulo"] == "") {
                            echo "<span class='error_form'>***Campo Vacio***</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="autor">Autor</label>
                    <input type="text" name="autor" id="autor" value="<?php if (isset($_POST["autor"])) echo $_POST["autor"]; ?>">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_autor) {
                        if ($_POST["autor"] == "") {
                            echo "<span class='error_form'>***Campo Vacio***</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="descripcion">Descripcion</label>
                    <textarea name="descripcion" id="descripcion" cols="30"><?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"]; ?></textarea>
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_descripcion) {
                        if ($_POST["descripcion"] == "") {
                            echo "<span class='error_form'>***Campo Vacio***</span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" min='0' value="<?php if (isset($_POST["precio"])) echo $_POST["precio"]; ?>">
                    <?php
                    if (isset($_POST["btnAgregar"]) && $error_precio) {
                        if ($_POST["precio"] == "") {
                            echo "<span class='error_form'>***Campo Vacio***</span>";
                        }
                    }
                    ?>
                </p>

                <p>
                    <label for="portada">Portada</label>
                    <input type="file" name="portada" id="portada" accept="image/*">
                </p>
                <button type="submit" name="btnAgregar">Agregar</button>
                <button type="submit" name="cancelar">Cancelar</button>
            </form>
        </div>
    <?php
    }
    ?>
</body>

</html>