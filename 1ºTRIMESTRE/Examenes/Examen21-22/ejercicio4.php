<?php
    // Función personalizada para contar la longitud de una cadena
    function mi_strlen($texto) {
        $cont = 0; // Inicializa un contador
        // Recorre el texto carácter por carácter hasta llegar al final
        while (isset($texto[$cont])) {
            $cont++; // Incrementa el contador en cada iteración
        }
        return $cont; // Devuelve el valor total de caracteres
    }

    // Función personalizada que simula la función explode() de PHP
    function mi_explode($separador, $texto) {
        $array = []; // Crea un array vacío
        $longitud = mi_strlen($texto); // Obtiene la longitud del texto usando la función mi_strlen
        $i = 0; // Inicializa el índice

        // Saltar separadores iniciales
        while ($i < $longitud && $texto[$i] == $separador) {
            $i++; // Avanza hasta el primer carácter diferente al separador
        }

        // Si queda texto por analizar
        if ($i < $longitud) {
            $j = 0; // Inicializa el índice del array
            for ($i; $i < $longitud; $i++) { // Recorre todo el texto
                $array[$j] = ''; // Inicializa el elemento del array
                if ($texto[$i] != $separador) {
                    $array[$j] .= $texto[$i]; // Agrega el carácter si no es un separador
                } else {
                    // Salta separadores consecutivos
                    while ($i < $longitud && $texto[$i] == $separador) {
                        $i++;
                    }
                    $j++; // Pasa al siguiente índice del array
                }
            }
        }

        return $array; // Devuelve el array de elementos separados
    }

    // Verifica si se ha enviado el formulario de subir archivo
    if (isset($_POST["btnSubir"])) {
        // Comprueba si hay errores en el archivo subido
        $error_form = $_FILES["fichero"]["name"] == "" || // Si no hay archivo seleccionado
            $_FILES["fichero"]["error"] || // Si hubo algún error al subir el archivo
            $_FILES["fichero"]["type"] != 'text/plain' || // Si no es un archivo de texto
            $_FILES["fichero"]["size"] > 1000 * 1024; // Si el archivo supera 1MB
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
            color: red; /* Define el color rojo para los mensajes de error */
        }
        .texto_centrado {text-align: center;}
    </style>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <?php
    // Si el archivo se ha subido correctamente y no hay errores
    if (isset($_POST["btnSubir"]) && !$error_form) {
        // Intenta mover el archivo subido a la carpeta "Horario"
        @$var = move_uploaded_file($_FILES["fichero"]["tmp_name"], "Horario/horarios.txt");
        if (!$var) {
            echo "<p>El fichero seleccionado no se ha podido mover a la carpeta destino</p>";
        }
    }

    // Intenta abrir el archivo de horarios
    @$fd = fopen("Horario/horarios.txt", "r");
    if ($fd) {
        // Recorre cada línea del archivo de horarios
        while ($linea = fgets($fd)) {
            $datos_linea = mi_explode("\t", $linea); // Separa los datos usando tabulador como separador
            
            // Prepara las opciones del desplegable de profesores
            if (isset($_POST["btnVerHorario"]) && $_POST["profesor"] == $datos_linea[0]) {
                // Marca la opción seleccionada si coincide con el profesor seleccionado
                $options = "<option selected value='" . $datos_linea[0] . "'>" . $datos_linea[0] . "</option>";
            } else {
                // De lo contrario, crea una opción normal
                $options = "<option value='" . $datos_linea[0] . "'>" . $datos_linea[0] . "</option>";
            }
        }
        fclose($fd); // Cierra el archivo de horarios
    ?>
        <h2>Horario de los profesores</h2>
        <!-- Formulario para seleccionar el profesor -->
        <form action="ejercicio4.php" method="post">
            <p>
                <label for="profesor">Horario del profesor </label>
                <select name="profesor" id="profesor">
                    <?php
                        // Muestra las opciones generadas del desplegable
                        echo $options;
                    ?>
                </select>
                <button name="btnVerHorario" type="submit">Ver horario</button>
            </p>
        </form>
    <?php
        // Si se ha seleccionado un profesor para ver su horario
        if (isset($_POST["btnVerHorario"])) {
            echo "<h3>Horario del profesor: " . $_POST["profesor"] . "</h3>";
            // Aquí se podría mostrar el horario detallado del profesor
        }
    } else { // Si el archivo no existe o no se ha subido
    ?>
        <h2>No se encuentra el archivo <em>Horario/horarios.txt</em></h2>
        <!-- Formulario para subir el archivo de horarios -->
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="fichero">Seleccione un archivo (Máx. 1MB)</label>
                <input type="file" name="fichero" id="fichero" accept=".txt">
                <?php
                // Si hay errores al subir el archivo, muestra los mensajes de error
                if (isset($_POST["btnSubir"]) && $error_form) {
                    if ($_FILES["fichero"]["name"] == '') {
                        echo "<span class='error'>* Archivo no seleccionado</span>";
                    } else if ($_FILES["fichero"]["error"]) {
                        echo "<span class='error'>Error en la subida del fichero</span>";
                    } else if ($_FILES["fichero"]["type"] != 'text/plain') {
                        echo "<span class='error'>Error: no has seleccionado un archivo de texto</span>";
                    } else {
                        echo "<span class='error'>Error: el archivo seleccionado es superior a 1 MB</span>";
                    }
                }
                ?>
            </p>
            <p>
                <button type="submit" name="btnSubir">Subir</button>
            </p>
        </form>
    <?php
    }
    ?>
</body>
</html>
