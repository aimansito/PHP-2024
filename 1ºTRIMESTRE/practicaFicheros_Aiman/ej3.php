<?php
if(isset($_POST['enviar'])){
    $error_n = $_POST['n'] == '' || $_POST['n'] < 1 || $_POST['n'] > 10;
    $error_m = $_POST['m'] == '' || $_POST['m'] < 1 || $_POST['m'] > 10;
    $error_form = $error_n || $error_m;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
        .error{
            color : red;
        }
    </style>
</head>
<body>
    <h1>Ejercicio 3 </h1>
    <form action="ej3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="n">Introduzca un número entre 1 y 10(ambos incluidos)</label>
            <input type="number" name="n" id="n" value="<?php if(isset($_POST['n'])) echo $_POST['n'] ?>">
            <?php
            if(isset($_POST['enviar']) && $error_n){
                if($_POST['n'] == ''){
                    echo '<span class="error">Campo vacío.</span>';
                }else{
                    echo '<span class="error">Error: No has introducido un número entre 1 y 10.</span>';
                }
            }
            ?>
        </p>
        <p>
            <label for="m">Introduzca un número entre 1 y 10 (ambos incluidos)</label>
            <input type="number" name="m" id="m" value="<?php if (isset($_POST['m'])) echo $_POST['m'] ?>">
            <?php
            if (isset($_POST['enviar']) && $error_m) {
                if ($_POST['m'] == '') {
                    echo '<span class="error"> Campo vacío.</span>';
                } else {
                    echo '<span class="error"> Error: No has introducido un número entre 1 y 10.</span>';
                }
            }
            ?>
        </p>ç
        <p>
            <button type="submit" name="enviar">Ver fichero</button>
        </p>
    </form>
    <?php
    if(isset($_POST['enviar']) && !error_form){
        $nombre_fichero = 'tabla_'. $_POST['n'] . '.txt';
            @sfd = fopen('Tablas/'.$nombre_fichero,'r');
            if(!$fd){
                die("<p>Aún no está generando el fichero: 'Tablas/".$nombre_fichero."'</p>");
            }
            echo '<h2>Línea '.$_POST['m'].'del fichero </h2>';
            $cont = 1;
            $linea = fgets($fd);
            while($cont != $_POST['m']) {
                $linea = fgets($fd);
                $cont++;
            }
            echo '<p>'.$linea.'</p>';
            fclose($fd);
    }
    ?>
</body>
</html>