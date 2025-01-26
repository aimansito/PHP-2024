<h2>Listado de los libros</h2>
<div class="contenedor_libros">
<?php
while($tupla=mysqli_fetch_assoc($result_libros))
{
    echo "<div>";
    echo "<img src='Images/".$tupla["portada"]."' alt='Portada' title='Portada'/><br/>";
    echo $tupla["titulo"]." - ".$tupla["precio"]."€";
    echo "</div>";
}
mysqli_free_result($result_libros);
?>
</div>