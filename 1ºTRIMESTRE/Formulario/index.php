<?php
$error_form = false;

if (isset($_POST["enviar"])) { //Compruebo errores

    $error_nombre = $_POST["name"] =="";
    $error_sex = !isset($_POST["sexo"]);
    /*
    $error_comentario = $_POST["message"] =="";
    $error_deporte=!isset($_POST["deporte"]);
    $error_lectura=!isset($_POST["lectura"]);
    $error_otro=!isset($_POST["otro"]);
    $error_aficiones=$error_deporte&&$error_lectura&&$error_otro;
    */
    $error_form = $error_nombre || $error_sex;
}

if (isset($_POST["enviar"])&&!$error_form) {

    require( 'VistaRespuesta.php');
} else {

        require('VistaIndex.php');
}
?>