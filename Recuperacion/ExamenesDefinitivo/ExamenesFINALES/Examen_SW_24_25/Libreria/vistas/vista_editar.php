<?php 
echo "<h2>Editando el libro ".$json_detalles['libro']['referencia']."</h2>";
?>

<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="titulo">Título: </label>
        <input id="titulo" type="text" name="titulo" value="<?php if(isset($_POST['titulo'])) echo $_POST['titulo']; else echo $json_detalles['libro']['titulo'] ?>">
        <?php
        if (isset($_POST['btnContAgregar']) && $error_titulo) {
            if ($_POST['titulo'] == "") {
                echo "<span class='error'>Rellene este campo por favor</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="autor">Autor: </label>
        <input id="autor" type="text" name="autor" value="<?php if(isset($_POST['autor'])) echo $_POST['autor']; else echo $json_detalles['libro']['autor']  ?>">
        <?php
        if (isset($_POST['btnContAgregar']) && $error_autor) {
            if ($_POST['autor'] == "") {
                echo "<span class='error'>Rellene este campo por favor</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="descripcion">Descripción: </label>
        <textarea name="descripcion" id="descripcion" col="50" rows="3" ><?php  if(isset($_POST['descripcion'])) echo $_POST['descripcion']; else echo $json_detalles['libro']['descripcion']  ?></textarea>
        <?php
        if (isset($_POST['btnContAgregar']) && $error_descripcion) {
            if ($_POST['autor'] == "") {
                echo "<span class='error'>Rellene este campo por favor</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="precio">Precio:</label>
        <input id="precio" type="text" name="precio" value="<?php if(isset($_POST['precio'])) echo $_POST['precio']; else echo $json_detalles['libro']['precio']  ?>">
        <?php
        if (isset($_POST['btnContAgregar']) && $error_precio) {
            if ($_POST['precio'] == "") {
                echo "<span class='error'>Rellene este campo por favor</span>";
            } else if (!is_numeric($_POST['precio'])) {
                echo "<span class='error'>La referencia debe ser un número</span>";
            } else {
                echo "<span class='error'>El precio debe ser positivo</span>";
            }  
        }
        ?>
    </p>
    <p>
        <label for="portada"></label>
        <input id="portada" type="file" name="portada" value="<?php if(isset($_FILES['portada'])) echo $_FILES['portada']; else echo $json_detalles['libro']['portada']  ?>">
        <?php
        if (isset($_POST['btnContAgregar']) && isset($error_portada)) {
            if(!getimagesize($_FILES['portada']['tmp_name'])){
                echo "<span class='error'>La portada debe ser una imagen</span>";
            }
            else if ($_FILES['portada']['error']) {
                echo "<span class='error'>Error con la portada</span>";
            }
            else;
                echo "<span class='error'>La imagen debe ser menor de 500KB</span>";
        }
        ?>
    </p>
    <p>
        <?php echo "<button type='submit' name='btnContEditar' value='".$_POST['btnEditar']."'>Editar</button>"; ?>
    </p>
</form>