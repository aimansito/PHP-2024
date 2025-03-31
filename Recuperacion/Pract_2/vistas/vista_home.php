<?php
if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form_login=$error_usuario||$error_clave;
    if(!$error_form_login)
    {
        try{
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e)
        {
            session_destroy();
            die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido conectar a la base de batos: ".$e->getMessage()."</p>"));
            
        }
    
        try{
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["usuario"],md5($_POST["clave"])]);
    
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            session_destroy();
            die(error_page("Práctica 2 - Rec","<h1>Práctica 2 - Rec</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
            
        }
    
        if($sentencia->rowCount()>0)
        {
            $_SESSION["usuario"]=$_POST["usuario"];
            $_SESSION["clave"]=md5($_POST["clave"]);
            $_SESSION["ultm_accion"]=time();
            $sentencia=null;
            $conexion=null;
            header("Location:index.php");
            exit;
        }
        else
        {
            $error_usuario=true;
        }
        $sentencia=null;
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
        .error{color:red}
        .mensaje{color:blue;font-size:1.25em}
    </style>
</head>
<body>
    <h1>Práctica 2 - Rec</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnLogin"]) && $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> * Campo Vacío</span>";
                else
                    echo "<span class='error'> * Combinación de Usuario/Clave incorrecta</span>";

            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave"/>
            <?php
            if(isset($_POST["btnLogin"]) && $error_clave)
                echo "<span class='error'> * Campo Vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Entrar</button> 
            <button type="submit" name="btnRegistro">Registrarse</button> 
        </p>
    </form>
    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }
    ?>
</body>
</html>