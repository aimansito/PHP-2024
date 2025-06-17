function cargar_libros_normal() {
  $.ajax({
    url: DIR_API + "/obtenerLibros",
    type: "GET",
    dataType: "json",
  })
    .done(function (data) {
      if (data.error) {
        $("#errores").html(data.error);
        $("#principal").html("");
        localStorage.clear();
      } else {
        let html_libros = "";
        $.each(data.libros, function (key, tupla) {
          html_libros += "<div>";
          html_libros +=
            "<img src='images/" +
            tupla["portada"] +
            "' alt='Portada' title='Portada'><br>";
          html_libros += tupla["titulo"] + " - " + tupla["precio"];
          html_libros += "</div>";
        });
        html_libros += "</div>";
        $(".contenedor_libros").html(html_libros);
      }
    })
    .fail(function (a, b) {
      $("#errores").html(error_ajax_jquery(a, b));
      $("#principal").html("");
    });
}

function cargar_libros_admin() {
  $.ajax({
    url: DIR_API + "/obtenerLibros",
    type: "GET",
    dataType: "json",
  })
    .done(function (data) {
      if (data.error) {
        $("#errores").html(data.error);
        $("#principal").html("");
        localStorage.clear();
      } else {
        let html_libros = "<table class='centrado txt_centrado'>";
        html_libros += "<tr><th>Ref</th><th>Título</th><th>Accion</th></tr>";
        $.each(data.libros, function (key, tupla) {
          html_libros += "<tr>";
          html_libros += "<td>" + tupla["referencia"] + "</td>";
          html_libros +=
            "<td><button class='enlace' onClick='mostrar_detalles(" +
            tupla["referencia"] +
            ")';'>" +
            tupla["titulo"] +
            "</button></td>";
          html_libros +=
            "<td><button class='enlace' onClick='cont_borrar_libro(" +
            tupla["referencia"] +
            ")';'>Borrar</button>-<button class='enlace' onClick='cargar_formulario_editar(" + tupla["referencia"] + ")'>Editar</button></td>";
          html_libros += "</tr>";
        });
        html_libros += "</table>";
        $("#libros").html(html_libros);
      }
    })
    .fail(function (a, b) {
      $("#errores").html(error_ajax_jquery(a, b));
      $("#principal").html("");
    });
}

function cargar_formulario_agregar() {
  let html_form_agregar = "<h2>Agregar un nuevo libro</h2>";
  html_form_agregar += "<form method='post' onsubmit='event.preventDefault()' action='index.html'>";
  html_form_agregar += "<label for='referencia'>Referencia:</label>";
  html_form_agregar +=
    "<input type='text' id='referencia' name='referencia' required><span id='errorRepetido'></span><p/>";
  html_form_agregar += "<label for='titulo'>Título:</label>";
  html_form_agregar +=
    "<input type='text' id='titulo' name='titulo' required><p/>";
  html_form_agregar += "<label for='autor'>Autor:</label>";
  html_form_agregar +=
    "<input type='text' id='autor' name='autor' required><p/>";
  html_form_agregar += "<label for='descripcion'>Descripción:</label>";
  html_form_agregar +=
    "<textarea id='descripcion' name='descripcion' required></textarea><p/>";
  html_form_agregar += "<label for=<'precio'>Precio:</label>";
  html_form_agregar +=
    "<input type='number' id='precio' name='precio' required><p/>";
  html_form_agregar += "<label for='portada'>Portada:</label>";
  html_form_agregar +=
    "<input type='file' id='portada' name='portada' accept='image/*'><p/>";
  html_form_agregar += "<button type='submit' onclick='validar_form_agregar()'>Agregar</button>";
  html_form_agregar += "</form>";
  $("#respuestas").html(html_form_agregar);
}

function mostrar_detalles(referencia) {
  if (new Date() / 1000 - localStorage.ultm_accion < MINUTOS * 60) {
    $.ajax({
      url: DIR_API + "/obtenerLibro/" + referencia,
      dataType: "json",
      type: "GET",
      headers: { Authorization: "Bearer " + localStorage.token },
    })
      .done(function (data) {
        if (data.error) {
          $("#errores").html(data.error);
          $("#principal").html("");
        } else if (data.no_auth) {
          localStorage.clear();
          cargar_vista_login("El tiempo de sesión de la API ha expirado.");
        } else if (data.mensaje_baneo) {
          localStorage.clear();
          cargar_vista_login("Usted ya no se encuentra registrado en la BD.");
        } else {
          localStorage.setItem("ultm_accion", new Date() / 1000);
          localStorage.setItem("token", data.token);

          let html_detalles_libro =
            "<h2>Detalles del Libro " + referencia + "</h2>";
          html_detalles_libro += "<p>";
          html_detalles_libro +=
            "<strong>Título:</strong>" + data.libro["titulo"] + "<br>";
          html_detalles_libro +=
            "<strong>Autor:</strong>" + data.libro["autor"] + "<br>";
          html_detalles_libro +=
            "<strong>Descripción:</strong>" +
            data.libro["descripcion"] +
            "<br>";
          html_detalles_libro +=
            "<strong>Precio:</strong>" + data.libro["precio"] + " €<br>";
          html_detalles_libro +=
            "<img src='images/" +
            data.libro["portada"] +
            "' alt='Portada' title='Portada'>";
          html_detalles_libro += "</p>";
          html_detalles_libro +=
            "<p><button onclick='cargar_formulario_agregar()'>Volver</button></p>";

          $("#respuestas").html(html_detalles_libro);
        }
      })
      .fail(function (a, b) {
        $("#errores").html(error_ajax_jquery(a, b));
        $("#principal").html("");
        localStorage.clear();
      });
  } else {
    localStorage.clear();
    cargar_vista_login("Su tiempo de sesión ha expirado");
  }
}

function cargar_formulario_editar(referencia) {

  $.ajax({
    url: DIR_API + "/obtenerLibro/" + referencia,
    dataType: "json",
    type: "GET",
    headers: { Authorization: "Bearer " + localStorage.token },
  })
    .done(function (data) {
      if (data.error) {
        $("#errores").html(data.error);
        $("#principal").html("");
      } else if (data.no_auth) {
        localStorage.clear();
        cargar_vista_login("El tiempo de sesión de la API ha expirado.");
      } else if (data.mensaje_baneo) {
        localStorage.clear();
        cargar_vista_login("Usted ya no se encuentra registrado en la BD.");
      } else {

        let html_form_editar = "<h2>Editar libro con referencia " + referencia + "</h2>";
        html_form_editar += "<form method='post' onsubmit='event.preventDefault()' action='index.html'>";
        html_form_editar += "<label for='referencia'>Referencia:</label>";
        html_form_editar += "<input type='text' id='referencia' name='referencia' disabled value='" + data.libro["referencia"] + "'><p/>";
        html_form_editar += "<label for='titulo'>Título:</label>";
        html_form_editar += "<input type='text' id='titulo' name='titulo' required value='" + data.libro["titulo"] + "'><p/>";
        html_form_editar += "<label for='autor'>Autor:</label>";
        html_form_editar += "<input type='text' id='autor' name='autor' required value='" + data.libro["autor"] + "'><p/>";
        html_form_editar += "<label for='descripcion'>Descripción:</label>";
        html_form_editar += "<textarea id='descripcion' name='descripcion' required >" + data.libro["descripcion"] + "</textarea><p/>";
        html_form_editar += "<label for=<'precio'>Precio:</label>";
        html_form_editar += "<input type='number' id='precio' name='precio' required value='" + data.libro["precio"] + "'><p/>";
        html_form_editar += "<label for='portada'>Portada:</label>";
        html_form_editar += "<input type='file' id='portada' name='portada' accept='image/*'><p/>";
        html_form_editar += "<p><button type = 'button' onclick='cargar_formulario_agregar()'>Volver</button><button type='submit' onClick='validar_form_editar()'>Editar</button></p>";
        html_form_editar += "</form>";

        $("#respuestas").html(html_form_editar);

      }
    })
    .fail(function (a, b) {
      $("#errores").html(error_ajax_jquery(a, b));
      $("#principal").html("");
      localStorage.clear();
    });
}

function cont_borrar_libro(referencia) {
  let html_detalles_libro = "<h2>Borrando el Libro " + referencia + "</h2>";
  html_detalles_libro += "<p>¿Estas seguro que quieres borrar este Libro?</p>";
  html_detalles_libro +=
    "<p><button onclick='borrar_libro(" + referencia + ")'>Borrar</button>";
  html_detalles_libro +=
    "<button onclick='cargar_formulario_agregar()'>Volver</button></p>";

  $("#respuestas").html(html_detalles_libro);
}

function borrar_libro(referencia) {
  if (new Date() / 1000 - localStorage.ultm_accion < MINUTOS * 60) {
    $.ajax({
      url: DIR_API + "/borrarLibro/" + referencia,
      dataType: "json",
      type: "DELETE",
      headers: { Authorization: "Bearer " + localStorage.token },
    })
      .done(function (data) {
        if (data.error) {
          $("#errores").html(data.error);
          $("#principal").html("");
        } else if (data.no_auth) {
          localStorage.clear();
          cargar_vista_login("El tiempo de sesión de la API ha expirado.");
        } else if (data.mensaje_baneo) {
          localStorage.clear();
          cargar_vista_login("Usted ya no se encuentra registrado en la BD.");
        } else {
          localStorage.setItem("ultm_accion", new Date() / 1000);
          localStorage.setItem("token", data.token);

          $("#errores").html("Libro borrado correctamente.");

          cargar_libros_admin();
          cargar_formulario_agregar();
        }
      })
      .fail(function (a, b) {
        $("#errores").html(error_ajax_jquery(a, b));
        $("#principal").html("");
        localStorage.clear();
      });
  } else {
    localStorage.clear();
    cargar_vista_login("Su tiempo de sesión ha expirado");
  }
}

function validar_form_agregar() {
  let referencia = $("#referencia").val().trim();
  let titulo = $("#titulo").val().trim();
  let autor = $("#autor").val().trim();
  let descripcion = $("#descripcion").val().trim();
  let precio = $("#precio").val().trim();

  if (!referencia || !titulo || !autor || !descripcion || !precio) {
    console.log("Error: campos vacíos");
    return;
  }

  if (isNaN(precio) || parseFloat(precio) <= 0) {
    console.log("Error: precio inválido");
    return;
  }
  if (new Date() / 1000 - localStorage.ultm_accion < MINUTOS * 60) {
    $.ajax({
      url: DIR_API + "/repetido/" + referencia,
      dataType: "json",
      type: "GET",
      headers: { Authorization: "Bearer " + localStorage.token },
    })
      .done(function (data) {
        if (data.error) {
          $("#errores").html(data.error);
        } else if (data.repetido) {
          $("#errorRepetido").html(
            " El código de referencia ya existe. No se puede duplicar."
          );
        } else {
          $.ajax({
            url: DIR_API + "/insertarLibro",
            dataType: "json",
            type: "POST",
            data: {
              referencia: referencia,
              titulo: titulo,
              autor: autor,
              descripcion: descripcion,
              precio: precio,
              portada: "no_imagen.jpg",
            },
            headers: { Authorization: "Bearer " + localStorage.token },
          })
            .done(function (data) {
              if (data.error) {
                $("#errores").html(data.error);
                $("#principal").html("");
              } else if (data.no_auth) {
                localStorage.clear();
                cargar_vista_login("El tiempo de sesión de la API ha expirado.");
              } else if (data.mensaje_baneo) {
                localStorage.clear();
                cargar_vista_login("Usted ya no se encuentra registrado en la BD.");
              } else {
                localStorage.setItem("ultm_accion", new Date() / 1000);
                localStorage.setItem("token", data.token);

                $("#errores").html("Libro agregado correctamente.");
                cargar_libros_admin();
                cargar_formulario_agregar();
              }
            })
            .fail(function (a, b) {
              $("#errores").html(error_ajax_jquery(a, b));
              console.log("Error AJAX al insertar libro:", error_ajax_jquery(a, b));
              localStorage.clear();
            });
        }
      })
      .fail(function (a, b) {
        $("#errores").html("Error al comprobar si la referencia está repetida.");
      });
  } else {
    localStorage.clear();
    cargar_vista_login("Su tiempo de sesión ha expirado");
  }
}

function validar_form_editar() {
  let referencia = $("#referencia").val().trim();
  let titulo = $("#titulo").val().trim();
  let autor = $("#autor").val().trim();
  let descripcion = $("#descripcion").val().trim();
  let precio = $("#precio").val().trim();



  if (!referencia || !titulo || !autor || !descripcion || !precio) {
    console.log("Error: campos vacíos");
    return;
  }

  if (isNaN(precio) || parseFloat(precio) <= 0) {
    console.log("Error: precio inválido");
    return;
  }
  if (new Date() / 1000 - localStorage.ultm_accion < MINUTOS * 60) {
    $.ajax({
      url: DIR_API + "/actualizarLibro/" + referencia,
      dataType: "json",
      type: "PUT",
      data: {
        titulo: titulo,
        autor: autor,
        descripcion: descripcion,
        precio: precio,
        portada: "no_imagen.jpg",
      },
      headers: { Authorization: "Bearer " + localStorage.token },
    })
      .done(function (data) {
        if (data.error) {
          $("#errores").html(data.error);
          $("#principal").html("");
        } else if (data.no_auth) {
          localStorage.clear();
          cargar_vista_login("El tiempo de sesión de la API ha expirado.");
        } else if (data.mensaje_baneo) {
          localStorage.clear();
          cargar_vista_login("Usted ya no se encuentra registrado en la BD.");
        } else {
          localStorage.setItem("ultm_accion", new Date() / 1000);
          localStorage.setItem("token", data.token);

          $("#errores").html("Libro editado correctamente.");
          cargar_libros_admin();
          cargar_formulario_agregar();
        }
      })
      .fail(function (a, b) {
        $("#errores").html(error_ajax_jquery(a, b));
        localStorage.clear();
      });
  } else {
    localStorage.clear();
    cargar_vista_login("Su tiempo de sesión ha expirado");
  }
}



