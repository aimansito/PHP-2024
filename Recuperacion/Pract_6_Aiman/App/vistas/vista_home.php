<?php
    if(isset($_POST["btnLogin"])){
        $error_usuario=$_POST["usuario"]=="";
        $error_clave=$_POST["clave"]=="";
        $error_form_login=$error_usuario||$error_clave;
        if(!$error_form_login){
            $url=DIR_API."/login";
            $datos_env["usuario"]=$_POST["usuario"];
            $datos_env["clave"]=md5($_POST["clave"]);


            $respuesta=consumir_servicios_REST($url,"POST",$datos_env);
            $json_respuesta=json_decode($respuesta,true);
            if(!$json_respuesta){
                session_destroy();
                die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
            }
            if(isset($json_respuesta["error"])){
                session_destroy();
                die(error_page("Práctica 6 - Rec","<h1>Práctica 6 - Rec</h1><p>Error consumiendo el servicio REST <strong>".$url."</strong></p>"));
            }

            if(isset($json_respuesta["usuario"])){
                $_SESSION["token"]=$json_respuesta["token"];
                $_SESSION["ultm_accion"]=time();

                header("Location:index.php");
                exit;
            }else{
                $error_usuario=true;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error{color:red}
        .mensaje{color:blue;font-size:1.25em;}
    </style>
</head>
<body>
    <h1>Práctica 6 - Rec</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
            <?php
                if(isset($_POST["btnLogin"]) && $error_usuario){
                    if($_POST["usuario"]==""){
                        echo "<span class='error'>* Campo vacío </span>";
                    }else{
                        echo "<span class='error'>* El usuario o clave son incorrectos</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave" />
            <?php
                if(isset($_POST["btnLogin"])&& $error_clave){
                    echo "<span class='error'>*Campo vacío</span>";
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Entrar</button>
            <button type="submit" name="btnRegistro">Regístrarse</button>
        </p>
    </form>
    <?php
        if(isset($_SESSION["seguridad"])){
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
            session_destroy();
        }
    ?>
</body>
</html>