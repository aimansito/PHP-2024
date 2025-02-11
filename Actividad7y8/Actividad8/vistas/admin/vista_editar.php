<?php
if(isset($_POST["btnEditar"]))
{
    if(isset($json_detalles["usuario"]))
    {
        $nombre=$json_detalles["usuario"]["nombre"];
        $usuario=$json_detalles["usuario"]["usuario"];
        $email=$json_detalles["usuario"]["email"];
        $id_usuario=$_POST["btnEditar"];
    }
    else
        die("<h2>Editando el usuario ".$_POST["btnDetalles"]."</h2><p>El usuario seleccionado ya no se encuentra en la BD</p></body></html>");
}
else
{
    $nombre=$_POST["nombre"];
    $usuario=$_POST["usuario"];
    $email=$_POST["email"];
    $id_usuario=$_POST["btnContEditar"];

}
?>
<h2>Editando el usuario <?php echo $id_usuario;?></h2>
<form action="index.php" method="post">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>"/>
        <?php
        if(isset($_POST["btnContEditar"]) && $error_nombre)
        {
            echo "<span class='error'>* Campo vacío *</span>";
        }
        ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>
        <?php
        if(isset($_POST["btnContEditar"]) && $error_usuario)
        {
            if($_POST["usuario"]=="")
                echo "<span class='error'>* Campo vacío *</span>";
            else
                echo "<span class='error'>* Usuario repetido *</span>";
        }
        ?>
    </p>  
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" placeholder="Cambiar clave" id="clave" value=""/>
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email"  value="<?php echo $email;?>"/>
        <?php
        if(isset($_POST["btnContEditar"]) && $error_email)
        {
            if($_POST["email"]=="")
                echo "<span class='error'>* Campo vacío *</span>";
            elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                echo "<span class='error'>* Email sintácticamente incorrecto *</span>";
            else
                echo "<span class='error'>* Email repetido *</span>";
        }
        ?>
    </p>
    <p>
        <button type="submit" name="btnContEditar" value="<?php echo $id_usuario;?>">Continuar</button> 
        <button type="submit">Atrás</button>
    </p>    
</form>
