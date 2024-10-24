<?php
    // Función personalizada para contar la longitud de una cadena
    function mi_strlen($texto){
        $cont = 0; // Contador inicializado en 0
        // Recorre cada carácter de la cadena hasta que no existan más caracteres
        while(isset($texto[$cont])){
            $cont++; // Incrementa el contador en cada iteración
        }
        return $cont; // Devuelve la longitud del texto
    }

    // Función personalizada que simula la función explode() de PHP
    function mi_explode($separador, $texto){
        $array = []; // Array vacío donde se almacenarán las partes divididas
        $longitud = mi_strlen($texto); // Calcula la longitud del texto usando la función mi_strlen
        $i = 0; // Inicializa el índice de recorrido

        // Saltar separadores iniciales
        while($i < $longitud && $texto[$i] == $separador){
            $i++; // Avanza el índice mientras se encuentren separadores
        }

        // Si aún hay texto después de los separadores iniciales
        if($i < $longitud){
            $j = 0; // Inicializa el índice para el array
            for($i; $i < $longitud; $i++){ // Recorre todo el texto
                $array[$j] = ''; // Inicializa el elemento del array
                if($texto[$i] != $separador){
                    $array[$j] .= $texto[$i]; // Agrega el carácter actual al array
                } else {
                    // Si encuentra el separador, avanza hasta que deje de encontrarlo
                    while($i < $longitud && $texto[$i] == $separador){
                        $i++;
                    }
                    $j++; // Pasa al siguiente índice del array
                }
            }
        }
        return $array; // Devuelve el array con las partes divididas
    }

    // Verifica si se ha enviado el formulario y si el campo "texto" está vacío
    if(isset($_POST["contar"])){
        $error_form = $_POST["texto"] == ""; // Variable que indica si hay error (texto vacío)
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
            color: red; /* Estilo para mostrar mensajes de error en rojo */
        }
    </style>
</head>
<body>
    <h1>Ejercicio 3</h1>
    <!-- Formulario para el ejercicio -->
    <form action="ejercicio3.php" method="post">
        <p>
            <!-- Selector de separadores -->
            <label for="sep">Elija separador</label>
            <select name="sep" id="sep">
                <!-- Las opciones del selector verifican si han sido seleccionadas antes para mantener el valor -->
                <option <?php if(isset($_POST["contar"]) && $_POST["sep"] == ",") echo "selected";?> value=",">,(coma)</option>
                <option <?php if(isset($_POST["contar"]) && $_POST["sep"] == ";") echo "selected";?> value=";">; (punto y coma)</option>
                <option <?php if(isset($_POST["contar"]) && $_POST["sep"] == " ") echo "selected";?> value=" ">&nbsp; (espacio)</option>
                <option <?php if(isset($_POST["contar"]) && $_POST["sep"] == ":") echo "selected";?> value=":">: (dos puntos)</option>
            </select>
        </p>
        <p>
            <!-- Campo de texto donde el usuario introduce la frase -->
            <label for="texto">Introduzca una frase</label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"] ?>">
            <?php
                // Si el formulario fue enviado y el campo está vacío, muestra un mensaje de error
                if(isset($_POST["contar"]) && $error_form){
                    echo "<span class='error'>Campo vacío</span>";
                }
            ?>
        </p>
        <p>
            <!-- Botón para enviar el formulario -->
            <button type="submit" name="contar">Contar</button>
        </p>
    </form>

    <?php
        // Si el formulario fue enviado y no hay errores
        if(isset($_POST["contar"]) && !$error_form){
            echo "<h2>Respuesta</h2>";
            // Cuenta las palabras separadas por el separador elegido y muestra el resultado
            echo "<p>El número de palabras separadas por el separador es de: ".count(mi_explode($_POST["sep"], $_POST["texto"]))."</p>";
        }
    ?>
</body>
</html>