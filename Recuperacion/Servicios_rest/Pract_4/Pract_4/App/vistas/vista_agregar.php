<?php
if(isset($_POST["btnReset"]))
{
    unset($_POST);
}
?>
 <h2>Agregar Nuevo usuario</h2>
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
