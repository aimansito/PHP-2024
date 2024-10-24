<?php
    // Verifica si el botón de subir fue presionado
    if (isset($_POST["btnSubir"])) {
        // Inicializa una variable de error en base a varias condiciones:
        // 1. Si el nombre del archivo está vacío.
        // 2. Si hay algún error en el archivo subido.
        // 3. Si el tipo de archivo no es texto plano (.txt).
        // 4. Si el tamaño del archivo supera 1MB.
        $error_form = $_FILES["fichero"]["name"] == "" || 
                      $_FILES["fichero"]["error"] ||
                      $_FILES["fichero"]["type"] != 'text/plain' ||
                      $_FILES["fichero"]["size"] > 1000 * 1024;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error {color: red;} 
    </style>
</head>
<body>
    <h1>Ejercicio 2</h1>
    <!-- Formulario para subir archivos. enctype="multipart/form-data" es necesario para la subida de archivos -->
    <form action="ejercicio2.php" method="post" enctype="multipart/form-data">
    <p>
        <!-- Campo de selección de archivos. Solo permite archivos de texto (.txt) -->
        <label for="fichero">Seleccione un archivo (Máx. 1MB)</label>
        <input type="file" name="fichero" id="fichero" accept=".txt">
        
        <?php
            // Si se ha presionado el botón de subir y hay un error en el formulario
            if (isset($_POST["btnSubir"]) && $error_form) {
                // Muestra un error si no se seleccionó ningún archivo
                if ($_FILES["fichero"]["name"] == '') {
                    echo "<span class='error'>* Debes seleccionar un archivo</span>";
                // Muestra un error si ocurrió un problema durante la subida del archivo
                } else if ($_FILES["fichero"]["error"]) {
                    echo "<span class='error'>Error en la subida del fichero</span>";
                // Muestra un error si el tipo de archivo no es .txt
                } else if ($_FILES["fichero"]["type"] != 'text/plain') {
                    echo "<span class='error'>Error: no has seleccionado un archivo de texto</span>";
                // Muestra un error si el archivo supera los 1MB
                } else {
                    echo "<span class='error'>Error: el archivo seleccionado es superior a 1 MB</span>";
                }
            }
        ?>
    </p>
    <p>
        <!-- Botón para enviar el formulario -->
        <button type="submit" name="btnSubir">Subir</button>
    </p>
    </form>

    <?php
        // Si el formulario fue enviado y no hay errores, se intenta mover el archivo
        if (isset($_POST["btnSubir"]) && !$error_form) {
            // Intenta mover el archivo subido desde la carpeta temporal a la carpeta "Ficheros"
            @$var = move_uploaded_file($_FILES["fichero"]["tmp_name"], "Ficheros/archivo.txt");
            
            // Si el archivo fue movido correctamente, muestra mensaje de éxito
            if ($var) {
                echo "<p>Fichero subido con éxito</p>";
            } else {
                // Si no se pudo mover el archivo, muestra un mensaje de error
                echo "<p>El fichero seleccionado no ha podido moverse a la carpeta destino</p>";
            }
        }
    ?>
</body>
</html>