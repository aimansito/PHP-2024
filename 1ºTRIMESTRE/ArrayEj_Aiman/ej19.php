<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
          <?php
          /*$ciudades=array(
      
      "Madrid"=>array(
      "personas"=>array("nombre"=>array("Pedro","Antonio","Nacho"),
      "personas"=>array("edad"=>array("32","25","42")),
      "personas" => array("telefonos"=>array("4567","789456","13215")))
      
      ),
      "Barcelona"=>array(
      "personas"=>array("nombre"=>array("Susana"),
      "personas"=>array("edad"=>array("34")),
      "personas" => array("telefonos"=>array("13215")))
      
      ),
      
      "Valencia"=>array(
      "personas"=>array("nombre"=>array("Nombre","Nombre1","Nombre3"),
      "personas"=>array("edad"=>array("42","43","41")),
      "personas" => array("telefonos"=>array("98561","98742","78531")))
      
      ));
       */
       
      
      $ciudades = array(
          "Madrid" => array(
              "personas" => array(
                  array(
                      "nombre" => "Pedro",
                      "edad" => "32",
                      "telefonos" => "4567",
                  ),
                  array(
                      "nombre" => "Antonio",
                      "edad" => "25",
                      "telefonos" => "789456",
                  ),
                  array(
                      "nombre" => "Nacho",
                      "edad" => "42",
                      "telefonos" => "13215",
                  ),
              ),
          ),
          "Barcelona" => array(
              "personas" => array(
                  array(
                      "nombre" => "Susana",
                      "edad" => "34",
                      "telefonos" => "13215",
                  ),
              ),
          ),
          "Valencia" => array(
              "personas" => array(
                  array(
                      "nombre" => "Nombre",
                      "edad" => "42",
                      "telefonos" => "98561",
                  ),
                  array(
                      "nombre" => "Nombre1",
                      "edad" => "43",
                      "telefonos" => "98742",
                  ),
                  array(
                      "nombre" => "Nombre3",
                      "edad" => "41",
                      "telefonos" => "78531",
                  ),
              ),
          ),
      );
      
      foreach ($ciudades as $ciudad => $datosCiudad) {
         // echo "<ul>";
          echo "<ol>";
         
          echo "Amigos en " . $ciudad . " :<br><br>";
          foreach ($datosCiudad["personas"] as $persona) {
              echo "<li>";
              echo "Nombre: " . $persona["nombre"];
              echo " Edad: " . $persona["edad"];
              echo " Teléfono: " . $persona["telefonos"] . "<br>";
              echo "</li>";
          }
          echo "</ol>";
         // echo "</ul>";
      }
      
      ?>
    ?>
</body>
</html>