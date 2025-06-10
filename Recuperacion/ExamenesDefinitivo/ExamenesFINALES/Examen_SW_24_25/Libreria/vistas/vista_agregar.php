<h2>Agregar un nuevo libro</h2>

<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="referencia">Referencia: </label>
        <input id="referencia" type="text" name="referencia" value="<?php if (isset($_POST['referencia'])) echo $_POST['referencia'] ?>">
        <?php
        if (isset($_POST['btnContAgregar']) && $error_referencia) {
            if ($_POST['referencia'] == "") {
                echo "<span class='error'>Rellene este campo por favor</span>";
            } else if (!is_numeric($_POST['referencia'])) {
                echo "<span class='error'>La referencia debe ser un número</span>";
            }  else if ($_POST['referencia'] < 0) {
                echo "<span class='error'>La referencia debe ser un número positivo</span>";
            } else {
                echo "<span class='error'>Esta referencia ya existe</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="titulo">Título: </label>
        <input id="titulo" type="text" name="titulo" value="<?php if (isset($_POST['titulo'])) echo $_POST['titulo'] ?>">
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
        <input id="autor" type="text" name="autor" value="<?php if (isset($_POST['autor'])) echo $_POST['autor'] ?>">
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
        <textarea name="descripcion" id="descripcion" col="50" rows="3"><?php if (isset($_POST['descripcion'])) echo $_POST['descripcion'] ?></textarea>
        <?php
        if (isset($_POST['btnContAgregar']) && $error_descripcion) {
            if ($_POST['descripcion'] == "") {
                echo "<span class='error'>Rellene este campo por favor</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="precio">Precio:</label>
        <input id="precio" type="text" name="precio" value="<?php if (isset($_POST['precio'])) echo $_POST['precio'] ?>">
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
        <input id="portada" type="file" name="portada" value="<?php if (isset($_FILES['portada'])) echo $_FILES['portada'] ?>">
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
        <button type="submit" name="btnContAgregar">Agregar</button>
    </p>
</form>