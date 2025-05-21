<?php
    // Añadimos al array de cabeceras el token JWT que se encuentra en la sesión actual
    // Muy importante: hay que dejar un espacio después de 'Bearer'
    $headers[] = "Authorization: Bearer " . $_SESSION["token"];

    // URL del endpoint que verifica si el usuario sigue logueado (token válido y usuario existente)
    $url = DIR_SERV . "/logueado";

    // Llamamos al servicio REST usando una función personalizada
    // Enviamos método GET con cabeceras incluyendo el token
    $respuesta = consumir_servicios_JWT_REST($url, "GET", $headers);

    // Decodificamos la respuesta JSON a un array asociativo de PHP
    $json_respuesta = json_decode($respuesta, true);

    // ──────────────────────────────────────────────────────
    // VALIDACIÓN DE LA RESPUESTA
    // ──────────────────────────────────────────────────────

    // Si no se puede decodificar la respuesta JSON → error grave
    if (!$json_respuesta) {
        session_destroy();
        die(error_page(
            "Gestión de Guardias",
            "<h1>Gestión de Guardias</h1><p>Error consumiendo el servicio Rest: <strong>" . $url . "</strong></p>"
        ));
    }

    // Si el servicio devuelve un error en formato JSON (clave 'error')
    if (isset($json_respuesta["error"])) {
        session_destroy();
        die(error_page(
            "Gestión de Guardias",
            "<h1>Gestión de Guardias</h1><p>" . $json_respuesta["error"] . "</p>"
        ));
    }

    // Si el token es inválido o ha expirado → el servicio devuelve "no-auth"
    if (isset($json_respuesta["no-auth"])) {
        session_unset(); // Eliminamos variables de sesión pero mantenemos la sesión activa
        $_SESSION["mensaje_seguridad"] = "El tiempo de sesión de la API ha expirado";
        header("Location:index.php");
        exit;
    }

    // Si el usuario ha sido eliminado de la base de datos (caso extremo)
    if (isset($json_respuesta["mensaje_baneo"])) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit;
    }

    // Si todo ha ido bien, guardamos los datos del usuario en una variable
    $datos_usu_log = $json_respuesta["usuario"];

    // Actualizamos el token renovado que ha devuelto el backend
    $_SESSION["token"] = $json_respuesta["token"];

    // ──────────────────────────────────────────────────────
    // VALIDACIÓN DEL TIEMPO DE INACTIVIDAD LOCAL (cliente)
    // ──────────────────────────────────────────────────────

    // Si ha pasado más tiempo del permitido desde la última acción → cerrar sesión
    if (time() - $_SESSION["ultm_accion"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["mensaje_seguridad"] = "Su tiempo de sesión ha expirado";
        header("Location:index.php");
        exit;
    }

    // Si no ha expirado, actualizamos el timestamp de la última acción
    $_SESSION["ultm_accion"] = time();
?>
