<?php
session_name("examen2_24_25");
session_start();

require "src/funciones_ctes.php";


if(isset($_POST["btnCerrarSesion"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}

//Abro la conexion
try{
    @$conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    mysqli_set_charset($conexion,"utf8");
}
catch(Exception $e){
    session_destroy();
    die(error_page("Examen2 Php","<p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
}



if(isset($_SESSION["lector"]))
{
    $salto_seg="index.php";
    require "src/seguridad.php";
    if($datos_lector_log["tipo"]=="normal")
        require "vistas/vista_normal.php";
    else
    {
        mysqli_close($conexion);
        header("Location:admin/gest_libros.php");
        exit;
    }

}
else
{
    require "vistas/vista_login.php";
}

mysqli_close($conexion);

?>