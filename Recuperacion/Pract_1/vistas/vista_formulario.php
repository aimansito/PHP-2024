<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <h2>RELLENA TU CV</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre: </label></br>
        <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/> </br>
        <?php
            if(isset($_POST["btnEnviar"]) && $error_nombre){
                echo "<span class='error'>* Campo vacío </span>";
            }
        ?>


        <label for="apellidos">Apellidos: </label></br>
        <input type="text" name="apellidos" size="50" id="apellidos" value="<?php if(isset($_POST["apellidos"])) echo $_POST["apellidos"];?>"></br>
        <?php
            if(isset($_POST["btnEnviar"]) && $error_apellidos){
                echo "<span class='error'>* Campo vacío </span>";
            }
        ?>


        <label for="clave">Contraseña: </label></br>
        <input type="password" name="clave" id="clave"></br>
        <?php
            if(isset($_POST["btnEnviar"]) && $error_clave){
                echo "<span class='error'>*Campo Vacío</span>";
            }
        ?>
        
        <label for="dni">DNI</label></br>
        <input type="text" name="dni" size="10" id="dni" value="<?php if(isset($dni)) echo $dni?>"></br>
        <?php
            if(isset($_POST["btnEnviar"]) && $error_dni){
                if($dni == ""){
                    echo "<span class='error'>*Campo vacío</span>";
                }else if(!dni_bien_escrito($dni)){
                    echo "<span class='error'>* El dni esta mal escrito</span>";
                }else{
                    echo "<span class='error'>DNI inválido</span>";
                }
            }
        ?>


        <label for="sexo">Sexo</label></br>
        <input type="radio" name="sexo" id="hombre" value="hombre" checked>
        <label for="hombre">Hombre</label></br>
        <input type="radio" name="sexo" id="mujer" value="mujer">
        <label for="mujer">Mujer</label></br>

        <label for="foto">Incluir mi foto: </label></br>
        <input type="file" name="foto" id="foto" accept="image/*"></br></br>
        <?php
            if (isset($_POST["btnEnviar"]) && $error_foto) {
                if ($_FILES["foto"]["error"]) {
                    echo "<span class='error'> * Se ha producido un error en la subida del archivo al servidor</span>";
                } elseif (!tiene_extension($_FILES["foto"]["name"])) {
                    echo "<span class='error'> * El archivo seleccionado no tiene extensión</span>";
                } elseif ($_FILES["foto"]["size"] > 500 * 1024) {
                    echo "<span class='error'> * El archivo seleccionado supera el tamaño permitido</span>";
                } else {
                    echo "<span class='error'> * No es una imagen</span>";
                }
            }
            
        ?>

        <input type="checkbox" name="subscripcion" id="subscripcion" <?php  if(isset($_POST["subscripcion"])) echo "checked";?>/>
        <label for="sub">Subscribirse al boletín de novedades</label></br>
        <?php  
            if(isset($_POST["btnEnviar"]) && $error_subscripcion){
                echo "<span class='error'> * Se ha producido un error en la subida del archivo al servidor</span>";
            }
        ?>
        </br>
        <input type="submit" name="btnEnviar" value="Guardar Cambios">
        <input type="submit" name="btnBorrar" value="Borrar los datos introducidos">
    </form>
</body>
</html>