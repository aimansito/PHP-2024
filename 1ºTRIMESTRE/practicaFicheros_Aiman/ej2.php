<?php
if(isset($_POST['enviar'])){
    $error_form = $_POST['num'] == '' || !is_numeric($_POST['num']) || $_POST['num'] < 1 || $_POST['num'] > 10;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error{
            color:red;
        }
    </style>
</head>
<body>
    <h1>Ejercicio 2</h1>
    <form action="ej2.php" method="post">
        <p>
            <label for="num">Introduzca un número entre 1 y 10</label>
            <input type="text" name="num" id="num"value="<?php if(isset($_POST['num'])) echo $_POST['num'] ?>">
            <?php
            if(isset($_POST['enviar']) && $error_form){
                if($_POST['num'] == ''){
                    echo '<span class="error">Campo vacío.</span>';
                }else{
                    echo '<span class="error">Error. No has introducido un número del 1 al 10';
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="enviar">Ver fichero</button>
        </p>
    </form>
    <?php
    if(isset($_POST['enviar'])&& !$error_form){
        $nombre_fichero = 'tabla_' . $_POST['num'] . '.txt';
            @sfd = fopen('Tablas/'.$nombre_fichero,'r');
            if(!$fd){
                die("<p>Aún no está generado el fichero: 'Tablas/".$nombre_fichero."'</p>");
            }
            echo '<h2>Tabla del '.$POST['num'].'</h2>';
            while($linea = fgets($fd)){
                echo '<p>'.$linea.'</p>';
            }
            fclose($fd);
    }
    ?>
</body>
</html>