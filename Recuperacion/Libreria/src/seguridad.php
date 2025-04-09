<?php

// Control de baneo
// Conexion
try {
    $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    session_destroy();
    die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
}

// Consulta
try {
    $consulta = "select * from usuarios where lector = '".$_SESSION["usuario"]."' and clave = '".$_SESSION["clave"]."'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
}

// Está baneado
if (mysqli_num_rows($resultado) <= 0) {
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra en la bd";
    mysqli_close($conexion);
    header("Location: ".$salto);
    exit();
}

$datos_usuario_logueado = mysqli_fetch_assoc($resultado);
mysqli_free_result($resultado);

// Control de inactividad
if (time() - $_SESSION["ult_acc"] > MINUTOS*60) {
    session_unset();
    $_SESSION["seguridad"] = "Su sesión ha caducado";
    mysqli_close($conexion);
    header("Location: ".$salto);
    exit();
}
$_SESSION["ult_acc"] = time();
?>