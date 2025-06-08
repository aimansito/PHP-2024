<?php
    echo "<h2>Editando el libro".$json_detalles['libro']['referencia']."</h2>";
?>

<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="titulo" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"]; else echo $json_detalles['libro']['titulo'];?>">
        <?php
            if(isset($_POST['btnContAgregar']) && $error_titulo){
                if($_POST['titulo']==""){
                    echo "<span class='error'>Rellene este campo por favor</span>";
                }
            }
        ?>
    </p>
        <p>
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" value="<?php if(isset($_POST["autor"])) echo $_POST["autor"]; else echo $json_detalles['libro']['autor'];?>">
        <?php
            if(isset($_POST['btnContAgregar']) && $error_titulo){
                if($_POST['autor']==""){
                    echo "<span class='error'>Rellene este campo por favor</span>";
                }
            }
        ?>
    </p>
        <p>
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" value="<?php if(isset($_POST["descripcion"])) echo $_POST["descripcion"]; else echo $json_detalles['libro']['descripcion'];?>">
        <?php
            if(isset($_POST['btnContAgregar']) && $error_titulo){
                if($_POST['descripcion']==""){
                    echo "<span class='error'>Rellene este campo por favor</span>";
                }
            }
        ?>
    </p>
    <p>
        <label for="precio">Precio: </label>
        <input type="text" id="precio" name="precio" value="<?php if(isset($_POST["precio"])) echo $_POST["precio"]; else echo $json_detalles["libro"]["precio"];?>">
        <?php
        if(isset($_POST['btnContAgregar']) && $error_precio){
            if($_POST['precio']==""){
                echo "<span class='error'>Rellene este campo por favor</span>";
            }else if(!is_numeric($_POST["precio"])){
                echo "<span class='error'>La referencia debe ser un número</span>";
            }else{
                echo "<span class='error'>El precio debe ser positivo</span>";
            }
        }
        ?>
    </p>
    <p>
        <?php echo "<button type='submit' name='btnContEditar' value='".$_POST['btnEditar']."'>Editar</button>";?>
    </p>
</form>