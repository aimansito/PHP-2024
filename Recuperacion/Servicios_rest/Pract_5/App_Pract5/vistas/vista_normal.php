<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 5 - Rec</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration: underline;color:blue;cursor: pointer;}
        .mensaje{color:blue;font-size:1.25em}
    </style>
</head>
<body>
    <h1>Práctica 5 - Rec</h1>
    <div>
        Bienvenido (Normal) <strong><?php echo $datos_usu_log["usuario"];?></strong> - 
        <form class="enlinea" method="post" action="index.php">
            <button class="enlace" type="submit" name="btnCerrarSesion">Salir</button>
        </form>
    </div>
    
</body>
</html>