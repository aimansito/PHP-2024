<?php
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
?>