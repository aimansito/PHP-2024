<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 2 - Rec</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration: underline;color:blue;cursor: pointer;}
    </style>
</head>
<body>
    <h1>Práctica 2 - Rec</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"];?></strong> - 
        <form class="enlinea" method="post" action="index.php">
            <button class="enlace" type="submit" name="btnCerrarSesion">Salir</button>
        </form>
    </div>
</body>
</html>