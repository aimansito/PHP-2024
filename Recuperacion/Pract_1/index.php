<?php



    require "src/funciones_ctes.php";

    if(isset($_POST["btnBorrar"])){
        //header("Location:index.php");
        //exit;

        unset($_POST);
    }

    if(isset($_POST["btnEnviar"])){
        // compruebo los errores cuando se haga submit del formulario
        $error_nombre=$_POST["nombre"]=="";
        $error_apellidos=$_POST["apellidos"]=="";
        $error_clave=$_POST["clave"]=="";
        $error_dni = $_POST["dni"]=="" || strlen($_POST["dni"])!=9 || !is_numeric(substr($_POST["dni"],0,8)) || strtoupper(substr($_POST["dni"],8,1))<"A" || strtoupper(substr($_POST["dni"],8,1))>"Z";
        $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || $_FILES["foto"]["size"]>500*1024 || !getimagesize($_FILES["foto"]["tmp_name"]));
        $error_subscripcion=  !isset($_POST["subscripcion"]); 

        $errores_form=$error_nombre||$error_apellidos||$error_clave||$error_dni||$error_foto||$error_subscripcion;

    }



    if(isset($_POST["btnEnviar"]) && !$errores_form){
        require "vistas/vistas_respuestas.php";
    }else{
        require "vistas/vista_formulario.php";
    }
?>