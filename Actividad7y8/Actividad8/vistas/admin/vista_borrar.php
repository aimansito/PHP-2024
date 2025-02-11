<?php
echo "<h2>Borrado del usuario ".$_POST["btnBorrar"]."</h2>";
if(isset($json_detalles["usuario"]))
{
    echo "<p>¿Estás seguro que quires borrar al usuario <strong>".$json_detalles["usuario"]["nombre"]."</strong>?</p>";
    echo "<form action='index.php' method='post'>";
    echo "<button type='submit' value='".$json_detalles["usuario"]["id_usuario"]."' name='btnContBorrar'>Continuar</button> ";
    echo " <button type='submit'>Atrás</button>";
    echo "</form>";
}
else
{
    echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
}
?>