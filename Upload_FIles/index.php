<?php
if (isset($_POST['enviar'])) {
    $error_archivo=$_FILES["archivo"]["name"]=="" ||
    $_FILES['archivo']['error'] || !getimagesize($_FILES['archivo']['tmp_name'])
|| $_FILES['archivo']['size'] > 500*1024;
}

if (isset($_POST["enviar"]) && !$error_archivo) {
?>
<!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teoría subir fichero al servidor</title>
        <style>
            .tam_imag {width:35%}
        </style>
    </head>

    <body>
        <h1>Teoría subir fichero al servidor</h1>
        <h2>Datos del archivo subido</h2>
        <?php
        $nombre_nuevo = md5(uniqid(uniqid(),true)); // Para crear una serie de números únicos
        $array_nombre = explode('.', $_FILES['archivo']['name']);
        $ext=""; // extensión
        // Si el nombre dividido por . tiene mas de 1 parte, tiene extensión
        if(count($array_nombre) > 1) {
            $ext = '.'.end($array_nombre); // El último sería la extensión
        }

        $nombre_nuevo .= $ext;
        @$var = move_uploaded_file($_FILES['archivo']['tmp_name'], 'images/'.$nombre_nuevo);
        if ($var) {
        ?>
            <h3>Foto</h3>
            <p><strong>Nombre: </strong><?php echo $_FILES['archivo']['name'] ?></p>
            <p><strong>Tipo: </strong><?php echo $_FILES['archivo']['type'] ?></p>
            <p><strong>Tamaño: </strong><?php echo $_FILES['archivo']['size'] ?></p>
            <p><strong>Error: </strong><?php echo $_FILES['archivo']['error'] ?></p>
            <p><strong>Archivo en el Temporal del servidor: </strong><?php echo $_FILES['archivo']['tmp_name'] ?></p>
            <p>La imagen ha sido subida con éxito</p>
            <p><img class="tam_imag" src="images/<?php echo $nombre_nuevo ?>" alt="Foto" title="Foto"/></p>
        <?php
        } else {
            echo "<p>No se ha podido mover la imagen a la carpeta destino en el servidor</p>";
        }
        ?>
    </body>
    </html>
<?php
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teoría subir fichero al servidor</title>
        <style>
            .error {color: red}
        </style>
    </head>

    <body>
        <h1>Teoría subir fichero al servidor</h1>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="archivo">Selecciones un archivo imagen (Máx. 500KB): </label>
                <input type="file" name="archivo" id="archivo" accept="image/*">
                <?php
                    if (isset($_POST['enviar']) && $error_archivo) {
                        if ($_FILES['archivo']['name'] != '') {
                            if ($_FILES['archivo']['error']) {
                                echo "<span class = 'error'> No se ha podido subir el archivo al servidor </span>";
                            } else if (!getimagesize($_FILES['archivo']['tmp_name'])) {
                                echo "<span class = 'error'> El archivo seleccionado no es una imagen </span>";
                            } else {
                                echo "<span class = 'error'> El archivo seleccionado supera los 500KB </span>";
                            }
                        }
                    }
                ?>
            </p>
            <p>
                <button type="submit" name="enviar">Enviar</button>
            </p>
        </form>
    </body>
    </html>
<?php
}
?>