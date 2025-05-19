<?php

session_name("Pract6_Rec_Jun_24_25");
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

    // Pongo vistas oportunas
    require "src/seguridad.php";//Aquí se abre la conexión y se deja abierta

    if($datos_usu_log["tipo"]=="admin")
    {
        require "vistas/vista_admin.php";
    }
    else
    {
        require "vistas/vista_normal.php";
    }
    
    
}
elseif(isset($_POST["btnRegistro"]) || isset($_POST["btnContRegistro"]) || isset($_POST["btnReset"]))
{
    //No estoy logueado
    require "vistas/vista_registro.php";
}
else
{
    require "vistas/vista_home.php";
}

?>