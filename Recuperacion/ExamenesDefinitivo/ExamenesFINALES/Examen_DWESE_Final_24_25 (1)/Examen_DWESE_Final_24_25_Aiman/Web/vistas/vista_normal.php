<?php
    $url=DIR_SERV.'/horarioProfesor/'.$datos_usu_log["id_usuario"];
    $respuesta = consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_profesores= json_decode($respuesta,"true");
    if(!$json_profesores){
        session_destroy();
        die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo servicios rest: ".$url."</p>"));

    }
    if(isset($json_profesores["error"])){
        session_destroy();
        die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error".$json_profesores["error"]."</p>"));
    }
    if(isset($json_profesores["no-auth"])){
        session_unset();
        $_SESSION["mensaje_seguridad"]="No tienes permiso para usar el servicio";
        header("Location:index.php");
        exit;
    }
    if(isset($json_profesores["mensaje_baneo"])){
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    $profesores = $json_profesores["profesores"];
    foreach($profesores as $tupla){
        $profesores[$tupla["dia"]][$tupla["hora"]][$tupla["grupo"]][$tupla["aula"]];
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Final PHP</title>
    <style>
        .enlinea{display:inline}
        .enlace{background:none;border:none;color:blue;text-decoration: underline;cursor: pointer;}
        table,th,td{
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Su horario</h2>
    <h3>Horario del Profesor: <?php echo $datos_usu_log["nombre"]; ?></h3>
    <?php

        $hora[1]="8:15-9:15";
        $hora[]="9:15-10:15";
        $hora[]="10:15-11:15";
        $hora[]="11:15-11:45";
        $hora[]="11:45-12:45";
        $hora[]="12:45-13:45";
        $hora[]="13:45-14:45";

        $dia[1]="Lunes";
        $dia[]="Martes";
        $dia[]="Miércoles";
        $dia[]="Jueves";
        $dia[]="Viernes";

        echo "<table>";
        for($i=1;$i<=count($hora);$i++){
            echo "<tr>".$hora[$i]."</tr>";
        }
        echo "<tr>"; 
        for($i=1;$i<=count($dia);$i++){

            echo "<th>".$dia[$i]."</th>";

        }

        
        echo "</tr>";
        echo "</table>";

        var_dump($profesores["dia"]);
        var_dump($profesores["hora"]);
        var_dump($profesores["grupo"]);
        var_dump($profesores["aula"]);
        
    ?>
</body>
</html>