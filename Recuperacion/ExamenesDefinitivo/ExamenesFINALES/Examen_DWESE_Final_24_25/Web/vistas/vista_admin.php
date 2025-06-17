<?php
$dias[1] = "Lunes";
$dias[] = "Martes";
$dias[] = "Miércoles";
$dias[] = "Jueves";
$dias[] = "Viernes";

$horas[1] = "8:15 - 9:15";
$horas[] = "9:15 - 10:15";
$horas[] = "10:15 - 11:15";
$horas[] = "11:15 - 11:45";
$horas[] = "11:45 - 12:45";
$horas[] = "12:45 - 13:45";
$horas[] = "13:45 - 14:15";

$url = DIR_SERV . "/grupos";
$headers[] = "Authorization: Bearer " . $_SESSION["token"];
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_grupos = json_decode($respuesta, true);

if (!$json_grupos) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_grupos["error"])) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_grupos["error"] . "</p>"));
}

if (isset($json_grupos["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}

if (isset($json_grupos["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}
if (isset($_SESSION["dia"])) {
    $_POST["dia"] = $_SESSION["dia"];
    unset($_SESSION["dia"]);
    $_POST["hora"] = $_SESSION["hora"];
    unset($_SESSION["hora"]);
    $_POST["id_grupo"] = $_SESSION["id_grupo"];
    unset($_SESSION["id_grupo"]);
}

if (isset($_POST["id_grupo"]) || isset($_POST["dia"])) {
    $url = DIR_SERV . "/horarioGrupo/" . $_POST["id_grupo"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_horarioGrupo = json_decode($respuesta, true);

    if (!$json_horarioGrupo) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_horarioGrupo["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_horarioGrupo["error"] . "</p>"));
    }

    if (isset($json_horarioGrupo["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_horarioGrupo["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    foreach ($json_horarioGrupo["horario"] as $tupla) {
        $profeAula[$tupla["dia"]][$tupla["hora"]][] = $tupla["profe"] . "(" . $tupla["aula"] . ")";
    }
}

if (isset($_POST["dia"])) {
    $url = DIR_SERV . "/profesores/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["id_grupo"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesores = json_decode($respuesta, true);

    if (!$json_profesores) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesores["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_horarioGrupo["error"] . "</p>"));
    }

    if (isset($json_profesores["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesores["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $url = DIR_SERV . "/profesoresLibres/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["id_grupo"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_profesoresLibres = json_decode($respuesta, true);

    if (!$json_profesoresLibres) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_profesoresLibres["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_profesoresLibres["error"] . "</p>"));
    }

    if (isset($json_profesoresLibres["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_profesoresLibres["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $url = DIR_SERV . "/aulas";
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
    $json_aulas = json_decode($respuesta, true);

    if (!$json_aulas) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_aulas["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_aulas["error"] . "</p>"));
    }

    if (isset($json_aulas["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_aulas["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }
}

if (isset($_POST["btnQuitar"])) {
    $url = DIR_SERV . "/borrarProfesores/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["id_grupo"] . "/" . $_POST["id_usuario"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "DELETE", $headers);
    $json_borrarProfesores = json_decode($respuesta, true);

    if (!$json_borrarProfesores) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_borrarProfesores["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_borrarProfesores["error"] . "</p>"));
    }

    if (isset($json_borrarProfesores["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_borrarProfesores["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];
    $_SESSION["id_grupo"] = $_POST["id_grupo"];
    $_SESSION["mensaje_accion"] = $json_borrarProfesores["mensaje"];
    header("Location:index.php");
    exit;
}

if (isset($_POST["btnAniadir"])) {
    $url = DIR_SERV . "/insertarProfesores/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["id_grupo"] . "/" . $_POST["id_usuario"] . "/" . $_POST["id_aula"];
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $respuesta = consumir_servicios_JWT_REST($url, "POST", $headers);
    $json_insertarProfesores = json_decode($respuesta, true);

    if (!$json_insertarProfesores) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
    }

    if (isset($json_insertarProfesores["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_insertarProfesores["error"] . "</p>"));
    }

    if (isset($json_insertarProfesores["no_auth"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    if (isset($json_insertarProfesores["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];
    $_SESSION["id_grupo"] = $_POST["id_grupo"];
    $_SESSION["mensaje_accion"] = $json_insertarProfesores["mensaje"];
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
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

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        table {
            margin: auto;
            width: 60%;
        }

        th {
            background-color: lightgrey;
        }

        .titulo {
            text-align: center;
        }

        .slc {
            text-align: center;
            margin-top: 2rem;
        }

        .mensaje{
            color: blue;
            font-size: 1.24rem;
        }
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido (admin)<strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <?php
    echo "<h2>Horarios de los Grupos</h2>";
    echo "<form action='index.php' method='post'>";
    echo "<label>Elija el grupo: </label>";
    echo "<select name='id_grupo'>";
    foreach ($json_grupos["grupos"] as $tupla) {
        $seleccionado = (isset($_POST["id_grupo"]) && $_POST["id_grupo"] == $tupla["id_grupo"]) ? "selected" : "";
        echo "<option value='" . $tupla["id_grupo"] . "' " . $seleccionado . ">" . $tupla["nombre"] . "</option>";
    }
    echo "</select>";
    echo "<button type='submit' name='btnHorario'>Ver Horario</button>";
    echo "</form>";

    if (isset($_POST["id_grupo"]) || isset($_POST["dia"])) {
        foreach ($json_grupos["grupos"] as $tupla) {
            if (isset($_POST["id_grupo"]) && $_POST["id_grupo"] == $tupla["id_grupo"]) {
                $nombre = $tupla["nombre"];
            }
        }
        echo "<h3 class='titulo'>Horario del Grupo: " . $nombre . "</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th></th>";
        for ($i = 1; $i <= count($dias); $i++) {
            echo "<th>" . $dias[$i] . "</th>";
        }
        echo "</tr>";
        for ($hora = 1; $hora <= count($horas); $hora++) {
            echo "<tr>";
            echo "<td>" . $horas[$hora] . "</td>";
            if ($hora == 4) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia = 1; $dia <= count($dias); $dia++) {
                    echo "<td>";
                    if (isset($profeAula[$dia][$hora])) {
                        for ($i = 0; $i < count($profeAula[$dia][$hora]); $i++) {
                            echo $profeAula[$dia][$hora][$i] . "<br/>";
                        }
                    }
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='" . $dia . "'>";
                    echo "<input type='hidden' name='hora' value='" . $hora . "'>";
                    echo "<input type='hidden' name='id_grupo' value='" . $_POST["id_grupo"] . "'>";
                    echo "<button type='submit' name='btnEditar' class='enlace'>Editar</button>";
                    echo "</form>";
                    echo "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        if (isset($_POST["dia"])) {
            echo "<h3>Editando la " . $_POST["hora"] . "º Hora (" . $horas[$_POST["hora"]] . ") del " . $dias[$_POST["dia"]] . "</h3>";

            if (isset($_SESSION["mensaje_accion"])) {
                echo "<p class='mensaje'>" . $_SESSION["mensaje_accion"] . "</p>";
                unset($_SESSION["mensaje_accion"]);
            }

            echo "<table>";
            echo "<tr>";
            echo "<th>Profesor(Aula)</th>";
            echo "<th>Acción</th>";
            echo "</tr>";
            foreach ($json_profesores["profesores"] as $tupla) {
                echo "<tr>";
                echo "<td>" . $tupla["profe"] . "(" . $tupla["aula"] . ")</td>";
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'>";
                echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'>";
                echo "<input type='hidden' name='id_grupo' value='" . $_POST["id_grupo"] . "'>";
                echo "<input type='hidden' name='id_usuario' value='" . $tupla["id_usuario"] . "'>";
                echo "<button type='submit' name='btnQuitar' class='enlace'>Quitar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

            echo "<div class='slc'>";
            echo "<form action='index.php' method='post'>";
            echo "<label>Elija Profesor: </label>";
            echo "<select name='id_usuario'>";
            foreach ($json_profesoresLibres["profesores_libres"] as $tupla) {
                echo "<option value='" . $tupla["id_usuario"] . "' " . $seleccionado . ">" . $tupla["nombre"] . "</option>";
            }
            echo "</select>";
            echo "<label>Elija aula: </label>";
            echo "<select name='id_aula'>";
            foreach ($json_aulas["aulas"] as $tupla) {
                echo "<option value='" . $tupla["id_aula"] . "' " . $seleccionado . ">" . $tupla["nombre"] . "</option>";
            }
            echo "</select>";
            echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'>";
            echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'>";
            echo "<input type='hidden' name='id_grupo' value='" . $_POST["id_grupo"] . "'>";
            echo "<button type='submit' name='btnAniadir'>Añadir</button>";
            echo "</form>";
            echo "</div>";
        }
    }
    ?>
</body>

</html>