<h3>Listado de los Usuarios</h3>
    <table class="tabla_alumnos">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th><form action="index.php" method="post"><button name="btnAgregar" class="enlace">Usuario+</button></form></th>
        </tr>
        <?php
        foreach($usuarios as $tupla)
        {
            echo "<tr>";
            echo "<td>".$tupla["id_usuario"]."</td>";
            if($tupla["foto"]==NOMBRE_FOTO_DEFECTO_BD)
                echo "<td><img src='images/".$tupla["foto"]."' alt='Foto' title='Foto'></td>";
            else
            {
                echo "<td><form action='index.php' method='post'><input type='hidden' name='foto_bd' value='".$tupla["foto"]."'><button class='foto_click' name='btnBorrarFoto' value='".$tupla["id_usuario"]."'><img src='images/".$tupla["foto"]."' alt='Foto' title='Borrar Imagen'></button></form></td>";
            }
            echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalles' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><button class='enlace' name='btnBorrar' value='".$tupla["id_usuario"]."'>Borrar</button> - <form action='index.php' method='post'><button class='enlace' name='btnEditar' value='".$tupla["id_usuario"]."'>Editar</button></form></td>";
            echo "</tr>";
        }
        ?>
    </table>