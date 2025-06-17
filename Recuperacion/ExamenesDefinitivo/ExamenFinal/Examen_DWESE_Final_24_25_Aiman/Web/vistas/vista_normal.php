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

    foreach($json_profesores["profesores"] as $tupla){
        $grupo[$tupla["dia"]][$tupla["hora"]][]=$tupla["grupo"];
        $aula[$tupla["dia"]][$tupla["hora"]][$tupla["grupo"]][]=$tupla["aula"];
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
        .enlace{background:none;border:n one;color:blue;text-decoration: underline;cursor: pointer;}
        table,th,td{
            border: 1px solid black;
        }
        .text_centrado{
            text-align: center;
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

        $horas[1]="8:15-9:15";
        $horas[]="9:15-10:15";
        $horas[]="10:15-11:15";
        $horas[]="11:15-11:45";
        $horas[]="11:45-12:45";
        $horas[]="12:45-13:45";
        $horas[]="13:45-14:45";

        $dias[1]="Lunes";
        $dias[]="Martes";
        $dias[]="Miércoles";
        $dias[]="Jueves";
        $dias[]="Viernes";

        echo "<table class='text_centrado'>"; 
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
                echo "<td colspan=5>RECREO</td>";
            }else{
                for($dia=1;$dia<=count($dias);$dia++){
                    echo "<td>";
                    if(isset($grupo[$dia][$hora])){
                        for ($i=0; $i < count($grupo[$dia][$hora]); $i++) { 
                            echo $grupo[$dia][$hora][$i];
                            echo "</br>";

                            for ($j=0; $j < count($aula[$dia][$hora][$grupo[$dia][$hora][$i]]) ; $j++) { 
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