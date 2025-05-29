<?php
$headers[] = "Authorization: Bearer " . $_SESSION["token"];
$url = DIR_SERV."/notasAlumno/".$datos_usu_log["cod_usu"];
$respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);
$json_notas = json_decode($respuesta, true);
if(!$json_notas){
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
}
if(isset($json_notas["error"])){
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$json_notas["error"]."</p>"));
}

if(isset($json_notas["no_auth"])){
    session_unset();
    $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

if(isset($json_notas["mensaje"])){
    session_unset();
    $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}

//var_dump($respuesta);

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Practica Examen 1</title>
    <style>
        .enlace{
            border: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer;
            background:none;
        }
        table{
            border-collapse: collapse;
        }
        tr,td,th{
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <div>Bienvenido <strong> <?php echo $datos_usu_log["nombre"]; ?> <form style="display: inline;" action="index.php" method="post"> <button   class="enlace" type="submit" name="btnSalir">Salir</button></form></div>
    <h2>Notas del alumno <?php echo $datos_usu_log["nombre"];?></h2>

    <?php
    echo "<table border='1'>";
    echo "<tr><th>Asignaturas</th><th>Notas</th></tr>";
        foreach ($json_notas["notas"] as $nota) {
            echo "<tr>";
            echo "<td>" . $nota["denominacion"] . "</td>";
            echo "<td>" . $nota["nota"] . "</td>";
            echo "</tr>";
        }

        
    echo "</table>"
    ?>
</body>
</html>