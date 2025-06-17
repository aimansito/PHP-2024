<?php
     $url=DIR_SERV.'/obtenerGrupos/';
     $respuesta = consumir_servicios_JWT_REST($url,"GET",$headers);
     $json_grupos= json_decode($respuesta,"true");
     if(!$json_grupos){
         session_destroy();
         die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error consumiendo servicios rest: ".$url."</p>"));
 
     }
     if(isset($json_grupos["error"])){
         session_destroy();
         die(error_page("Examen Final PHP","<h1>Examen Final PHP</h1><p>Error".$json_grupos["error"]."</p>"));
     }
     if(isset($json_grupos["no-auth"])){
         session_unset();
         $_SESSION["mensaje_seguridad"]="No tienes permiso para usar el servicio";
         header("Location:index.php");
         exit;
     }
     if(isset($json_grupos["mensaje_baneo"])){
         session_unset();
         $_SESSION["mensaje_seguridad"]="Usted ya no se encuentra registrado en la BD";
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
        .enlinea{display:inline}
        .enlace{background:none;border:none;color:blue;text-decoration: underline;cursor: pointer;}
    </style>
</head>

<body>
    <h1>Examen Final PHP</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"]; ?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <h2>Horario de los Grupos</h2>
    <h3>Elija los horarios</h3>
    <?php
        echo "<form method='index.php' action='index.php'>";  
        echo "<select name='grupos'>";
        for($i=1;$i<=count($json_grupos);$i++){
            echo "<option>".$json_grupos["grupos"]["nombre"]."</option>";
        }
        echo "</select>";
        echo "</form>";
    ?>
</body>
</html>