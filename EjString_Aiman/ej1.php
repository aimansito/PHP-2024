<?php
// si hay campos vacios envia el error
if (isset($_POST["comparar"])) {

    $textoPrimera=trim( $_POST["primera"]);
    $textoSegunda=trim( $_POST["segunda"]);
    // tengo que controlar el tamaño de la palabra
    // lo mejor meterlo  en una variable y de hay generar los errores
    $error_primeraPalabra = $textoPrimera == "";
    $error_segundaPalabra =  $textoSegunda == "";
    $error_primeraPalabraTama = strlen( $textoPrimera) < 3;
    $error_segundaPalabraTama = strlen( $textoSegunda)< 3;

    $error_form = $error_primeraPalabra || $error_segundaPalabra || $error_segundaPalabraTama || $error_primeraPalabraTama;
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
     Escribe un formulario que pida dos palabras y diga si riman o no. Si
coinciden las tres últimas letras tiene que decir que riman. Si coinciden sólo
las dos últimas tiene que decir que riman un poco y si no, que no riman.
        
-->
    <form action="ej1.php" method="post" enctype="multipar/form-data">
        <div class="palabras">
            <h1>Ripios-Formulario</h1>
            <p>Dime dos palabras y te diré si riman o no</p>
            <p>
                <label for="primera_palabra">Primera palabra:</label>
                <input type="text" name="primera" id="primera_palabra" value="<?php if (isset($_POST["primera"])) echo $_POST["primera"] ?>">
                <?php
                if (isset($_POST["comparar"]) && $error_primeraPalabra)   echo "<span class='error'>*Campo Obligatorio* </span>";
                else if (isset($_POST["comparar"]) && $error_primeraPalabraTama) echo "<span class='error'>*La palabra tiene que tener 3 caracteres como mínimo* </span>";
                ?>
            </p>
            <p>
                <label for="segunda_palabra">Segunda palabra:</label>
                <!--En el value controlo que deje la informacion correcta -->
                <input type="text" name="segunda" id="segunda_palabra" value="<?php if (isset($_POST["segunda"])) echo $_POST["segunda"] ?>">
                <!--Dentro del <p> controlo el error del campo vacio con mensaje de error -->
                <?php
                if (isset($_POST["comparar"]) && $error_segundaPalabra)   echo "<span class='error'>*Campo Obligatorio* </span>";
                else if (isset($_POST["comparar"]) && $error_segundaPalabraTama) echo "<span class='error'>*La palabra tiene que tener 3 caracteres como mínimo* </span>";
                ?>
            </p>
            <p>
                <button type="submit" name="comparar">Comparar</button>
            </p>
        </div>
    </form>
    <?php
    // si se le da ha comparar y no hay errores
    if (isset($_POST["comparar"]) && !$error_form) {
    ?>
        <br>
        <div class="verde">
            <h1>Ripios_Resultados</h1>
            <?php
            // las pongo en mayusculasa para evitar errores
            $texto1_m=strtoupper($_POST["primera"]);
            $texto2_m=strtoupper($_POST["segunda"]);
            // palabras que riman 3
             $palabra1de3=substr($texto1_m,-3);
             $palabra2de3=substr($texto2_m,-3);
            //palabras que riman 2
             $palabra1de2=substr($texto1_m,-2);
             $palabra2de2=substr($texto2_m,-2);

             
            if($palabra1de3== $palabra2de3){ echo "<p><strong>Las palabras riman</p></strong>";}
           else if(($palabra1de2 == $palabra2de2)){ echo "<p><strong>Las palabras riman un poco</p></strong>";}
            else echo "<p><h2><strong>No riman</p></strong></h2>";
            ?>
           
        </div>
    <?php
    }
    ?>
</body>

</html>