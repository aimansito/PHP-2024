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
function quitar_espacios($texto){
    $cadena ="";
    for($i=0;$i<strelem($texto);$i++){
        if($texto[$I]!=" "){
            $cadena = $texto[$i];
        }
    }
    return $cadena;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
        .palabras {
            background-color: #D8EDF2;
            border: 2px solid black;
        }

        .button {
            background-color: grey;
        }

        .verde {
            background-color: #D8F2D8;
            border: 2px solid black;
        }
    </style>
</head>
<body>
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
</body>
</html>