<?php
// si hay campos vacios envia el error
if (isset($_POST["comprobar"])) {

    $textoPrimera = trim($_POST["palabra_numero"]);

    // tengo que controlar el tamaño de la palabra
    // lo mejor meterlo  en una variable y de hay generar los errores
    $error_primeraPalabra = $textoPrimera == "";

    $error_primeraPalabraTama = strlen($textoPrimera) < 3;


    $error_form = $error_primeraPalabra || $error_primeraPalabraTama;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .palabras {
            background-color: #D8EDF2;
            border: 2px solid black;
        }

        button {
            background-color: grey;
        }

        .verde {
            background-color: #D8F2D8;
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <!--
     Escribe un formulario que pida una palabra o número y te diga si es o no un
palíndromo o un número capicúa:
        
-->
    <form action="ej2.php" method="post" enctype="multipar/form-data">
        <div class="palabras">
            <h1>Palíndormos / capicuas - Formulario</h1>
            <p>Dime una palabra o un número y te dire si es un palíndormo o un número capicùa-</p>
            <p>
                <label for="palabra_numero">Palabra o número</label>
                <input type="text" name="palabra_numero" id="p_n" value="<?php if (isset($_POST["palabra_numero"])) echo $_POST["palabra_numero"] ?>">
                <?php
                if (isset($_POST["comprobar"]) && $error_primeraPalabra)   echo "<span class='error'>*Campo Obligatorio* </span>";
                else if (isset($_POST["comprobar"]) && $error_primeraPalabraTama) echo "<span class='error'>*La palabra tiene que tener 3 caracteres como mínimo* </span>";
                ?>
            </p>

            <p>
                <button type="submit" name="comprobar">Comprobar</button>
            </p>
        </div>
    </form>
    <?php
    // si se le da ha comparar y no hay errores
    if (isset($_POST["comprobar"]) && !$error_form) {
    ?>
        <br>
        <div class="verde">
            <h1>Palíndromos / capícuas-Resultado</h1>
            <?php
            //Compruebo
            if(is_numeric($_POST["palabra_numero"])){
                $numero = intval($_POST["palabra_numero"]); // Convertir la entrada a un número entero
    
                $num_invertido = strrev($numero); // Invertir el número
                if ($numero == $num_invertido) {
                    echo "<p>El número " . $_POST["palabra_numero"] . " es capicúa</p>";
                } else {
                    echo "<p>El número " . $_POST["palabra_numero"] . " No es capicúa</p>";
                }  

            }else{ // si no es un número
                $texto_m= strtoupper($_POST["palabra_numero"]);
                $palabra_invertida= strrev($texto_m); // invierto el string
                if ($texto_m == $palabra_invertida) {
                    echo "<p>La palabra " . $_POST["palabra_numero"] . " es palíndromo</p>";
                } else {
                    echo "<p>La palabra " . $_POST["palabra_numero"] . " No  es palíndromo</p>";
                }  


            }
            ?>

        </div>
    <?php
    }
    ?>
</body>

</html>