<?php
if(isset($_POST['contar'])){
    $error_form = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" || $_FILES["fichero"]["size"] > 2500*1024;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
    <style>
        .error{
            color: red;

        }
    </style>
</head>
<body>
    <h1>Ejercicio 4 </h1>
    <form action="ej4.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="fichero">Seleccione el fichero</label>
            <input type="file" name="fichero" id="fichero" accept=".txt">
            <?php
            if(isset($_POST['contar']) && $error_form){
                if($_POST['fichero'] == ''){
                    echo '<span id="error">Campo vacío.</span>';
                }else if($_POST['fichero']['error']){
                    echo '<span id="error">Error, ha habido un error al subir el archivo</span>';
                }else if($_POST['fichero']['type'] != "text/plain"){
                    echo '<span id="error">No se ha subido ningún archivo</span>';
                }else{
                    echo '<span id="error">El archivo excede el tamaño</span>';
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="contar">Contar palabras</button>
        </p>
    </form>
    <?php
        if(isset($_POST['contar']) && !$error_form){

            @$fd=fopen($_FILES["fichero"]["tmp_name"], "r");
            if(!$fd){
                die("<h3>No se puede abrir el fichero subido al servidor</h3>");
            }
            $n_palabras=0;
            while($linea=fgets($fd)){
                $n_palabras+=str_word_count($linea);

                echo "<h3>El número de palabras que contiene el archivo seleccionado es de: ".$n_palabras."</h3>";
            }
        }
    ?>
</body>
</html>