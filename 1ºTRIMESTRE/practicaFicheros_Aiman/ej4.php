<?php
if (isset($_POST['contar'])) {
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
        .error {
            color: red
        }
    </style>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <form action="Ejercicio4.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="fichero">Seleccione un fichero de texto para contar sus palabras(Máx. 2'5MB): </label>
            <input type="file" name="fichero" id="fichero" accept=".txt">
            <?php
            if (isset($_POST['contar']) && $error_form) {
                if ($_POST['fichero'] == '') {
                    echo '<span class="error"> Campo vacío.</span>';
                } else if($_FILES["fichero"]["error"]) {
                    echo '<span class="error"> Error no se ha podido subir el fichero al servidor.</span>';
                } else if($_FILES["fichero"]["type"] != "text/plain"){
                    echo '<span class="error"> No has seleccionado un fichero txt.</span>';
                } else {
                    echo '<span class="error"> El tamaño del fichero de texto supera los 2,5 MB.</span>';
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="contar">Contar palabras</button>
        </p>
    </form>
    <?php
    if (isset($_POST['contar']) && !$error_form) {
        //$contenido_fichero = file_get_contents($_FILES["fichero"]["tmp_name"]);
        //echo "<h3>El número de palabras que contiene el archivo seleccionado es de: ".str_word_count($contenido_fichero)."</h3>";

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