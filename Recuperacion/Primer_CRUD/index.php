<?php
    session_name("Primer_CRUD");
    session_start();

    if(isset($_POST["btnCerrarSesion"])){
        session_destroy();
        header("Location:index.php");
        exit;
    }

    if(isset($_SESSION("usuario"))){
        //Estoy logueado

        //Pongo vistas oportunas
        require "src/seguridad.php";
        if($datos_usu_log["tipo"]=="admin"){
            require "vistas/vista_admin.php";
        }else{
            require "vistas/vista_normal.php";
        }
        $conexion = null;
    }elseif(isset($_POST["btnRegistro"]) || isset($_POST["btnContRegistro"]) || isset($_POST["btnReset"])){
        require "vistas/vista_registro.php";
    }else{
        require "vistas/vista_home.php";
    }
?>