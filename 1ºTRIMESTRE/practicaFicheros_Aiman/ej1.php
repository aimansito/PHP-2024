<?php
if (isset($_POST['enviar'])) {
    $error_form = $_POST['num'] == '' || !is_numeric($_POST['num']) || $_POST['num'] < 1 || $_POST['num'] > 10;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Ejercicio 1</h1>
    <form action="" method="post">
        <p>
            <label for="num">Introduzca un número entre 1 y 10 (ambos incluidos)</label>
            <input type="text" name="num" id="num" value="<?php if (isset($_POST['num'])) echo $_POST['num'] ?>">
            <?php
            if (isset($_POST['enviar']) && $error_form) {
                if ($_POST['num'] == '') {
                    echo '<span class="error"> Campo vacío.</span>';
                } else {
                    echo '<span class="error"> Error: No has introducido un número entre 1 y 10.</span>';
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="enviar">Crear fichero</button>
        </p>
    </form>
    
    <?php
    if (isset($_POST['enviar']) && !$error_form) {
        $nombre_fichero = 'tabla_' . $_POST['num'] . '.txt';

        // Crear el directorio si no existe
        if (!is_dir('Tablas')) {
            mkdir('Tablas', 0777, true);
        }

        // Crear el archivo si no existe
        if (!file_exists('Tablas/' . $nombre_fichero)) {
            @$fd = fopen('Tablas/' . $nombre_fichero, 'w');
            if (!$fd) {
                die("<p>No se pudo crear el fichero 'Tablas/" . $nombre_fichero . "'</p>");
            }
            // Generar la tabla de multiplicar y escribirla en el archivo
            for ($i = 1; $i <= 10; $i++) {
                fputs($fd, $i . ' x ' . $_POST['num'] . ' = ' . ($i * $_POST['num']) . PHP_EOL);
            }
            fclose($fd);
            echo '<p> Fichero generado con éxito </p>';
        } else {
            echo '<p>El fichero ya existe.</p>';
        }
    }
    ?>
</body>

</html>
