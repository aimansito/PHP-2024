<?php
$id_usuario = $datos_usu_log["id_usuario"];
$url = DIR_SERV . "/usuario/" . $id_usuario;
$headers[] = "Authorization: Bearer " . $_SESSION["token"];
$respuesta = consumir_servicios_REST($url, "GET", [], $headers);
$obj = json_decode($respuesta, true);

if (!$obj) {
    session_destroy();
    die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>Error consumiendo servicio: " . $url . " </p>"));
}
if (isset($obj["error"])) {
    session_destroy();
    die(error_page("Gestión de guardias", "<h1>Gestión de guardias</h1><p>" . $obj["error"] . "</p>"));
}

foreach ($obj["usuario"] as $tupla) {
    $horario[$tupla["dia"]][$tupla["hora"]] = true;
}

$profesores_guardia = [];

if (isset($_POST["btnEquipo"])) {
    $dia = $_POST["dia"];
    $hora = $_POST["hora"];

    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    $url = DIR_SERV . "/usuariosGuardia/$dia/$hora";
    $respuesta = consumir_servicios_REST($url, "GET", [], $headers);
    $obj = json_decode($respuesta, true);

    if (!$obj) {
        session_destroy();
        die(error_page("Gestión de Guardias", "<h1>Gestión de Guardias</h1><p>Error consumiendo servicio: " . $url . " </p>"));
    }
    if (isset($obj["error"])) {
        session_destroy();
        die(error_page("Gestión de guardias", "<h1>Gestión de guardias</h1><p>" . $obj["error"] . "</p>"));
    }

    $profesores_guardia = $obj["profesores"];
}

if (isset($_POST["btnCerrarSesion"])) {
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", [], $headers);
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardias</title>
    <style>
        .en_linea {
            display: inline;
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        .mensaje {
            font-size: 1.25em;
            color: blue;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #CCC;
            padding: 0.4rem;
        }
    </style>
</head>

<body>
    <h1>Guardias</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> -
        <form class="en_linea" action="index.php" method="post">
            <button class="enlace" type="submit" name="btnCerrarSesion">Salir</button>
        </form>
    </div>

    <?php
    $dias = [1 => "Lunes", 2 => "Martes", 3 => "Miércoles", 4 => "Jueves", 5 => "Viernes"];
    $horas = [1 => "1ºHora", 2 => "2ºHora", 3 => "3ºHora", 4 => "4ºHora", 5 => "5ºHora", 6 => "6ºHora"];

    echo "<h2>Equipos de Guardia del IES Mar de Alborán</h2>";
    echo "<table>";
    echo "<tr><th></th>";
    for ($i = 1; $i <= 5; $i++) echo "<th>{$dias[$i]}</th>";
    echo "</tr>";

    $numero = 1;
    for ($hora = 1; $hora <= 6; $hora++) {
        echo "<tr><td>{$horas[$hora]}</td>";
        for ($dia = 1; $dia <= 5; $dia++) {
            echo "<td>";
            if (isset($horario[$dia][$hora])) {
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='dia' value='$dia'/>";
                echo "<input type='hidden' name='hora' value='$hora'/>";
                echo "<input type='hidden' name='equipo' value='$numero'/>";
                echo "<button type='submit' class='enlace' name='btnEquipo'>Equipo $numero</button>";
                echo "</form>";
            }
            echo "</td>";
            $numero++;
        }
        echo "</tr>";
    }
    echo "</table>";

    if (isset($_POST["btnEquipo"])) {
        echo "<h2>Equipo de guardia " . $_POST["equipo"] . "</h2>";
        echo "<table>";
        echo "<tr><th>Profesores de Guardia</th><th>Información del profesor</th></tr>";

        foreach ($profesores_guardia as $profesor) {
            echo "<tr>";
            echo "<td>";
            echo "<form action='index.php' method='post'>";
            echo "<input type='hidden' name='dia' value='" . $_POST["dia"] . "'>";
            echo "<input type='hidden' name='hora' value='" . $_POST["hora"] . "'>";
            echo "<button class='enlace' type='submit' name='btnnombre' value='" . $profesor["id_usuario"] . "'>" . $profesor["nombre"] . "</button>";
            echo "</form>";
            echo "</td>";
            echo "<td></td>"; // Aquí puedes mostrar más información si implementas el botón btnnombre
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>
</body>

</html>
