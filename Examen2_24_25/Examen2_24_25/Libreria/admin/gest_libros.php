<?php
session_name("examen2_24_25");
session_start();

require "../src/funciones_ctes.php";

if(isset($_SESSION["lector"]))
{
    try{
        @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e){
        session_destroy();
        die(error_page("Examen2 Php","<p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
    }

    $salto_seg="../index.php";
    require "../src/seguridad.php";

    if($datos_lector_log["tipo"]=="admin")
        require "../vistas/vista_admin.php";
    else
    {
        mysqli_close($conexion);
        header("Location:../index.php");
        exit;
    }

    mysqli_close($conexion);
}
else
{
    header("Location:../index.php");
    exit;
}

?>