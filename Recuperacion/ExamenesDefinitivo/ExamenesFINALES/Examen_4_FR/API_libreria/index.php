<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app = new \Slim\App;

$app->get('/logueado', function () {

    $test = validateToken();
    if (is_array($test)) {
        echo json_encode($test);
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});


$app->post('/login', function ($request) {

    $datos_login[] = $request->getParam("lector");
    $datos_login[] = $request->getParam("clave");


    echo json_encode(login($datos_login));
});


// SERVICIOS

/*
C) Mediante una petición GET, obtener todos los libros de la BD. En caso de error por la BD el JSON devuelto
será: { “error” : “Error….”}, en otro caso el JSON será: { “libros” : [ {…}, {…},…,{...} ] }.
URL de la petición: http://localhost/Proyectos/Examen_SW_24_25/API_libreria/obtenerLibros
*/
$app->get('/obtenerLibros', function ($request) {
    echo json_encode(obtenerListaLibros());
    
});

/*
D) Crear un nuevo libro mediante una petición POST en la que aportaremos los datos mediante un array
asociativo con los siguientes índices: “referencia”, “titulo”, “autor”, “descripción” y “precio”. En caso de error
por la BD el JSON devuelto será: { “error” : “Error….”}, en otro caso el JSON será: { “mensaje” : “Libro
insertado correctamente en la BD”}
URL de la petición: http://localhost/Proyectos/Examen_SW_24_25/API_libreria/crearLibro
*/
$app->post('/crearLibro', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if ($test["usuario"]) {
            if ($test["usuario"]["tipo"]=="admin") {
                $datos_añadir[]= $request->getParam("referencia");
                $datos_añadir[]= $request->getParam("titulo");
                $datos_añadir[]= $request->getParam("autor");
                $datos_añadir[]= $request->getParam("descripcion");
                $datos_añadir[]= $request->getParam("precio");
                echo json_encode(crearLibro($datos_añadir));
            }else{
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));        
            }
        }else{
            echo json_encode($test);
        }
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

/*
E) Actualizar un libro mediante una petición PUT en la que aportaremos los datos mediante un array asociativo
con los siguientes índices: “titulo”, “autor”, “descripción” y “precio”. En caso de error por la BD el JSON
devuelto será:
{ “error” : “Error….”}, en otro caso el JSON será: : { “mensaje” : “Libro actualizado correctamente en la BD”}
URL de la petición: http://localhost/Proyectos/Examen_SW_24_25/API_libreria/actualizarLibro/{referencia},
dónde referencia es un atributo pasado por la URL.
 */

$app->put('/actualizarLibro/{referencia}', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                
                $datos_editar[] = $request->getParam("titulo");
                $datos_editar[] = $request->getParam("autor");
                $datos_editar[] = $request->getParam("descripcion");
                $datos_editar[] = $request->getParam("precio");
                $datos_editar[] = $request->getAttribute('referencia');

                echo json_encode(actualizarLibro($datos_editar));
            } else {
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
            }
        } else {
            echo json_encode($test);
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
    }
});



/*
F) Borrar un libro mediante una petición DELETE. En caso de error por la BD el JSON devuelto será:
{ “error” : “Error….”}, en otro caso el JSON será: : { “mensaje” : “Libro borrado correctamente en la BD”}
URL de la petición: http://localhost/Proyectos/Examen_SW_24_25/API_libreria/borrarLibro/{referencia},
dónde referencia es un atributo pasado por la URL.
*/
$app->delete('/borrarLibro/{referencia}', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if ($test["usuario"]) {
            if ($test["usuario"]["tipo"]=="admin") {
                $referencia= $request->getAttribute("referencia");
                echo json_encode(borrarLibro($referencia));
            }else{
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));        
            }
        }else{
            echo json_encode($test);
        }
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

/*
H) Mediante una petición GET, comprobar si en una tabla de la BD de datos, para una columna determinada
en un proceso de inserción ya existe un valor determinado. En caso de error por la BD el JSON devuelto
será: { “error” : “Error….”}, en otro caso el JSON será: { “repetido” :true ó false}.
URL de la petición:
http://localhost/Proyectos/Examen_SW_24_25/API_libreria/repetido/{tabla}/{columna}/{valor}, dónde tabla,
columna y valor son atributos pasados por la URL.
*/

$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {
    $test = validateToken();
    if (is_array($test)) {
        if ($test["usuario"]) {
            if ($test["usuario"]["tipo"]=="admin") {
                $tabla= $request->getAttribute("tabla");
                $columna= $request->getAttribute("columna");
                $valor= $request->getAttribute("valor");
                echo json_encode(repetido($tabla,$columna,$valor));
            }else{
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));        
            }
        }else{
            echo json_encode($test);
        }
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

/*
J) Mediante una petición GET, obtener todos los datos de un libro. En caso de error por la BD el JSON devuelto será:
{ “error” : “Error….”}, en otro caso el JSON será: { “libro” :{...} }.
URL de la petición: http://localhost/Proyectos/Examen_SW_24_25/API_libreria/obtenerLibro/{referencia},
dónde referencia es un atributo pasado por la URL
*/
$app->get('/obtenerLibro/{referencia}', function ($request) {

    $test = validateToken();
    if (is_array($test)) {
        if ($test["usuario"]) {
            if ($test["usuario"]["tipo"]=="admin") {
                $referencia= $request->getAttribute("referencia");
                echo json_encode(obtenerLibro($referencia));
            }else{
                echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));        
            }
        }else{
            echo json_encode($test);
        }
    } else
        echo json_encode(array("no_auth" => "No tienes permiso para usar el servicio"));
});

$app->run();
