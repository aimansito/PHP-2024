<?php

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
        $inconsistencia=true;
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
if(isset($inconsistencia))
{
    echo "<p>El usuario ya no se encuentra en la BD</p><form action='index.php' method='post'><button>Volver</button></form>";
}
else
{
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
?>