<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6 - Rec</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration: underline;color:blue;cursor: pointer;}
        .mensaje{color:blue;font-size:1.25em}
    </style>
</head>
<body>
    <h1>Práctica 6 - Rec</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"];?></strong> - 
        <form class="enlinea" method="post" action="index.php">
            <button class="enlace" type="submit" name="btnCerrarSesion">Salir</button>
        </form>
    </div>
    <?php
    if(isset($_SESSION["mensaje_registro"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje_registro"]."</p>";
        unset($_SESSION["mensaje_registro"]);
    }
    ?>
</body>
</html>