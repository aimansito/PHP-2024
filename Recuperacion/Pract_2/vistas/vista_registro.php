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
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e)
        {
            session_destroy();
            die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido conectar a la base de batos: ".$e->getMessage()."</p>"));
        }
        $error_usuario=repetido_insert($conexion,"usuarios","usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>".$error_usuario."</p>"));
        }
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"])|| !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        if(!isset($conexion))
        {
            try{
                $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            }
            catch(PDOException $e)
            {
                session_destroy();
                die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido conectar a la base de batos: ".$e->getMessage()."</p>"));
            }
        }
        $error_dni=repetido_insert($conexion,"usuarios","dni",strtoupper($_POST["dni"]));
        if(is_string($error_dni))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>".$error_dni."</p>"));
        }
    }
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || $_FILES["foto"]["size"]>500*1024 || !getimagesize($_FILES["foto"]["tmp_name"]));

    $error_form=$error_usuario||$error_nombre||$error_clave||$error_dni||$error_foto;
    if(!$error_form)
    {
        //inserto, logueo y salto 

        $subs=0;
        if(isset($_POST["subscripcion"]))
            $subs=1;

        try{

            $consulta="insert into usuarios (usuario,nombre,clave,dni,sexo,subscripcion) values (?,?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["usuario"],$_POST["nombre"],md5($_POST["clave"]),strtoupper($_POST["dni"]),$_POST["sexo"],$subs]);
           
        }
        catch(PDOException $e)
        {
            session_destroy();
            $sentencia=null;
            $conexion=null;
            die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }
        
        $_SESSION["mensaje_registro"]="Usuario registrado con éxito";
        if($_FILES["foto"]["name"]!="")
        {
            $ultm_id=$conexion->lastInsertId();
            $ext=tiene_extension($_FILES["foto"]["name"]);
            $nombre_unico="img_".$ultm_id.".".$ext;
            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"images/".$nombre_unico);
            if($var)
            {
                try{

                    $consulta="update usuarios set foto=? where id_usuario=?";
                    $sentencia=$conexion->prepare($consulta);
                    $sentencia->execute([$nombre_unico,$ultm_id]);
                   
                }
                catch(PDOException $e)
                {
                    if(file_exists("images/".$nombre_unico))
                        unlink("images/".$nombre_unico);

                    $_SESSION["mensaje_registro"]="Usuario registrado con éxito, pero con la imagen por defecto por un error en la actualización en la BD";
                }
                $sentencia=null;
            }
            else
            {
                $_SESSION["mensaje_registro"]="Usuario registrado con éxito, pero con la imagen por defecto por no poder mover imagen subida a la carpeta destino";
            }
        }

        //logueo
        $_SESSION["usuario"]=$_POST["usuario"];
        $_SESSION["clave"]=md5($_POST["clave"]);
        $_SESSION["ultm_accion"]=time();
        $conexion=null;
        header("Location:index.php");
        exit;

    }


    if(isset($conexion))
    {
        $conexion=null;
    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 2 - Rec</title>
    <style>
        .error{
            color:red
        }
    </style>
</head>
<body>
    <h1>Práctica 2 - Rec</h1>
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