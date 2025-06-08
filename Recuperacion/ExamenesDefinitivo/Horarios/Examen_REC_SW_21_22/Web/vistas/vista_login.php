<?php
    if(isset($_POST["btnLogin"])){
        $error_usuario=$_POST["usuario"]=="";
        $error_clave=$_POST["clave"]=="";
        $error_form_login = $error_usuario || $error_clave;
        if(!$error_form_login){
            $url=DIR_SERV."/login";
            $datos_login["usuario"]=$_POST["usuario"];
            $datos_login["clave"]=md5($_POST["clave"]);
            $respuesta=consumir_servicios_REST($url,"POST",$datos_login);
            $json_login=(json_decode($respuesta,true));
            if(!$json_login){
                session_destroy();
                die(error_page("Examen5 PHP","<h1>Examen5 PHP</h1><p>Error consumiendo el servicio: ".$url."</p>".$respuesta ));
            }
            if(isset($json_login["error"])){
                session_destroy();
                die(error_page("Examen Final PHP", "<h1>Examen Final PHP</h1><p>".$json_login["error"]."</p>"));
            }
            if(isset($json_login["mensaje"])){
                $error_usuario=true;
            }else{
                $_SESSION["token"]=$json_login["token"];
                $_SESSION["ultm_accion"]=time();
                header("Location:index.php");
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen horarios</title>
    <style>
        .error{
            color: red;
        }
        .mensaje{
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Examen Horarios</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>">
            <?php
                if(isset($_POST["btnLogin"]) && $error_usuario){
                    if($_POST["usuario"]==""){
                        echo "<span class='error'>* Campo vacío</span>";
                    }else{
                        echo "<span class='error'>* Usuario y/o contraseña incorrectas".$json_login["mensaje"]."</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
                if(isset($_POST["btnLogin"]) && $error_clave){
                    echo "<span class='error'>* Campo vacío</span>";
                }
            ?>
        </p>
        <p>
            <button name="btnLogin">Login</button>
        </p>
    </form>
    <?php
        if(isset($_SESSION["mensaje_seguridad"])){
            echo "<p class='mensaje'>".$_SESSION["mensaje_seguridad"]."</p>";
            unset($_SESSION["mensaje_seguridad"]);
        }
    ?>
</body>
</html>