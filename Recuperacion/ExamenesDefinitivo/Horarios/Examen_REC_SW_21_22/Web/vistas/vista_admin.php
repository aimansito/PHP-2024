<?php
$headers[] = "Authorization: Bearer " . $_SESSION["token"];
$url = DIR_SERV . "/obtenerGrupos";
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_grupos = json_decode($respuesta, true);
if (!$json_grupos) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error usando el servicio" . $url . "</p>"));
}
if (isset($json_grupos["error"])) {
    session_destroy();
    die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_grupos["error"] . "</p>"));
}

$nombre = "";
$id_grupo = "";
if ((isset($_POST["btnHorario"])) || (isset($_POST["btnEditar"]))) {

    if (isset($_POST["btnHorario"])) {
        $datos_select = explode("-", $_POST["grupos"]);
        $id_grupo = $datos_select[0];
        $nombre = $datos_select[1];
    } else {
        $id_grupo = $_POST["id_grupo"];
        $nombre = $_POST["nombre"];
    }

    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $url = DIR_SERV . "/obtenerHorario/" . $id_grupo;
    $respuesta = consumir_servicios_REST($url, "GET", $headers);
    $json_horario = json_decode($respuesta, true);
    if (!$json_horario) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>Error usando el servicio" . $url . "</p>"));
    }
    if (isset($json_horario["error"])) {
        session_destroy();
        die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>" . $json_horario["error"] . "</p>"));
    }

    $nomProfesor=[];
    if (isset($json_horario["horario_grupo"]) && is_array($json_horario["horario_grupo"])) {
        foreach ($json_horario["horario_grupo"] as $tupla) {
            $nomProfesor[$tupla["dia"]][$tupla["hora"]][] = $tupla["profe"] . " (" . $tupla["aula"] . ")";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }

        .enlinea {
            display: inline;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: #CCC;
            padding: 0.5rem;
        }

        .centrar {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Examen Final Horarios</h1>
    <div>
        Bienvenido: <strong><?php echo $datos_usu_log["usuario"]; ?></strong>- <form action="index.php" class="enlinea" method="post"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <h3>Horario de los Grupos</h3>
    <p>
        Elija el Grupo
    <form action="index.php" method="post">
        <select name="grupos">
            <?php
            foreach ($json_grupos["grupos"] as $tupla) {
                $valor = $tupla["id_grupo"] . "-" . $tupla["nombre"];
                if (isset($_POST["grupos"]) && $_POST["grupos"] == $valor) {
                    echo "<option selected value='$valor'>{$tupla["nombre"]}</option>";
                } else {
                    echo "<option value='$valor'>{$tupla["nombre"]}</option>";
                }
            }
            ?>
        </select>
        <button name="btnHorario">Ver Horario</button>
    </form>
    </p>
    <?php
    if (isset($_POST["btnHorario"]) || isset($_POST["btnEditar"])) {


        echo "<h2 class='centrar'>Horario del Grupo: " . $nombre . "</h2>";
        echo "<table>";
        echo "<tr>";
        echo "<th></th>";
        for ($i = 1; $i < count(DIAS); $i++) {
            echo "<th>" . DIAS[$i] . "</th>";
        }
        for ($hora = 1; $hora < count(HORAS); $hora++) {
            echo "<tr>";
            if ($hora == 4) {
                echo "<td>" . HORAS[$hora] . "</td><td colspan='5'>RECREO</td>";
            } else {
                echo "<td>" . HORAS[$hora] . "</td>";


                for ($dia = 1; $dia <= 5; $dia++) {
                    echo "<td>";

                    if (isset($nomProfesor[$dia][$hora])) {
                        for ($i = 0; $i < count($nomProfesor[$dia][$hora]); $i++) {
                            echo $nomProfesor[$dia][$hora][$i] . "</br>";
                        }
                    }

                    echo "</td>";
                }

                echo "</tr>";
            }
        }
        echo "</table>";
    }
    ?>
</body>

</html>