<?php
    require "src/funciones_ctes.php";

    if(isset($_POST["btnBorrar"])){
        unset($_POST);
    }

    if(isset($_POST["btnEnviar"])){
        $error_nombre = $_POST["nombre"]=="";
        
    }
?>