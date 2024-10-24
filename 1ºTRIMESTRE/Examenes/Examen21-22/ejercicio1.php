<?php
    // Función personalizada para contar la longitud de un texto
    function mi_strlen($texto) {
        $cont = 0; // Inicializa un contador
        // Recorre cada carácter del texto hasta que no exista un carácter en la posición $cont
        while (isset($texto[$cont])) {
            $cont++; // Incrementa el contador por cada carácter encontrado
        }
        return $cont; // Devuelve el número total de caracteres
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<body>
    <!-- Formulario para introducir texto y enviarlo al servidor -->
    <form action="ejercicio1.php" method="post" enctype="multipart/form-data"> <!-- Se corrigió 'mutlipart' a 'multipart' -->
        <p>
            <label for="texto">Introduce el texto: </label>
            <!-- Campo de texto donde el usuario puede introducir el texto. Se mantiene el valor si el formulario fue enviado -->
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"] ?>"/>
        </p>
        <p>
            <button type="submit" name="contar">Contar</button> <!-- Botón para enviar el formulario -->
        </p>
    </form>

    <?php
        // Comprueba si el botón "contar" fue presionado
        if (isset($_POST["contar"])) {
            // Muestra el resultado debajo del formulario
            echo "<h2>Respuesta: </h2>";
            // Llama a la función personalizada para contar los caracteres y muestra el resultado
            echo "<p>El número de caracteres tecleado ha sido de: " . mi_strlen($_POST["texto"]) . "</p>";
        }
    ?>
</body>
</html>