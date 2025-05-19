<?php
if(isset($_POST["btnReset"]))
{
    unset($_POST);
}

if(isset($_POST["btnContRegistro"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
        //realizo conexion
        $datos_env_rep["valor"]=$_POST["usuario"];
        $url=DIR_API."/repetido_insert/usuarios/usuario";
        $respuesta=consumir_servicios_REST($url,"GET",$datos_env_rep);
        $json_respuesta=json_decode($respuesta,true);
        if(!$json_respuesta)
        {
            session_destroy();
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
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
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
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
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
        }

        if(isset($json_respuesta["error"]))
        {
            session_destroy();
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$json_respuesta["error"]."</p>"));
        }

        
        $_SESSION["mensaje_registro"]="Usuario registrado con éxito";
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
                    die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
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

        //logueo
        $_SESSION["usuario"]=$datos_env_insert["usuario"];
        $_SESSION["clave"]=$datos_env_insert["clave"];
        $_SESSION["ultm_accion"]=time();
        header("Location:index.php");
        exit;

    }


   

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4 - Rec</title>
    <style>
        .error{
            color:red
        }
    </style>
</head>
<body>
    <h1>Práctica 4 - Rec</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario:</label><br>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
            if(isset($_POST["btnContRegistro"]) && $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> * Campo vacío</span>";
                else
                    echo "<span class='error'> * Usuario repetido</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>">
            <?php
            if(isset($_POST["btnContRegistro"]) && $error_nombre)
                echo "<span class='error'> * Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label><br>
            <input type="password" name="clave" id="clave" placeholder="Contraseña...">
            <?php
            if(isset($_POST["btnContRegistro"]) && $error_clave)
                echo "<span class='error'> * Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="dni">DNI:</label><br>
            <input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>">
            <?php
            if(isset($_POST["btnContRegistro"]) && $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'> * Campo vacío</span>";
                elseif(!dni_bien_escrito($_POST["dni"]))
                    echo "<span class='error'> * Dni no está bien escrito</span>";
                elseif(!dni_valido($_POST["dni"]))
                    echo "<span class='error'> * Dni no es válido</span>";
                else
                    echo "<span class='error'> * Dni repetido</span>";
            }
                
            ?>
        </p>
        <p>
            Sexo:<br>
            <input type="radio" name="sexo" value="Hombre" id="hombre" <?php if(!isset($_POST["sexo"]) || (isset($_POST["sexo"])&& $_POST["sexo"]=="Hombre")) echo "checked";?>>
            <label for="hombre"> Hombre</label><br>
            <input type="radio" name="sexo" value="Mujer" id="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="Mujer") echo "checked";?>>
            <label for="mujer"> Mujer</label>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Máx 500KB):</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php
                if(isset($_POST["btnContRegistro"]) && $error_foto)
                {
                    if($_FILES["foto"]["error"])
                        echo "<span class='error'> * Se ha producido un error en la subida del archivo al servidor</span>";
                    elseif(!tiene_extension($_FILES["foto"]["name"]))
                        echo "<span class='error'> * El archivo seleccionado no tiene extensión</span>";
                    elseif($_FILES["foto"]["size"]>500*1024)
                        echo "<span class='error'> * El archivo seleccionado no debe superar los 500KB</span>";
                    else
                        echo "<span class='error'> * El archivo seleccionado no es un archivo imagen</span>";

                }
            ?>
        </p>
        <p>
            <input type="checkbox" name="subscripcion" id="subscripcion" <?php if(isset($_POST["subscripcion"])) echo "checked";?>>
            <label for="subscripcion"> Suscribirme al boletín de novedades</label>
          
        </p>
        <p>
            <button type="submit" name="btnContRegistro">Guardar Cambios</button>
            <button type="submit" name="btnReset">Borrar los datos introducidos</button>
        </p>
    </form>
</body>
</html>