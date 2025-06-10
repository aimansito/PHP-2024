<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Libros</title>
    <style>
        ul{display: flex; justify-content: flex-start; flex-flow: row wrap; list-style-type: none;}
        li {flex-basis:33.3%; text-align: center;}
        li > img {width: 100%;}
        li>p{font-size: larger;}
        .enlinea{display:inline}
        .enlace{background:none;border:none;color:blue;text-decoration: underline;cursor: pointer;}
    </style>
</head>
<body>
    <h1>Librería</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["lector"];?></strong> - <form class="enlinea" action="index.php" method="post"><button class="enlace" type="submit" name="btnSalir">Salir</button></form>
        <h2>Listado de los libros</h2>
        <?php
        include ("vistas/vista_libros.php");
        ?>
    </div>

</body>
</html>