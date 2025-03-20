<?php
    require "src/funciones_ctes.php";

    if(isset($_POST["btnBorrar"])){
        unset($_POST);
    }

    if(isset($_POST["btnEnviar"])){

        $error_nombre=$_POST["nombre"]="";
        $error_sexo=!isset($_POST["sexo"]);
        $error_comentarios=$_POST["comentarios"]="";
        $error_foto=$_FILES["foto"]["name"]!="" || $_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || $_FILES["foto"]["size"]>500*1024 || !getimagesize($_FILES["foto"]["tmp_name"]);


        $errores_form=$error_nombre||$error_sexo||$error_comentarios||$error_foto;
    }


    if(isset($_POST["btnEnviar"]) && !$errores_form){
        require "vistas/vistaDatos.php";
    }else{
        require "vistas/vistaForm.php";
    }
?>