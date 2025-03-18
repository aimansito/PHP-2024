<h1>Esta es mi super pagina</h1>
    <form action ="index.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value=" "/>
            <?php
            if(isset($_POST[enviar]) && $error_nombre){
                echo "<span class='error'>*Campo Obligatorio*</span>";
            }
            ?>
        </p>
        <p>
            <label for="nacido">Nacido: </label>
            <select name="nacido" id="nacido">
                <option value="Málaga">Málaga</option>
                <option value="Granada">Granada</option>
                <option value="Almería">Almería</option>
            </select>            
        </p>
        <p>
            Sexo: <label for="hombre">Hombre </label>
            <input type="radio" name="sexo" value="hombre" id="hombre" <?php if(isset($_POST["sexo"]=="hombre")) echo "checked" ?>/>
            <label for="mujer">Mujer </label>
            <input type="radio" name="sexo" value="mujer" id="mujer" <?php if(isset($_POST["sexo"]=="hombre")) echo "checked" ?> >
            <?php
            if(isset($_POST[enviar]) && $error_nombre){
                echo "<span class='error'>*Campo Obligatorio*</span>";
            }
            ?>
        </p>
        <p>
            Aficiones: 
            <label for="deportes">Deportes: </label>
            <input type="checkbox" name="aficiones[]" value="deportes" id="deportes" <?php if(isset($_POST["aficiones"]) && arrayNom("Deportes". $_POST(["aficiones"]) echo "checked") ?>/>
            <label for="deportes">Lectura: </label>
            <input type="checkbox" name="aficiones[]" value="lectura" id="lectura"/>
            <label for="deportes">Otros: </label>
            <input type="checkbox" name="aficiones[]" value="otros" id="otros"/>
        </p>
        <p>
            <label for="comentarios">Comentarios: </label>
            <textarea name="comentarios" id="comentarios">
            <?php
            if(isset($_POST[enviar]) && $error_nombre){
                echo "<span class='error'>*Campo Obligatorio*</span>";
            }
            ?>
            </textarea>
        </p>
        <p>
            <input type="submit" name="enviar" value="Enviar"></input>
        </p>
    </form>