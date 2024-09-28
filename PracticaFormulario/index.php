<?php

/*Primero compruebo que se haya pulsado el boton <enviar></enviar>*/

if(isset($_POST["enviar"])){
    //miramos los errores
    $errores = (($_POST["name"] == "") || (!isset($_POST["sex"])));
}
// si se pulsa y no hay errores , mostramos el resultado de lo recibido con sus valores correspondientes
if(isset($_POST["enviar"])&& !$errores){
    require "vistas/vistaRecogida.php";
}else{
    require "vistas/vistaFormulario.php";
}