<?php
echo "<h2>Detalles del usuario: ".$_POST["btnDetalles"]."</h2>";
if($detalles_usuario)
{
    echo "<p>";
    echo "<strong>Nombre: </strong>".$detalles_usuario["nombre"]."<br>";
    echo "<strong>Usuario: </strong>".$detalles_usuario["usuario"]."<br>";
    echo "<strong>DNI: </strong>".$detalles_usuario["dni"]."<br>";
    echo "<strong>Sexo: </strong>".$detalles_usuario["sexo"]."<br>";
    echo "<strong>Subscrito al boletín: </strong>";
    if($detalles_usuario["subscripcion"])
        echo "Sí";
    else
        echo "No";
    echo "<br>";
    echo "<strong>Foto Actual: </strong><img class='foto_detalles' src='images/".$detalles_usuario["foto"]."' alt='Foto' title='Foto'>";
    echo "</p>";
}
else
    echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";

echo "<form action='index.php' method='post'><button>Volver</button></form>";
?>