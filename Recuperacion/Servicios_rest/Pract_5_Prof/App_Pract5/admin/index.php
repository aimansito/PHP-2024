<?php
session_name("Pract5_Rec_Jun_24_25");
session_start();

require "../src/funciones_ctes.php";

if(isset($_SESSION["token"]))
{
    //Estoy logueado

    // Pongo vistas oportunas
    $salto="../index.php";
    require "../src/seguridad.php";//Aquí se abre la conexión y se deja abierta

    if($datos_usu_log["tipo"]=="admin")
    {
        require "../vistas/vista_admin.php";
    }
    else
    {
        header("Location:../index.php");
        exit;
    }
    
}

else
{
    header("Location:../index.php");
    exit;
}