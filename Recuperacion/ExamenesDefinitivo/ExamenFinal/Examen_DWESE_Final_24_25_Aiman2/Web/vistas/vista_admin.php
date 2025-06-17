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

    $url = DIR_SERV . "/obtenerGrupos/" ;
    $respuesta = consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_grupos = json_decode($respuesta,true);
    if(!$json_grupos){
        session_destroy();
        die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo servicios rest: ".$url."</p>"));
    }
    if(isset($json_grupos["error"])){
        session_destroy();
        die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>".$json_grupos["error"]."</p>"));
    }
    if(isset($json_grupos["no-auth"])){
        session_unset();
        $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }
    if(isset($json_grupos["mensaje_baneo"])){
        session_unset();
        $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra en la BD";
        header("Location:index.php");
        exit;
    }

    $grupos = $json_grupos["grupos"];


    if(isset($_POST["id_grupo"])|| isset($_POST["dia"])){
        $url = DIR_SERV . "/horarioGrupo/" . $_POST["id_grupo"];
        $respuesta = consumir_servicios_JWT_REST($url,"GET",$headers);
        $json_horario_grupo = json_decode($respuesta,true);
        if(!$json_horario_grupo){
            session_destroy();
            die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo servicios rest: ".$url."</p>"));
        }
        if(isset($json_horario_grupo["error"])){
            session_destroy();
            die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>".$json_horario_grupo["error"]."</p>"));
        }
        if(isset($json_horario_grupo["no-auth"])){
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
            header("Location:index.php");
            exit;
        }
        if(isset($json_horario_grupo["mensaje_baneo"])){
            session_unset();
            $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra en la BD";
            header("Location:index.php");
            exit;
        }

        $horarioGrupos = $json_horario_grupo["horario"];
        foreach($horarioGrupos as $tupla){
            $profeAula[$tupla["dia"]][$tupla["hora"]][]=$tupla["profe"] . "(" . $tupla["aula"] . ")";
        }
    }

    if(isset($_POST["dia"])){
        $url = DIR_SERV . "/profesores/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_POST["id_grupo"];
        $respuesta = consumir_servicios_JWT_REST($url,"GET",$headers);
        $json_profesores = json_decode($respuesta,true);
        if(!$json_profesores){
            session_destroy();
            die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo servicios rest: ".$url."</p>"));
        }
        if(isset($json_profesores["error"])){
            session_destroy();
            die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p> ".$json_profesores["error"]."</p>"));
        }
        if(isset($json_profesores["no-auth"])){
            session_unset();
            $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit; 
        }
        if(isset($json_profesores["mensaje_baneo"])){
            session_unset();
            $_SESSION["mensaje_seguridad"]="Usted no se encuentra en la BD";
            header("Location:index.php");
            exit;
        }

        $profesores = $json_profesores["profesores"];
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
        table,td,th{
            border: 1px solid black;
            text-align: center;
            padding: 0.5rem;
        }   
    </style>
</head>
<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"] ;?></strong>-<form method="post" action="index.php" class="enlinea"><button type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Horario de los grupos</h2>
    <?php
        echo "<form method='post' action='index.php'>"; 
        echo "<label>Elija su grupo: </label>";
        echo "<select name='id_grupo'>";
        foreach($grupos as $tupla){
            $seleccionado = (isset($_POST["id_grupo"]) && $_POST["id_grupo"]==$tupla["id_grupo"]) ? "selected" : "";
            echo "<option value='".$tupla["id_grupo"]."' ". $seleccionado.">".$tupla["nombre"]."</option>";
        }
        echo "</select>";
        echo "<button type='submit' name='btnHorario'>Ver Horario</button>";
        echo "</form>";

        if(isset($_POST["id_grupo"]) || isset($_POST["dia"])){
            foreach($grupos as $tupla){
                if(isset($_POST["id_grupo"]) && $_POST["id_grupo"]==$tupla["id_grupo"]){
                    $nombre = $tupla["nombre"];
                }
            }
            echo "<h3>Horario del Grupo: ".$nombre."</h3>";
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
                        if(isset($profeAula[$dia][$hora])){
                            for($i=0 ; $i < count($profeAula[$dia][$hora]);$i++){
                                echo $profeAula[$dia][$hora][$i];
                                echo "</br>";
                            }

                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='dia' value='".$dia."'>";
                            echo "<input type='hidden' name='hora' value='".$hora."'>";
                            echo "<input type='hidden' name='id_grupo' value='".$_POST["id_grupo"]."'>";
                            echo "<button type='submit' name='btnEditar'>Editar</button>";
                            echo "</form>";
                        }

                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
            if(isset($_POST["dia"])){
                echo "<h3 class='text_centrado'>Editando la ".$_POST["hora"]. "ºHora (".$horas[$_POST["hora"]].") del dia ".$dias[$_POST["dia"]]."</h3>";
                echo "<table>";
                echo "<tr>"; 
                echo "<th>Profesor</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                foreach($profesores as $tupla){
                    echo "<tr>"; 
                    echo "<td>".$tupla["profe"]."(".$tupla["aula"]."</td>";
                    echo "<td>"; 
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'>";
                    echo "<input type='hidden' name='hora' value='".$_POST["hora"]."'>";
                    echo "<input type='hidden' name='id_grupo' value='".$_POST["id_grupo"]."'>";
                    echo "<input type='hidden' name='id_usuario' value='".$tupla["id_usuario"]."'>";
                    echo "<button type='submit' name='btnQuitar'>Quitar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
    ?>
</body>
</html>
