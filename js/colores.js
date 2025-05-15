//obtener el objeto formulario del html

const formInsert = document.forms["formInsert"];

formInsert.addEventListener("submit",(e)=>{
    e.preventDefault();
    document.getElementById("errorUsuario").textContent = "";
    document.getElementById("errorColor").textContent = "";
    //obtener los datos del formulario
    const usuario = formInsert["usuario"].value.trim();  // el input tiene name="usuario"
    const color = formInsert["color"].value.trim().toLocaleLowerCase();
    const nombre_que_no_se_corresponde_con_lo_que_hace = formInsert["nombre_que_no_se_corresponde_con_lo_que_hace"].value;
    const token = formInsert["token"].value;
    const id_usuario = formInsert["id_usuario"].value;



    let mensajeError = "Contenido requerido";
    //Validar si usuario y/o color estan vacíos
    if(usuario === "" && color === ""){
        document.getElementById("errorUsuario").textContent = mensajeError;
        document.getElementById("errorColor").textContent = mensajeError;
        return;
    }
    if(usuario === ""){
        document.getElementById("errorUsuario").textContent = mensajeError;
        return;
    }
    if(color === ""){
        document.getElementById("errorColor").textContent = mensajeError;
        return;
    }
    //Comprobación del bot
    if(!nombre_que_no_se_corresponde_con_lo_que_hace === ""){ // si web esta vacio es que esta bien
        document.getElementById("errorColor").textContent = "Bot detectado";    // lo suyo seria crear otro parrafo con otro id
        return;
    }
    //Comprobación por REGEX = Expresiones regulares
    //https://www.w3schools.com/php/php_regex.asp
    // Regla a cumplir
    const regex1 = /^[A-zÑñÇçÁÉÍÓÚáéíóúÀÈÌÒÙàèìòùÄËÏÖÜäëïöü·\s]+$/
    // Reglas a NO cumplir
    const regex2 = /\W+/
    const regex3 = /\d+/

    const reglaUsuario = (regex2.test(usuario) || regex3.test(usuario)) && !regex1.test(usuario)    // si esto es tru MAL
    const reglaColor = (regex2.test(color) || regex3.test(color)) && !regex1.test(color)        // regex.rest.(string a testear)

    const mensaJeRegex ="Caracteres no válidos"
    if (reglaUsuario || reglaColor){
        document.getElementById("errorUsuario").textContent = mensaJeRegex;
        document.getElementById("errorColor").textContent = mensaJeRegex;
        return;
    }
    //Enviar datos a insert.php por POST
    //necesitamos un objeto para enviar a php
    const datos = new URLSearchParams();    // datos es el objeto
    datos.append("usuario",usuario);    //mismos nombres que en el insert/update
    datos.append("color",color);
    datos.append("nombre_que_no_se_corresponde_con_lo_que_hace",nombre_que_no_se_corresponde_con_lo_que_hace);
    datos.append("token",token);
    datos.append("id_usuario",id_usuario);

    fetch("../insert.php",{     // fetch tambien puede enviar datos, ../ porque esta en carpeta js
        "method":"POST",        // estos nombres no te los puedes inventar, son los que son
        "body":datos.toString(),    // enviamos los datos en forma de string
        "headers":{
                "Content-type":"application/x-www-form-urlencoded"      // hay diferentes tipos de contenido, jpg, json ...
            }   //catch- negativo,then -positivo, finally-en cualquier caso
    }).then(respuesta => respuesta.text())
    .then(data => {
        console.log(data);
        location.reload(); // para recargar la pagina y se sincronize con BD en servidor
    }).catch(error => {
        console.log("Error: ", error);
    })
});

//CERRAR SESIÓN POR INACTIVIDAD

const tiempoInactividad = 300000; //ms

let temporizador;

function redirigir(){
    window.location.href = "../controlador/logout.php";
}

function resetearTemporizador(){
    clearTimeout(temporizador);
    temporizador = setTimeout(redirigir, tiempoInactividad);   // cuando una funcion llama a otra no hace falta poner el () !!!
}

window.addEventListener("keydown", resetearTemporizador);
window.addEventListener("mousemove", resetearTemporizador);
window.addEventListener("click", resetearTemporizador);
window.addEventListener("scroll", resetearTemporizador);
window.addEventListener("touchstart", resetearTemporizador);  // listeners para cada evento posible, cuando el usuario haga algo se resetea el temporizador

// el temporizador tiene que empezar a contar cuando se carga la pagina
resetearTemporizador();