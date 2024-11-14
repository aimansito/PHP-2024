<?php
echo "<h3>Listado de los usuarios</h3>";
echo "<table>";
echo "<tr>";
echo "<th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button type='submit' name='btnAgregar' class='enlace'>Usuario+</button></form></th>";
echo "</tr>";
while($tupla_datos_usuario=mysqli_fetch_assoc($result_datos_usuarios))
{
    echo "<tr>";
    echo "<td>".$tupla_datos_usuario["id_usuario"]."</td>";
    echo "<td><img src='Img/".$tupla_datos_usuario["foto"]."' alt='Foto' title='Foto'/></td>";
    echo "<td>";
    echo "<form action='index.php' method='post'><button title='Pulse para ver detalles' class='enlace' name='btnDetalles' value='".$tupla_datos_usuario["id_usuario"]."' type='submit' >".$tupla_datos_usuario["nombre"]."</button></form>";
    echo "</td>";
    echo "<td><form action='index.php' method='post'><input name='id_usuario' type='hidden' value='".$tupla_datos_usuario["id_usuario"]."'/><button class='enlace' type='submit' name='btnBorrar'>Borrar</button> - <button class='enlace' type='submit' name='btnEditar'>Editar</button></form></td>";
    echo "</tr>";
}
echo "</table>";
?>