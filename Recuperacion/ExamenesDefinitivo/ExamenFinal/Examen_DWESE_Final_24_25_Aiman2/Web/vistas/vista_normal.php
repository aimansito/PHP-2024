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

    $url = DIR_SERV . "/horarioProfesor/". $datos_usu_log["id_usuario"];
    $respuesta = consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_horario_profesor = json_decode($respuesta,true);
    if(!$json_horario_profesor){
        session_destroy();
        die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo servicios rest: ".$url."</p>"));
    }

    if(isset($json_horario_profesor["error"])){
        session_destroy();
        die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>".$json_horario_profesor["error"]."</p>"));
    }
    if(isset($json_horario_profesor["no-auth"])){
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if(isset($json_horario_profesor["mensaje_baneo"])){
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra en la BD";
        header("Location:index.php");
        exit;
    }

    $profesores = $json_horario_profesor["profesores"];
    foreach($profesores as $tupla){
        $grupo[$tupla["dia"]][$tupla["hora"]][]=$tupla["grupo"];
        $aula[$tupla["dia"]][$tupla["hora"]][$tupla["grupo"]][]=$tupla["aula"];
    }
?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .enlinea{
            display: inline;
        }
        table{
            margin: 0 auto;
        }
        td,th, table{
            border: 1px solid black;
            text-align: center;
            padding: 0.5rem;
        }
    </style>
</head>
<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class='enlinea' action='index.php' method='post'><button type='submit' name='btnSalir'>Salir</button></form>
    </div>
    <h2>Su horario</h2>
    <?php
        echo "<h3 class='text_centrado'>Horario del profesor: ".$datos_usu_log["nombre"]."</h3>";

        echo "<table>";
        echo "<tr>";
        echo "<th></th>";
        for($i=1;$i<=count($dias);$i++){
            echo "<th>".$dias[$i]."</th>";
        }
        echo "</tr>";
        for($hora=1;$hora<=count($horas);$hora++){
            echo "<tr>";
            echo "<td>".$horas[$hora]."</td>";
            if($hora==4){
                echo "<td colspan='5'>RECREO</td>";
            }else{
                for($dia=1;$dia<=count($dias);$dia++){
                    echo "<td>";
                    if(isset($grupo[$dia][$hora])){
                        for($i=0;$i < count($grupo[$dia][$hora]);$i++){
                            echo $grupo[$dia][$hora][$i] . " / ";
                            echo "</br>";

                            for($j=0;$j < count($aula[$dia][$hora][$grupo[$dia][$hora][$i]]);$j++){
                                echo $aula[$dia][$hora][$grupo[$dia][$hora][$i]][$j];
                                echo "</br>";
                            }
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