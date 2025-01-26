<?php

/// Control de Baneo

try{
    $consulta="select * from usuarios where lector='".$_SESSION["lector"]."' and clave='".$_SESSION["clave"]."'";
    $result_usu_log=mysqli_query($conexion,$consulta);
}
catch(Exception $e){
    session_destroy();
    mysqli_close($conexion);
    die(error_page("Examen2 Php","<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
}

if(mysqli_num_rows($result_usu_log)<=0)
{
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    mysqli_free_result($result_usu_log);
    mysqli_close($conexion);
    header("Location:".$salto_seg);
    exit;
}

$datos_lector_log=mysqli_fetch_assoc($result_usu_log);
mysqli_free_result($result_usu_log);


//He pasado el baneo 
//Ahora el control de tiempo

if(time()-$_SESSION["ultima_accion"]>INACTIVIDAD*60)
{
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    mysqli_close($conexion);
    header("Location:".$salto_seg);
    exit;
}

$_SESSION["ultima_accion"]=time();

?>