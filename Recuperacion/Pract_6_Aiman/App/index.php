<?php
    session_name("Pract6_Rec_Jun_24_25");
    session_start();

    require "src/funciones_ctes.php";


    if(isset($_POST["btnCerrarSesion"])){
        session_destroy();
        header("Location:index.php");
        exit;
    }

    if(isset($_SESSION["token"])){
        require "src/seguridad.php";

        if($datos_usu_log["tipo"]=="admin"){
            require "vistas/vista_admin.php";
        }else{
            require "vistas/vista_normal.php";
        }
    }elseif(isset($_POST["btnRegistro"]) || isset($_POST["btnContRegistro"]) || isset($_POST["btnReset"])){
        require "vistas/vista_registro.php";
    }else{
        require "vistas/vista_home.php";
    }
?>