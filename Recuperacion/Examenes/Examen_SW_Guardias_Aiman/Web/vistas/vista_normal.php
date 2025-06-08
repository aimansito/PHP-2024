<?php
require_once "src/funciones_ctes.php";
require_once "src/seguridad.php";

$mensaje = "";
$guardia = false;
$profesores_guardia = [];

if (isset($_POST["btnCerrarSesion"])) {
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", [], $headers);
    session_destroy();
    header("Location: index.php");
    exit;
}

if (isset($_POST["btnEquipo"]) || isset($_POST["btnProfesor"])) {
    $dia = $_POST["dia"];
    $hora_real = $_POST["hora"];
    $hora_api = ($hora_real > 3) ? $hora_real - 1 : $hora_real;
    $numero = $_POST["numero"];

    $headers[] = "Authorization: Bearer " . $_SESSION["token"];

    // 1. Comprobar si está de guardia
    $respuesta = consumir_servicios_REST(DIR_SERV . "/deGuardia/" . $datos_usu_log["id_usuario"] . "/$dia/$hora_api", "GET", [], $headers);
    echo "<h3>RESPUESTA DEL SERVICIO:</h3><pre>$respuesta</pre>";
    exit;

    $json = json_decode($respuesta, true);

    if (!$json || isset($json["error"]) || !isset($json["de_guardia"])) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", [], $headers);
        session_destroy();
        die(error_page("Guardias", "<h1>Error</h1><p>" . ($json["error"] ?? "Error al conectar con el servicio") . "</p>"));
    }

    $guardia = $json["de_guardia"];

    // 2. Obtener profesores de guardia
    $respuesta2 = consumir_servicios_REST(DIR_SERV . "/usuariosGuardia/$dia/$hora_real", "GET", [], $headers);
    $json2 = json_decode($respuesta2, true);

    if (!$json2 || isset($json2["error"])) {
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", [], $headers);
        session_destroy();
        die(error_page("Guardias", "<h1>Error</h1><p>" . ($json2["error"] ?? "Error al conectar con el servicio") . "</p>"));
    }

    $profesores_guardia = $json2["profesores"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardias</title>
    <style>
        .enlinea { display: inline; }
        .enlace { background: none; border: none; color: blue; text-decoration: underline; cursor: pointer; }
        .mensaje { color: blue; font-size: 1.2rem; }
        table, td, th { border: 1px solid black; border-collapse: collapse; padding: 0.5rem; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Guardias</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - 
        <form class="enlinea" action="index.php" method="post">
            <button class="enlace" type="submit" name="btnCerrarSesion">Salir</button>
        </form>
    </div>

    <?php
    $dias = [1 => "Lunes", 2 => "Martes", 3 => "Miércoles", 4 => "Jueves", 5 => "Viernes"];
    $horas = [1 => "1ª Hora", 2 => "2ª Hora", 3 => "3ª Hora", 4 => "", 5 => "4ª Hora", 6 => "5ª Hora", 7 => "6ª Hora"];
    $numero = 1;

    echo "<table><tr><th></th>";
    foreach ($dias as $d) echo "<th>$d</th>";
    echo "</tr>";

    for ($h = 1; $h <= 7; $h++) {
        echo "<tr>";
        echo "<td>{$horas[$h]}</td>";
        if ($h == 4) {
            echo "<td colspan='5'>RECREO</td>";
        } else {
            for ($d = 1; $d <= 5; $d++) {
                echo "<td>
                    <form method='post' class='enlinea'>
                        <input type='hidden' name='hora' value='$h'>
                        <input type='hidden' name='dia' value='$d'>
                        <input type='hidden' name='numero' value='$numero'>
                        <button class='enlace' type='submit' name='btnEquipo'>Equipo $numero</button>
                    </form>
                </td>";
                $numero++;
            }
        }
        echo "</tr>";
    }
    echo "</table>";

    if (isset($_POST["btnEquipo"]) || isset($_POST["btnProfesor"])) {
        echo "<h2>Equipo de Guardia {$_POST['numero']}</h2>";
        echo "<h3>{$dias[$_POST['dia']]} - {$horas[$_POST['hora']]}</h3>";

        if (!$guardia) {
            echo "<p class='mensaje'>¡Atención! Usted no tiene guardia en este turno.</p>";
        } else {
            echo "<table><tr><th>Profesores de Guardia</th><th>Detalles</th></tr>";
            foreach ($profesores_guardia as $prof) {
                echo "<tr><td>
                    <form method='post' class='enlinea'>
                        <input type='hidden' name='hora' value='{$_POST['hora']}'>
                        <input type='hidden' name='dia' value='{$_POST['dia']}'>
                        <input type='hidden' name='numero' value='{$_POST['numero']}'>
                        <input type='hidden' name='id_usuario' value='{$prof['id_usuario']}'>
                        <button class='enlace' name='btnProfesor'>{$prof['nombre']}</button>
                    </form>
                </td>";

                if (isset($_POST["btnProfesor"]) && $_POST["id_usuario"] == $prof['id_usuario']) {
                    echo "<td rowspan='" . count($profesores_guardia) . "'>
                        <p><strong>Nombre:</strong> {$prof['nombre']}</p>
                        <p><strong>Usuario:</strong> {$prof['usuario']}</p>
                        <p><strong>Contraseña:</strong> {$prof['clave']}</p>
                        <p><strong>Email:</strong> {$prof['email']}</p>
                    </td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>
</html>
