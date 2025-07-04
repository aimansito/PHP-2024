const DIR_API="API_libreria";
const MINUTOS=100;

$(function(){
    if(localStorage.token)
    {
        if(((new Date()/1000)-localStorage.ultm_accion)<MINUTOS*60)
        {
            //
            $.ajax({
                url:DIR_API+"/logueado",
                type:"GET",
                dataType:"json",
                headers:{Authorization:"Bearer "+localStorage.token}
            })
            .done(function(data){
                if(data.error)
                {
                    $('#errores').html(data.error);
                    $('#principal').html("");
                    localStorage.clear();
                }
                else if(data.no_auth)
                {
                    localStorage.clear();
                    cargar_vista_login("El tiempo de sesión de la API ha expirado.");
                }
                else if(data.mensaje_baneo)
                {
                    localStorage.clear();
                    cargar_vista_login("Usted ya no se encuentra registrado en la BD");
                }
                else
                {
                    localStorage.setItem("ultm_accion",(new Date()/1000));
                    localStorage.setItem("token",data.token);
                    cargar_vista_oportuna(data.usuario);
                }

            })
            .fail(function(a,b){
                $('#errores').html(error_ajax_jquery(a,b));
                $('#principal').html("");
            });
        }
        else
        {
            localStorage.clear();
            cargar_vista_login("Su tiempo de sesión ha expirado");
        }
    }
    else
        cargar_vista_login("");
})

function cargar_vista_oportuna(datos_usu_log)
{
    $('#errores').html("");
    let html_principal="<div id='saludo'>Bienvenido <strong>"+datos_usu_log["lector"]+"</strong> - <button onclick='cerrar_sesion();' class='enlace'>Salir</button></div>";
    if(datos_usu_log["tipo"]=="admin")
    {
        html_principal+="<h2>Listado de los Libros</h2><div id='libros'></div><div id='respuestas'></div>";
        $('#principal').html(html_principal);
        cargar_libros_admin();
        cargar_formulario_agregar();
    }
    else
    {
        html_principal+="<h2>Listado de los Libros</h2><div class='contenedor_libros'></div>";
        $('#principal').html(html_principal);
        cargar_libros_normal();
    }

}



function cerrar_sesion()
{
    localStorage.clear();
    window.location.href="index.html";

}

function cargar_vista_login(error)
{
    $('#errores').html("");
    let html_form_login="<div id='login'>";
    html_form_login+="<form onsubmit='event.preventDefault();hacer_login();'>";
    html_form_login+="<p><label for='usuario'>Usuario: </label><input type='text' id='usuario' required/><span id='error_login' class='error'></span></p>";
    html_form_login+="<p><label for='clave'>Clave: </label><input type='password' id='clave' required/></p>";
    html_form_login+="<p><button>Login</button></p>";
    html_form_login+="<p id='mensaje_login' class='mensaje'>"+error+"</p>";
    html_form_login+="</form>";
    html_form_login+="</div>";

    //Llamada ajax para obtener libros y escribirlos en un nuevo div
    html_form_login+="<h2>Listado de los Libros</h2><div class='contenedor_libros'>";
    html_form_login+="</div>";
    $('#principal').html(html_form_login);
    cargar_libros_normal();
  
}


function hacer_login()
{
    let usuario=$('#usuario').val();
    let clave_cifrada=md5($('#clave').val());

  
    $.ajax({
        url:DIR_API+"/login",
        type:"POST",
        dataType:"json",
        data:{"lector":usuario,"clave":clave_cifrada}
    
    })
    .done(function(data){
        if(data.error)
        {
            $('#errores').html(data.error);
            $('#principal').html("");
        }
        else if(data.mensaje)
        {
            $('#error_login').html("Usuario y/o clave incorrectos");
            $('#clave').val("");
        }
        else
        {
            localStorage.setItem('token',data.token);
            localStorage.setItem('ultm_accion',(new Date()/1000));
            window.location.href="index.html";
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#principal').html("");
        

    });
}

/// Funciones para el MD5
function md5cycle(x, k) {
    var a = x[0], b = x[1], c = x[2], d = x[3];
    
    a = ff(a, b, c, d, k[0], 7, -680876936);
    d = ff(d, a, b, c, k[1], 12, -389564586);
    c = ff(c, d, a, b, k[2], 17,  606105819);
    b = ff(b, c, d, a, k[3], 22, -1044525330);
    a = ff(a, b, c, d, k[4], 7, -176418897);
    d = ff(d, a, b, c, k[5], 12,  1200080426);
    c = ff(c, d, a, b, k[6], 17, -1473231341);
    b = ff(b, c, d, a, k[7], 22, -45705983);
    a = ff(a, b, c, d, k[8], 7,  1770035416);
    d = ff(d, a, b, c, k[9], 12, -1958414417);
    c = ff(c, d, a, b, k[10], 17, -42063);
    b = ff(b, c, d, a, k[11], 22, -1990404162);
    a = ff(a, b, c, d, k[12], 7,  1804603682);
    d = ff(d, a, b, c, k[13], 12, -40341101);
    c = ff(c, d, a, b, k[14], 17, -1502002290);
    b = ff(b, c, d, a, k[15], 22,  1236535329);
    
    a = gg(a, b, c, d, k[1], 5, -165796510);
    d = gg(d, a, b, c, k[6], 9, -1069501632);
    c = gg(c, d, a, b, k[11], 14,  643717713);
    b = gg(b, c, d, a, k[0], 20, -373897302);
    a = gg(a, b, c, d, k[5], 5, -701558691);
    d = gg(d, a, b, c, k[10], 9,  38016083);
    c = gg(c, d, a, b, k[15], 14, -660478335);
    b = gg(b, c, d, a, k[4], 20, -405537848);
    a = gg(a, b, c, d, k[9], 5,  568446438);
    d = gg(d, a, b, c, k[14], 9, -1019803690);
    c = gg(c, d, a, b, k[3], 14, -187363961);
    b = gg(b, c, d, a, k[8], 20,  1163531501);
    a = gg(a, b, c, d, k[13], 5, -1444681467);
    d = gg(d, a, b, c, k[2], 9, -51403784);
    c = gg(c, d, a, b, k[7], 14,  1735328473);
    b = gg(b, c, d, a, k[12], 20, -1926607734);
    
    a = hh(a, b, c, d, k[5], 4, -378558);
    d = hh(d, a, b, c, k[8], 11, -2022574463);
    c = hh(c, d, a, b, k[11], 16,  1839030562);
    b = hh(b, c, d, a, k[14], 23, -35309556);
    a = hh(a, b, c, d, k[1], 4, -1530992060);
    d = hh(d, a, b, c, k[4], 11,  1272893353);
    c = hh(c, d, a, b, k[7], 16, -155497632);
    b = hh(b, c, d, a, k[10], 23, -1094730640);
    a = hh(a, b, c, d, k[13], 4,  681279174);
    d = hh(d, a, b, c, k[0], 11, -358537222);
    c = hh(c, d, a, b, k[3], 16, -722521979);
    b = hh(b, c, d, a, k[6], 23,  76029189);
    a = hh(a, b, c, d, k[9], 4, -640364487);
    d = hh(d, a, b, c, k[12], 11, -421815835);
    c = hh(c, d, a, b, k[15], 16,  530742520);
    b = hh(b, c, d, a, k[2], 23, -995338651);
    
    a = ii(a, b, c, d, k[0], 6, -198630844);
    d = ii(d, a, b, c, k[7], 10,  1126891415);
    c = ii(c, d, a, b, k[14], 15, -1416354905);
    b = ii(b, c, d, a, k[5], 21, -57434055);
    a = ii(a, b, c, d, k[12], 6,  1700485571);
    d = ii(d, a, b, c, k[3], 10, -1894986606);
    c = ii(c, d, a, b, k[10], 15, -1051523);
    b = ii(b, c, d, a, k[1], 21, -2054922799);
    a = ii(a, b, c, d, k[8], 6,  1873313359);
    d = ii(d, a, b, c, k[15], 10, -30611744);
    c = ii(c, d, a, b, k[6], 15, -1560198380);
    b = ii(b, c, d, a, k[13], 21,  1309151649);
    a = ii(a, b, c, d, k[4], 6, -145523070);
    d = ii(d, a, b, c, k[11], 10, -1120210379);
    c = ii(c, d, a, b, k[2], 15,  718787259);
    b = ii(b, c, d, a, k[9], 21, -343485551);
    
    x[0] = add32(a, x[0]);
    x[1] = add32(b, x[1]);
    x[2] = add32(c, x[2]);
    x[3] = add32(d, x[3]);
    
    }
    
    function cmn(q, a, b, x, s, t) {
    a = add32(add32(a, q), add32(x, t));
    return add32((a << s) | (a >>> (32 - s)), b);
    }
    
    function ff(a, b, c, d, x, s, t) {
    return cmn((b & c) | ((~b) & d), a, b, x, s, t);
    }
    
    function gg(a, b, c, d, x, s, t) {
    return cmn((b & d) | (c & (~d)), a, b, x, s, t);
    }
    
    function hh(a, b, c, d, x, s, t) {
    return cmn(b ^ c ^ d, a, b, x, s, t);
    }
    
    function ii(a, b, c, d, x, s, t) {
    return cmn(c ^ (b | (~d)), a, b, x, s, t);
    }
    
    function md51(s) {
    txt = '';
    var n = s.length,
    state = [1732584193, -271733879, -1732584194, 271733878], i;
    for (i=64; i<=s.length; i+=64) {
    md5cycle(state, md5blk(s.substring(i-64, i)));
    }
    s = s.substring(i-64);
    var tail = [0,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0];
    for (i=0; i<s.length; i++)
    tail[i>>2] |= s.charCodeAt(i) << ((i%4) << 3);
    tail[i>>2] |= 0x80 << ((i%4) << 3);
    if (i > 55) {
    md5cycle(state, tail);
    for (i=0; i<16; i++) tail[i] = 0;
    }
    tail[14] = n*8;
    md5cycle(state, tail);
    return state;
    }
    
    /* there needs to be support for Unicode here,
     * unless we pretend that we can redefine the MD-5
     * algorithm for multi-byte characters (perhaps
     * by adding every four 16-bit characters and
     * shortening the sum to 32 bits). Otherwise
     * I suggest performing MD-5 as if every character
     * was two bytes--e.g., 0040 0025 = @%--but then
     * how will an ordinary MD-5 sum be matched?
     * There is no way to standardize text to something
     * like UTF-8 before transformation; speed cost is
     * utterly prohibitive. The JavaScript standard
     * itself needs to look at this: it should start
     * providing access to strings as preformed UTF-8
     * 8-bit unsigned value arrays.
     */
    function md5blk(s) { /* I figured global was faster.   */
    var md5blks = [], i; /* Andy King said do it this way. */
    for (i=0; i<64; i+=4) {
    md5blks[i>>2] = s.charCodeAt(i)
    + (s.charCodeAt(i+1) << 8)
    + (s.charCodeAt(i+2) << 16)
    + (s.charCodeAt(i+3) << 24);
    }
    return md5blks;
    }
    
    var hex_chr = '0123456789abcdef'.split('');
    
    function rhex(n)
    {
    var s='', j=0;
    for(; j<4; j++)
    s += hex_chr[(n >> (j * 8 + 4)) & 0x0F]
    + hex_chr[(n >> (j * 8)) & 0x0F];
    return s;
    }
    
    function hex(x) {
    for (var i=0; i<x.length; i++)
    x[i] = rhex(x[i]);
    return x.join('');
    }
    
    function md5(s) {
    return hex(md51(s));
    }
    function add32(a, b) {
        return (a + b) & 0xFFFFFFFF;
    }

// Error llamada ajax jquery

function error_ajax_jquery( jqXHR, textStatus) 
{
    var respuesta;
    if (jqXHR.status === 0) {
  
      respuesta='Not connect: Verify Network.';
  
    } else if (jqXHR.status == 404) {
  
      respuesta='Requested page not found [404]';
  
    } else if (jqXHR.status == 500) {
  
      respuesta='Internal Server Error [500].';
  
    } else if (textStatus === 'parsererror') {
  
      respuesta='Requested JSON parse failed.';
  
    } else if (textStatus === 'timeout') {
  
      respuesta='Time out error.';
  
    } else if (textStatus === 'abort') {
  
      respuesta='Ajax request aborted.';
  
    } else {
  
      respuesta='Uncaught Error: ' + jqXHR.responseText;
  
    }
    return respuesta;
}

