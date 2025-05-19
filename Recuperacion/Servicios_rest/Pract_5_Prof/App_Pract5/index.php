<?php

session_name("Pract5_Rec_Jun_24_25");
session_start();

require "src/funciones_ctes.php";


//Código para cerrar sesión una vez logueado desde las vista admin y normal
if(isset($_POST["btnCerrarSesion"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}


if(isset($_SESSION["token"]))
{
    //Estoy logueado
    $salto="index.php";
    // Pongo vistas oportunas
    require "src/seguridad.php";//Aquí se abre la conexión y se deja abierta

    if($datos_usu_log["tipo"]=="admin")
    {
        header("Location:admin/index.php");
        exit;
    }
    else
    {
        require "vistas/vista_normal.php";
    }
    
}

else
{
    require "vistas/vista_home.php";
}

?>