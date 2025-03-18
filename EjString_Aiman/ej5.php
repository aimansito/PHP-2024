<?php


// si hay campos vacios envia el error
if (isset($_POST["convertir"])) {

    $num = trim($_POST["numero"]); // le quito los espacios en blanco

    $error_numero_vacio = $num == "";



    $error_form = $error_numero_vacio || !is_numeric($num) || $num <= 0 || $num < 5000;
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
    <form action="ej5.php" method="post" enctype="multipar/form-data">
        <div class="palabras">
            <h1>Romanos a árabes-Formulario</h1>
            <p>Dime un número en números romanos y lo convertire a cifras árabes</p>
            <p>
                <label for="numero">Número: </label>
                <input type="text" name="numero" id="n1" value="<?php if (isset($_POST["numero"])) echo $texto ?>">
                <?php
                if (isset($_POST["convertir"]) && $error_form) {

                    if ($texto == "") {
                        echo "<span class='error'>*Campo Obligatorio* </span>";
                    } else {

                        echo "<span class='error'>*No has metido el numero romano correcto* </span>";
                    }
                }

                ?>
            </p>

            <p>
                <button type="submit" name="convertir">Convertir</button>
            </p>
        </div>
    </form>
    <?php
    // si se le da ha comparar y no hay errores
    if (isset($_POST["convertir"]) && !$error_form) {
    ?>

        <br>
        <div class="verde">
            <h1>Romanos a árabes-Resultado</h1>
            <?php
          
            function convertirArabeRomano($texto)
            {
                $res = "";
                $num = $texto;
                while ($num > 0) {
                    if ($num >= 1000) {
                        $num -= 1000;
                        $res .= "M";
                    } else if ($num >= 500) {
                        $num -= 500;
                        $res .= "D";
                    } else if ($num >= 100) {
                        $num -= 100;
                        $res .= "C";
                    } else if ($num >= 50) {
                        $num -= 50;
                        $res .= "L";
                    } else if ($num >= 10) {
                        $num -= 10;
                        $res .= "X";
                    } else if ($num >= 5) {
                        $num -= 5;
                        $res .= "V";
                    } else {
                        $num -= 1;
                        $res .= "I";
                    }
                }
                return $res;
            }


            ?>

        </div>
    <?php
    }
    ?>
</body>

</html>