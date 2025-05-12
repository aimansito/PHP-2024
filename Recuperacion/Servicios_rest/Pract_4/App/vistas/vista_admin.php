<?php
if(isset($_POST["btnContBorrar"]))
{
    try{
        $consulta="delete from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }

    if($_POST["foto"]!=NOMBRE_FOTO_DEFECTO_BD && file_exists("images/".$_POST["foto"]))
        unlink("images/".$_POST["foto"]);
    
    

    $_SESSION["mensaje_accion"]="Usuario eliminado con éxito";
    $conexion=null;
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnContBorrarFoto"]))
{
    try{
        $consulta="update usuarios set foto=? where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([NOMBRE_FOTO_DEFECTO_BD,$_POST["btnContBorrarFoto"]]);
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }

    if(file_exists("images/".$_POST["foto_bd"]))
        unlink("images/".$_POST["foto_bd"]);

    $_SESSION["mensaje_accion"]="Foto de Perfil borrada con éxito";
    $conexion=null;
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

    try{
        $consulta="select * from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        $detalles_usuario=$sentencia->fetch(PDO::FETCH_ASSOC);
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        
    }
}

if(isset($_POST["btnContEditar"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
       
        $error_usuario=repetido_editando($conexion,"usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["btnContEditar"]);
        if(is_string($error_usuario))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$error_usuario."</p>"));
        }
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"])|| !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $error_dni=repetido_editando($conexion,"usuarios","dni",strtoupper($_POST["dni"]),"id_usuario",$_POST["btnContEditar"]);
        if(is_string($error_dni))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$error_dni."</p>"));
        }
    }
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !tiene_extension($_FILES["foto"]["name"]) || $_FILES["foto"]["size"]>500*1024 || !getimagesize($_FILES["foto"]["tmp_name"]));

    $error_form=$error_usuario||$error_nombre||$error_dni||$error_foto;
    if(!$error_form)
    {
        //edito, logueo y salto 

        $subs=0;
        if(isset($_POST["subscripcion"]))
            $subs=1;

        if($_POST["clave"]=="")
        {
            $consulta="update usuarios set usuario=?, nombre=?,dni=?, sexo=?, subscripcion=?, foto=? where id_usuario=?";
            $datos_consulta=[$_POST["usuario"],$_POST["nombre"],strtoupper($_POST["dni"]),$_POST["sexo"],$subs,$_POST["foto_bd"],$_POST["btnContEditar"]];
        }
        else
        {
            $consulta="update usuarios set usuario=?, nombre=?, clave=?, dni=?, sexo=?, subscripcion=?, foto=? where id_usuario=?";
            $datos_consulta=[$_POST["usuario"],$_POST["nombre"],md5($_POST["clave"]),strtoupper($_POST["dni"]),$_POST["sexo"],$subs,$_POST["foto_bd"],$_POST["btnContEditar"]];
        }

        try{

            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos_consulta);
           
        }
        catch(PDOException $e)
        {
            session_destroy();
            $sentencia=null;
            $conexion=null;
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
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
                 
                    try{

                        $consulta="update usuarios set foto=? where id_usuario=?";
                        $sentencia=$conexion->prepare($consulta);
                        $sentencia->execute([$nombre_unico,$_POST["btnContEditar"]]);
                        if($_POST["foto_bd"]!=NOMBRE_FOTO_DEFECTO_BD && file_exists("images/".$_POST["foto_bd"]))
                            unlink("images/".$_POST["foto_bd"]);
                    
                    }
                    catch(PDOException $e)
                    {
                        if(file_exists("images/".$nombre_unico))
                            unlink("images/".$nombre_unico);

                        $_SESSION["mensaje_accion"]="Usuario editado con éxito, pero con la imagen por defecto por un error en la actualización en la BD";
                    }
                    $sentencia=null;
                }
            }
            else
            {
                $_SESSION["mensaje_accion"]="Usuario editado con éxito, pero con la imagen por defecto por no poder mover imagen subida a la carpeta destino";
            }
        }

     
        $conexion=null;
        header("Location:index.php");
        exit;


    }
}


if(isset($_POST["btnContRegistro"]))
{
    $error_usuario=$_POST["usuario"]=="";
    if(!$error_usuario)
    {
       
        $error_usuario=repetido_insert($conexion,"usuarios","usuario",$_POST["usuario"]);
        if(is_string($error_usuario))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$error_usuario."</p>"));
        }
    }
    $error_nombre=$_POST["nombre"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($_POST["dni"])|| !dni_valido($_POST["dni"]);
    if(!$error_dni)
    {
        $error_dni=repetido_insert($conexion,"usuarios","dni",strtoupper($_POST["dni"]));
        if(is_string($error_dni))
        {
            session_destroy();
            $conexion=null;
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>".$error_dni."</p>"));
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
            die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }
        
        $_SESSION["mensaje_accion"]="Usuario registrado con éxito";
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

                    $_SESSION["mensaje_accion"]="Usuario registrado con éxito, pero con la imagen por defecto por un error en la actualización en la BD";
                }
                $sentencia=null;
            }
            else
            {
                $_SESSION["mensaje_accion"]="Usuario registrado con éxito, pero con la imagen por defecto por no poder mover imagen subida a la carpeta destino";
            }
        }

     
        $conexion=null;
        header("Location:index.php");
        exit;

    }



}






try{
    $consulta="select * from usuarios where tipo<>'admin'";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
    $usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia=null;
}
catch(PDOException $e)
{
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die(error_page("Práctica 4 - Rec","<h1>Práctica 4 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    
}



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4 - Rec</title>
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
    <h1>Práctica 4 - Rec</h1>
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
        echo "<h2>Detalles del usuario: ".$_POST["btnDetalles"]."</h2>";
        if($detalles_usuario)
        {
            echo "<p>";
            echo "<strong>Nombre: </strong>".$detalles_usuario["nombre"]."<br>";
            echo "<strong>Usuario: </strong>".$detalles_usuario["usuario"]."<br>";
            echo "<strong>DNI: </strong>".$detalles_usuario["dni"]."<br>";
            echo "<strong>Sexo: </strong>".$detalles_usuario["sexo"]."<br>";
            echo "<strong>Subscrito al boletín: </strong>";
            if($detalles_usuario["subscripcion"])
                echo "Sí";
            else
                echo "No";
            echo "<br>";
            echo "<strong>Foto Actual: </strong><img class='foto_detalles' src='images/".$detalles_usuario["foto"]."' alt='Foto' title='Foto'>";
            echo "</p>";
        }
        else
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
       
        echo "<form action='index.php' method='post'><button>Volver</button></form>";

    }

    if(isset($_POST["btnBorrar"]))
    {
        echo "<h2 class='form_confirmar'>Borrado del usuario: ".$_POST["btnBorrar"]."</h2>";
        if($detalles_usuario)
        {
            echo "<form class='form_confirmar' action='index.php' method='post'>";
            echo "<p>¿ Estás seguro que desea eliminar al usuario <strong>".$detalles_usuario["nombre"]."</strong>?</p>";
            echo "<input type='hidden' name='foto' value='".$detalles_usuario["foto"]."'>";
            echo "<p><button name='btnContBorrar' value='".$detalles_usuario["id_usuario"]."'>Sí</button> <button>No</button></p>";
            echo "</form>";
        }
        else
        {
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
            echo "<form action='index.php' method='post'><button>Volver</button></form>";
        }

    }


    if(isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]))
    {

        if(isset($_POST["btnEditar"]))
        {
            echo "<h2>Editando el usuario con id: ".$_POST["btnEditar"]."</h2>";
            if($detalles_usuario)
            {
                $id_usuario=$detalles_usuario["id_usuario"];
                $usuario=$detalles_usuario["usuario"];
                $nombre=$detalles_usuario["nombre"];
                $dni=$detalles_usuario["dni"];
                $foto_bd=$detalles_usuario["foto"];
                $sexo=$detalles_usuario["sexo"];
                $subs=$detalles_usuario["subscripcion"];
            }
            else
            {
                die("<p>El usuario ya no se encuentra en la BD</p><form action='index.php' method='post'><button>Volver</button></form>");
            }
        }
        else
        {
            echo "<h2>Editando el usuario con id: ".$_POST["btnContEditar"]."</h2>";
            $id_usuario=$_POST["btnContEditar"];
            $usuario=$_POST["usuario"];
            $nombre=$_POST["nombre"];
            $dni=$_POST["dni"];
            $foto_bd=$_POST["foto_bd"];
            $sexo=$_POST["sexo"];
            $subs=0;
            if(isset($_POST["subscripcion"]))
                $subs=1;
        }
        ?>
        
        <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario:</label><br>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario..." value="<?php echo $usuario;?>">
            <?php
            if(isset($_POST["btnContEditar"]) && $error_usuario)
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
            <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php echo $nombre;?>">
            <?php
            if(isset($_POST["btnContEditar"]) && $error_nombre)
                echo "<span class='error'> * Campo vacío</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label><br>
            <input type="password" name="clave" id="clave" placeholder="Teclee nueva contraseña...">
          
        </p>
        <p>
            <label for="dni">DNI:</label><br>
            <input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z" value="<?php echo $dni;?>">
            <?php
            if(isset($_POST["btnContEditar"]) && $error_dni)
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
            <input type="radio" name="sexo" value="hombre" id="hombre" <?php if($sexo=="hombre") echo "checked";?>>
            <label for="hombre"> Hombre</label><br>
            <input type="radio" name="sexo" value="mujer" id="mujer" <?php if($sexo=="mujer") echo "checked";?>>
            <label for="mujer"> Mujer</label>
        </p>
        <p>
        Foto Actual: </strong><img class='foto_detalles' src='images/<?php echo $foto_bd;?>' alt='Foto' title='Foto'>
        
        </p>
        <p>
            <label for="foto">Cambiar mi foto (Máx 500KB):</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php
                if(isset($_POST["btnContEditar"]) && $error_foto)
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
            <input type="checkbox" name="subscripcion" id="subscripcion" <?php if(isset($subs)) echo "checked";?>>
            <label for="subscripcion"> Suscribirme al boletín de novedades</label>
        
        </p>
        <p>
            <input type="hidden" name="foto_bd" value="<?php echo $foto_bd?>">
            <button type="submit" name="btnContEditar" value="<?php echo $id_usuario;?>">Guardar Cambios</button>
            <button type="submit">Atrás</button>
        </p>
    </form>



    <?php
    }

    if(isset($_POST["btnBorrarFoto"]))
    {
        echo "<h3>Borrando la foto del usuario: ".$_POST["btnBorrarFoto"]."</h3>";
        echo "<form action='index.php' method='post'>";
        echo "<p><img src='images/".$_POST["foto_bd"]."' alt='Foto' title='Foto'></p>";
        echo "<input type='hidden' name='foto_bd' value='".$_POST["foto_bd"]."'>";
        echo "<p><button name='btnContBorrarFoto' value='".$_POST["btnBorrarFoto"]."'>Continuar</button> <button>Atrás</button>";
        echo "</form>";
    }
    ?>

    <h3>Listado de los Usuarios</h3>
    <table class="tabla_alumnos">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th><form action="index.php" method="post"><button name="btnAgregar" class="enlace">Usuario+</button></form></th>
        </tr>
        <?php
        foreach($usuarios as $tupla)
        {
            echo "<tr>";
            echo "<td>".$tupla["id_usuario"]."</td>";
            if($tupla["foto"]==NOMBRE_FOTO_DEFECTO_BD)
                echo "<td><img src='images/".$tupla["foto"]."' alt='Foto' title='Foto'></td>";
            else
            {
                echo "<td><form action='index.php' method='post'><input type='hidden' name='foto_bd' value='".$tupla["foto"]."'><button class='foto_click' name='btnBorrarFoto' value='".$tupla["id_usuario"]."'><img src='images/".$tupla["foto"]."' alt='Foto' title='Borrar Imagen'></button></form></td>";
            }
            echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalles' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><button class='enlace' name='btnBorrar' value='".$tupla["id_usuario"]."'>Borrar</button> - <form action='index.php' method='post'><button class='enlace' name='btnEditar' value='".$tupla["id_usuario"]."'>Editar</button></form></td>";
            echo "</tr>";
        }
        ?>
    </table>

   

    <?php
    if(isset($_SESSION["mensaje_accion"]))
    {
        echo "<p class='mensaje'>¡¡¡ ".$_SESSION["mensaje_accion"]." !!!</p>";
        unset($_SESSION["mensaje_accion"]);
    }
    ?>
</body>
</html>