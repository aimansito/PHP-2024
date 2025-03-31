<?php

if(isset($_POST["btnDetalles"]))
{
    try{
        $consulta="select * from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnDetalles"]]);
        $detalles_usuario=$sentencia->fetch(PDO::FETCH_ASSOC);
        $sentencia=null;
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        session_destroy();
        die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        
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
            die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>".$error_usuario."</p>"));
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
    die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 2 - Rec</title>
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
        .foto_detalles{width:100px}
    </style>
</head>
<body>
    <h1>Práctica 2 - Rec</h1>
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
            echo "<strong>Subcrito al boletín: </strong>";
            if($detalles_usuario["subscripcion"])
                echo "Sí";
            else
                echo "No";
            echo "<br>";
            echo "<img class='foto_detalles' src='images/".$detalles_usuario["foto"]."' alt='Foto' title='Foto'>";
            echo "</p>";
        }
        else
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
       
        echo "<form action='index.php' method='post'><button>Volver</button></form>";

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
            echo "<td><img src='images/".$tupla["foto"]."' alt='Foto' title='Foto'></td>";
            echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalles' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
            echo "<td>Borrar - Editar</td>";
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