<?php
    $url=DIR_SERV.'/obtenerLibros';
    $respuesta = json_decode(consumir_servicios_REST($url,'GET'),true);

    if(!$respuesta){
        session_destroy();
        die(error_page("Examen Librería SW 24-25","Error. no se ha podido realizar el servicio rest"));
    }

    if(isset($respuesta["error"])){
        session_destroy();
        die("Error realizando el servicio ".$respuesta["error"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .tamañoImg{
            width: 6rem;
            height: 6rem;
        }
    </style>
</head>
<body>
    <ul>
    <?php
        foreach($respuesta['libros'] as $tupla){
            echo "<li>"; 
            echo "<img class='tamañoImg' src='images/".$tupla['portada']."' alt=''>";
            echo "<p>".$tupla['titulo']."</p>";
            echo "</li>";
        }
    ?>
</ul>
</body>
</html>