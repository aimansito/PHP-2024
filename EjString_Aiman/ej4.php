<?php
// defino un array constante que asocia cada simnolo romano con su valor en numeros arabes
const VALOR = array("M"=>1000,"D"=>500,"C"=>100,"L"=>50,"X"=>10,"V"=>5,"I"=>1);
//funcion para comprobar si las letras ingresadas en el numero romano son validas
function letras_bien($texto){
    $bien = true; //variable para saber si todo esta bien
    for($i=0;$i<strlen($texto);$i++){//recorro cada letra del texto
        if(!isset(VALOR[$texto[$i]])){//compruebo si la letra actual no existe en el array de valores
            $bien = false; //si la letra no es valida, marco que esta mal
            break; //salgo
        }
    }
    return $bien;
}
//funcion para comprobar si las letras estan en el orden correcto de mayor a menor valor
function ordenCorrecto($texto){
    $bien = true;
    for($i=0;$i<strlen($texto)-1;$i++){
        if(VALOR[$texto[$i]]<VALOR[$texto[$i+1]]){//comparo el valor de la letra actual con la siguiente
            $bien = false;
            break;
        }
    }
    return $bien;
}
//funcion para comprobar que no se repita una letra más veces de lo permitido
function repite($texto){
    // Defino cuántas veces puede repetirse cada símbolo (I, X, C, M pueden repetirse hasta 3 veces; V, L, D no pueden repetirse).
    $veces = array("I" => 4, "V" => 1, "X" => 4, "L" => 1, "C" => 4, "D" => 1, "M" => 4);

    $bien = true;
    for($i=0;$i<strlen($texto);$i++){
        $veces[$texto[$i]]--;
        if($veces[$texto[$i]]==-1){//si uina letra se ha repetido más veces de las permitidas
            $bien = false;
            break;

        }
    }
    return $bien;
}
//funcion que agrupa todas las validaciones anteriores para verificar si el número romano es correcto 
function es_correcto_romano($texto){
    // devuelvo true si todas las condiciones se cumplen: las letras son validas, el orden es correcto y no hay repeticiones 
    return letras_bien($texto) && ordenCorrecto($texto) && repite ($texto);
}
//verifico si el formulario ha sido enviado 
if(isset($_POST["convertir"])){
    $texto = trim($_POST["numero"]); //elimino los espacios en blancos del numero ingresado
    $texto_m = strtoupper($texto);//convierto el numero romano a mayusculas para evitar problemas de comparacion

    //verifico si el campo está vacío 
    $error_numero_vacio = $texto == "";

    //verifico si hay algun error en el formulario (campo vacio o numero incorrecto).
    $error_form = $error_numero_vacio || !es_correcto_romano($texto_m);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
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
<form action="ej4.php" method="post" enctype="multipar/form-data">
        <div class="palabras">
            <h1>Romanos a árabes-Formulario</h1>
            <p>Dime un número en números romanos y lo convertiré a cifras árabes</p>
            <p>
                <!-- Campo para que el usuario ingrese el número romano -->
                <label for="numero">Número: </label>
                <!-- Se conserva el valor ingresado por el usuario en caso de error -->
                <input type="text" name="numero" id="n1" value="<?php if (isset($_POST["numero"])) echo $texto ?>">
                
                <!-- Se muestran mensajes de error si el número está vacío o es incorrecto -->
                <?php
                if (isset($_POST["convertir"]) && $error_form) {

                    if ($texto == "") {
                        echo "<span class='error'>*Campo Obligatorio* </span>"; // Error si el campo está vacío.
                    } else {

                        echo "<span class='error'>*No has metido el número romano correcto* </span>"; // Error si el número no es válido.
                    }
                }

                ?>
            </p>

            <p>
                <button type="submit" name="convertir">Convertir</button> <!-- Botón para enviar el formulario -->
            </p>
        </div>
    </form>

    <?php
    // Si se ha enviado el formulario y no hay errores en los datos.
    if (isset($_POST["convertir"]) && !$error_form) {
    ?>

        <br>
        <div class="verde">
            <h1>Romanos a árabes-Resultado</h1>
            <?php
            // Variable para almacenar la suma final del número romano convertido a árabe.
            $res = 0;
            
            // Recorro cada letra del número romano ingresado.
            for ($i = 0; $i < strlen($texto_m); $i++) {

                $res += VALOR[$texto_m[$i]]; // Sumo el valor de cada letra a la variable resultado.
            }

            // Muestro el resultado de la conversión.
            echo "<p>El número romano " . $texto_m . " en Árabe es: " . $res . "</p>"
            ?>

        </div>
    <?php
    }
    ?>
</body>
</html>