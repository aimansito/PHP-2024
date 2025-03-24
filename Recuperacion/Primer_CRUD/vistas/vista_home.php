<?php
    if(isset($_POST["btnLogin"])){
        $error_usuario=$_POST["usuario"]=="";
        $error_clave=$_POST["clave"]=="";
        $error_form_login = $error_usuario || $error_clave;
        if(!$error_form_login){
            
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
                return $respuesta;
            }
            try {
                $consulta = "select * from usuarios";
                $sentencia = $conexion->prepare($consulta);
                $sentencia->execute([$_POST["usuario"]],md5($_POST["clave"]));
            } catch (PDOException $e) {
                $sentencia = null;
                $conexion = null;
                $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
                return $respuesta;
            }

            if($sentencia->rowCount()>0){
                $_SESSION["usuario"]=$_POST["usuario"];
                $_SESSION["usuario"]=md5($_POST["clave"]);
                $_SESSION["ultm_accion"]=time();
                $sentencia = null;
                $conexion = null;
                header("Location:index.php");
                exit;
            }else{
                $error_usuario=true;
            }

            return $respuesta;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <h1>Práctica 2-Rec</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ;?>">      
            <?php
                if(isset($_POST["btnLogin"]) && $error_usuarios){
                    if($_POST["usuario"]==""){
                        echo "<span class='error'>*Campo obligatorio</span>";
                    }else{
                        echo "<span class='error'>*No se encuentra en la BD este usuario</span>";
                    }
                }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" >
            <?php
                 if(isset($_POST["btnLogin"]) && $error_clave){
                    if($_POST["usuario"]==""){
                        echo "<span class='error'>*Campo obligatorio</span>";
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Entrar</button>
            <button type="submit" name="btnRegistro">Registrarse</button>
        </p>
    </form>
</body>
</html>