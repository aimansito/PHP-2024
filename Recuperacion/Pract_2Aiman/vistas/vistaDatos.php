<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos enviados</title>
</head>
<body>
    <h2>Datos enviados</h2>

    <p>
        <strong>Nombre: </strong><?php  echo $_POST["nombre"];?></br>
        <strong>Comentarios: </strong><?php  echo $_POST["comentarios"];?></br>
        <strong>DNI: </strong><?php echo $_POST["nacido"]?></br>
        <strong>Sexo: </strong><?php echo $_POST["sexo"] ?></br>
        <?php
            if(isset($_POST["aficiones"])){
                echo "<ol>";
                    for($i=0;$i<count($_POST["aficiones"]);$i++){
                        echo "<li>".$_POST["aficiones"][$i]."</li>";
                    }
                echo "</ol>";
            }else{
                echo "<strong class=>Aficiones: </strong>Ninguna</br>";
            }
        ?>

    </p>

    <?php
        if(isset($_FILES["foto"]["name"])!=""){
            echo "<h3>Foto</h3>";
            $nombreFoto =  md5(uniqid(uniqid(),true));
            $ext=tiene_extension($_FILES["foto"]["name"]);
            $nombre_unico = $nombreFoto.".".$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_unico);
            if($var){
                echo "<p>";
                echo "<strong>Nombre en el cliente</strong>".$_FILES["foto"]["name"]."</br>";
                echo "<strong>Error subiendo imagen:</strong>".$_FILES["foto"]["error"]."</br>";
                echo "<strong>Error tamaño</strong>".$_FILES["foto"]["size"]."</br>";
                echo "<strong>Error tipo</strong>".$_FILES["foto"]["type"]."</br>";
                echo "</p>";
                echo "<p>";
                echo "<img src='images/".$nombre_unico."' alt='Error imagen' title='Subida imagen'>";
                echo "</p>";
            }else{
                echo "<p>No se ha podido subir la imagen</p>";
            }
        }
    ?>
</body>
</html>