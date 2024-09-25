
<?php
if(!isset($_POST["guardar"])){
    header(header:"Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida</title>
</head>
<body>
    <h1>Recogida</h1>
    <?php
            echo"<p><strong>Nombre: </strong>".$_POST["Nombre"]."</p>";
            echo"<p><strong>Apellidos: </strong>".$_POST["Apellidos"]."</p>";
            echo"<p><strong>Contraseña: </strong>".$_POST["pass"]."</p>";
            echo"<p><strong>DNI: </strong>".$_POST["dni"]."</p>";
            echo"<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
            echo"<p><strong>Nacido en: </strong>".$_POST["nacido"]."</p>";
            echo"<p><strong>Comentarios: </strong>";
            if(isset($_POST["sb"])){
                echo"Si";
            }else{
                echo"No";
            }
            echo"</p>";
    ?>
</body>
</html>