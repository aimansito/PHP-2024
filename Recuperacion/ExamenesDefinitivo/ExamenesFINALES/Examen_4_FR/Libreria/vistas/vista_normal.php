<?php
$url=DIR_SERV."/obtenerLibros";
$respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
$json_lista_libros=json_decode($respuesta,true);
if(!$json_lista_libros)
{
     session_destroy();
     die(error_page("Gestión Libros","<h1>Librería</h1><p>Error consumiendo el servicio Rest: <strong>".$url."</strong></p>"));
}
if(isset($json_lista_libros["error"]))
{
     session_destroy();
     die(error_page("Gestión Libros","<h1>Librería</h1><p>".$json_lista_libros["error"]."</p>"));
}

if(isset($json_lista_libros["no_auth"]))
{
    session_unset();
    $_SESSION["mensaje_seguridad"]="El tiempo de sesión de la API ha expirado";
    header("Location:index.php");
    exit;
}
if(isset($json_lista_libros["mensaje_baneo"]))
{
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
    <title>Gestión Libros</title>
    <style>
        .enlinea{display:inline}
        .enlace{background:none;border:none;color:blue;text-decoration: underline;cursor: pointer;}
        #box{
            display: flex;
            flex-direction: row;
            border: solid red 1px;
            flex-wrap: wrap;
        }

        .librosIndividuales{
            margin: 1rem;
            border: solid blue 1px;
            padding: 1rem;
            flex: 0 25%;
            text-align: center;
            box-sizing: border-box;
        }
        img{
            width: 70%;
            height: auto;
            border: solid black 1px;
        }
    </style>
</head>
<body>
    <h1>Librería</h1>
    <div>
        Bienvenido Normal <strong><?php echo $datos_usu_log["lector"];?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
    </div>
    <div id="box">
        
        <?php
        foreach($json_lista_libros["libros"] as $tupla){
            echo "<div class='librosIndividuales'>";
            echo "<img src='images/no_imagen.jpg' alt='portada' />";
            echo "<p>".$tupla["titulo"]." - ".$tupla["precio"]."</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>