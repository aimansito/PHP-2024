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

$url = DIR_SERV . "/horarioProfesor/" . $datos_usu_log["id_usuario"];
$headers[] = "Authorization: Bearer " . $_SESSION["token"];
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_horarioProfesor = json_decode($respuesta, true);

if (!$json_horarioProfesor) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"));
}

if (isset($json_horarioProfesor["error"])) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_horarioProfesor["error"] . "</p>"));
}

if (isset($json_horarioProfesor["no_auth"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}

if (isset($json_horarioProfesor["mensaje_baneo"])) {
    session_unset();
    $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

foreach ($json_horarioProfesor["horario"] as $tupla) {
    $grupo[$tupla["dia"]][$tupla["hora"]][] = $tupla["grupo"];
    $aula[$tupla["dia"]][$tupla["hora"]][] = $tupla["aula"];
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
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <?php
    echo "<h3>Horario del Profesor: " . $datos_usu_log["nombre"] . "</h3>";

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
                if (isset($grupo[$dia][$hora])) {
                    for ($i=0; $i < count($grupo[$dia][$hora]); $i++) { 
                        echo $grupo[$dia][$hora][$i] . "/";
                        echo "<br/>" . $aula[$dia][$hora][$i];
                    }
                }
                echo "</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>