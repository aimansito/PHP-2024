<?php


if(isset($_POST["btnContBorrar"]))
{
    
    $url=DIR_API."/borrar_usuario/".$_POST["btnContBorrar"];
    $respuesta=consumir_servicios_JWT_REST($url,"DELETE",$headers);
    $json_respuesta=json_decode($respuesta,true);
    if(!$json_respuesta)
    {
        session_destroy();
        die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
    }

    if(isset($json_respuesta["error"]))
    {
        session_destroy();
        die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
    }

    if(isset($json_respuesta["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    if($_POST["foto"]!=NOMBRE_FOTO_DEFECTO_BD && file_exists("images/".$_POST["foto"]))
        unlink("images/".$_POST["foto"]);
    
    

    $_SESSION["mensaje_accion"]="Usuario eliminado con éxito";
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnContBorrarFoto"]))
{
 
    $datos_env["foto"]=NOMBRE_FOTO_DEFECTO_BD;
    $url=DIR_API."/actualizar_foto/".$_POST["btnContBorrarFoto"];
    $respuesta=consumir_servicios_REST($url,"PUT",$datos_env);
    $json_respuesta=json_decode($respuesta,true);
    if(!$json_respuesta)
    {
        session_destroy();
        die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
    }

    if(isset($json_respuesta["error"]))
    {
        session_destroy();
        die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
    }


    if(file_exists("images/".$_POST["foto_bd"]))
        unlink("images/".$_POST["foto_bd"]);

    $_SESSION["mensaje_accion"]="Foto de Perfil borrada con éxito";
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnDetalles"])||isset($_POST["btnBorrar"]) || isset($_POST["btnEditar"]))
{
    if(isset($_POST["btnDetalles"]))
        $id_usuario=$_POST["btnDetalles"];
    elseif(isset($_POST["btnBorrar"]))
        $id_usuario=$_POST["btnBorrar"];
    else
        $id_usuario=$_POST["btnEditar"];

        
    $url=DIR_API."/detalles_usuario/".$id_usuario;
    $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
    $json_respuesta=json_decode($respuesta,true);
    if(!$json_respuesta)
    {
        session_destroy();
        die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
    }

    if(isset($json_respuesta["error"]))
    {
        session_destroy();
        die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
    }

    if(isset($json_respuesta["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    $detalles_usuario=$json_respuesta["usuario"];
}

if(isset($_POST["btnContEditar"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
       
        
        $datos_env_rep["valor"]=$_POST["usuario"];
        $datos_env_rep["valor_columna"]=$_POST["btnContEditar"];
        $url=DIR_API."/repetido_edit/usuarios/usuario/id_usuario";
        $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers,$datos_env_rep);
        $json_respuesta=json_decode($respuesta,true);
        if(!$json_respuesta)
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
        }

        if(isset($json_respuesta["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        $error_usuario=$json_respuesta["repetido"];
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"])|| !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $datos_env_rep["valor"]=strtoupper($_POST["dni"]);
        $datos_env_rep["valor_columna"]=$_POST["btnContEditar"];
        $url=DIR_API."/repetido_edit/usuarios/dni/id_usuario";
        $respuesta=consumir_servicios_JWT_REST($url,"GET",$headers,$datos_env_rep);
        $json_respuesta=json_decode($respuesta,true);
        if(!$json_respuesta)
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
        }

        if(isset($json_respuesta["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        $error_dni=$json_respuesta["repetido"];
    }
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || $_FILES["foto"]["size"]>500*1024 || !getimagesize($_FILES["foto"]["tmp_name"]));

    $error_form=$error_usuario||$error_nombre||$error_dni||$error_foto;
    if(!$error_form)
    {
        //edito, logueo y salto 

        $subs=0;
        if(isset($_POST["subscripcion"]))
            $subs=1;

        $datos_env_act["subscripcion"]=$subs;
        $datos_env_act["usuario"]=$_POST["usuario"];
        $datos_env_act["nombre"]=$_POST["nombre"];
        $datos_env_act["dni"]=strtoupper($_POST["dni"]);
        $datos_env_act["sexo"]=$_POST["sexo"];
        $datos_env_act["foto"]=$_POST["foto_bd"];

        if($_POST["clave"]=="")
        {
            $url=DIR_API."actualizar_usuario_sin_clave/".$_POST["btnContEditar"];
        }
        else
        {
            $url=DIR_API."actualizar_usuario_con_clave/".$_POST["btnContEditar"];
            $datos_env_act["clave"]=md5($_POST["clave"]);
        }

        $respuesta=consumir_servicios_JWT_REST($url,"PUT",$headers,$datos_env_act);
        $json_respuesta=json_decode($respuesta,true);
        if(!$json_respuesta)
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
        }

        if(isset($json_respuesta["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"]="Usuario editado con éxito";
        if($_FILES["foto"]["name"]!="")
        {
            
            $ext=tiene_extension($_FILES["foto"]["name"]);
            $nombre_unico="img_".$_POST["btnContEditar"].".".$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_unico);
            if($var)
            {
                if($nombre_unico!=$_POST["foto_bd"])
                {

                    $datos_env_act_foto["foto"]=$nombre_unico;
        
                    $url=DIR_API."/actualizar_foto/".$_POST["btnContEditar"];
                    $respuesta=consumir_servicios_REST($url,"PUT",$datos_env_act_foto);
                    $json_respuesta=json_decode($respuesta,true);
                    if(!$json_respuesta)
                    {
                        session_destroy();
                        die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
                    }

                    if(isset($json_respuesta["error"]))
                    {
                        if(file_exists("images/".$nombre_unico))
                            unlink("images/".$nombre_unico);

                        $_SESSION["mensaje_registro"]="Usuario registrado con éxito, pero con la imagen por defecto por un error en la actualización en la BD";
                    }
                    else
                    {
                        if($_POST["foto_bd"]!=NOMBRE_FOTO_DEFECTO_BD && file_exists("images/".$_POST["foto_bd"]))
                            unlink("images/".$_POST["foto_bd"]);
                    }

                }
            }
            else
            {
                $_SESSION["mensaje_accion"]="Usuario editado con éxito, pero con la imagen por defecto por no poder mover imagen subida a la carpeta destino";
            }
        }

    
        header("Location:index.php");
        exit;


    }
}


if(isset($_POST["btnContRegistro"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
       
        $datos_env_rep["valor"]=$_POST["usuario"];
        $url=DIR_API."/repetido_insert/usuarios/usuario";
        $respuesta=consumir_servicios_REST($url,"GET",$datos_env_rep);
        $json_respuesta=json_decode($respuesta,true);
        if(!$json_respuesta)
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
        }

        $error_usuario=$json_respuesta["repetido"];
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"])|| !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $datos_env_rep["valor"]=strtoupper($_POST["dni"]);
        $url=DIR_API."/repetido_insert/usuarios/dni";
        $respuesta=consumir_servicios_REST($url,"GET",$datos_env_rep);
        $json_respuesta=json_decode($respuesta,true);
        if(!$json_respuesta)
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
        }

        $error_dni=$json_respuesta["repetido"];
    }
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || $_FILES["foto"]["size"]>500*1024 || !getimagesize($_FILES["foto"]["tmp_name"]));

    $error_form=$error_usuario||$error_nombre||$error_clave||$error_dni||$error_foto;
    if(!$error_form)
    {
        //inserto, logueo y salto 

        $datos_env_insert["subscripcion"]=0;
        if(isset($_POST["subscripcion"]))
            $datos_env_insert["subscripcion"]=1;

        $datos_env_insert["usuario"]=$_POST["usuario"];
        $datos_env_insert["nombre"]=$_POST["nombre"];
        $datos_env_insert["clave"]=md5($_POST["clave"]);
        $datos_env_insert["dni"]=strtoupper($_POST["dni"]);
        $datos_env_insert["sexo"]=$_POST["sexo"];
        
        $url=DIR_API."/insertar_usuario";
        $respuesta=consumir_servicios_REST($url,"POST",$datos_env_insert);
        $json_respuesta=json_decode($respuesta,true);
        if(!$json_respuesta)
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
        }
        
        $_SESSION["mensaje_accion"]="Usuario insertado con éxito";
        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$json_respuesta["ultm_id"];
            $ext=tiene_extension($_FILES["foto"]["name"]);
            $nombre_unico="img_".$ultm_id.".".$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_unico);
            if($var)
            {

                $datos_env_act["foto"]=$nombre_unico;
        
                $url=DIR_API."/actualizar_foto/".$ultm_id;
                $respuesta=consumir_servicios_REST($url,"PUT",$datos_env_act);
                $json_respuesta=json_decode($respuesta,true);
                if(!$json_respuesta)
                {
                    session_destroy();
                    die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
                }
        
                if(isset($json_respuesta["error"]))
                {
                    if(file_exists("images/".$nombre_unico))
                        unlink("images/".$nombre_unico);

                    $_SESSION["mensaje_registro"]="Usuario registrado con éxito, pero con la imagen por defecto por un error en la actualización en la BD";
                }
            }
            else
            {
                $_SESSION["mensaje_registro"]="Usuario registrado con éxito, pero con la imagen por defecto por no poder mover imagen subida a la carpeta destino";
            }
        }

        header("Location:index.php");
        exit;

    }



}


$url=DIR_API."/obtener_usuarios_no_admin";
$respuesta=consumir_servicios_JWT_REST($url,"GET",$headers);
$json_respuesta=json_decode($respuesta,true);
if(!$json_respuesta)
{
    session_destroy();
    die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
}

if(isset($json_respuesta["error"]))
{
    session_destroy();
    die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
}

if(isset($json_respuesta["no_auth"]))
{
    session_unset();
    $_SESSION["seguridad"]="El tiempo de sesión de la API ha caducado";
    header("Location:index.php");
    exit;
}

$usuarios=$json_respuesta["usuarios"];



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6 - Rec</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;text-decoration: underline;color:blue;cursor: pointer;}
        .tabla_alumnos{
            width:80%; margin:0 auto; text-align:center;border-collapse:collapse
        }
        .tabla_alumnos, .tabla_alumnos td, .tabla_alumnos th{border:1px solid black}
        .tabla_alumnos img{height:75px}
        .error{
            color:red
        }
        .mensaje{
            width:80%; margin:0.5em auto;text-align:center;color:blue;font-size:1.25em}
        .foto_detalles{height:150px;vertical-align:middle}
        .form_confirmar{width:80%; margin:0.5em auto;text-align:center;}
        .foto_click{cursor:pointer;background: none;border:none}
    </style>
</head>
<body>
    <h1>Práctica 6 - Rec</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usu_log["usuario"];?></strong> - 
        <form class="enlinea" method="post" action="index.php">
            <button class="enlace" type="submit" name="btnCerrarSesion">Salir</button>
        </form>
    </div>
    
    <?php
    if(isset($_POST["btnAgregar"]) || isset($_POST["btnContRegistro"])|| isset($_POST["btnReset"]))
    {
        require "vistas/vista_agregar.php";
    }

    if(isset($_POST["btnDetalles"]))
    {
        require "vistas/vista_detalles.php";

    }

    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vista_conf_borrar.php";

    }


    if(isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]))
    {
        require "vistas/vista_form_editar.php";
    }

    if(isset($_POST["btnBorrarFoto"]))
    {
        require "vistas/vista_borrar_foto.php";
    }


    require "vistas/vista_tabla_gest_usuarios.php";
   
    if(isset($_SESSION["mensaje_accion"]))
    {
        echo "<p class='mensaje'>¡¡¡ ".$_SESSION["mensaje_accion"]." !!!</p>";
        unset($_SESSION["mensaje_accion"]);
    }
    ?>
</body>
</html>