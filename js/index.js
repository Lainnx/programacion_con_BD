// LOGIN

const formLogin= document.forms["formLogin"] || "No";  // array associatvo donde la clave es el name

if(formLogin!="No"){

formLogin.addEventListener("submit",(event)=>{
    event.preventDefault();
    
    let nombre = formLogin["nombre"].value.trim();
    //PENDIENTE corregir el nombre
    let password = formLogin["password"].value.trim();


    const mensajeError ="Contenido requerido";

    // console.log(nombre,password,password2,idioma,email);

        document.getElementById("errorUsuario").textContent = "";
        document.getElementById("errorPassword").textContent = "";


    if(nombre===""&&password===""){
        document.getElementById("errorUsuario").textContent = mensajeError;
        document.getElementById("errorPassword").textContent = mensajeError;
        return;
    }
    if(nombre===""){
        document.getElementById("errorUsuario").textContent = mensajeError;
        return;
    }
      if(password===""){
        document.getElementById("errorPassword").textContent = mensajeError;
        return;
    }

    //Comprobacion por REGEX

    // enviar datos a acceso.php
    const datos = new URLSearchParams();    // datos es el objeto
    datos.append("nombre",nombre);    //mismos nombres que en el insert/update
    datos.append("password",password);


    fetch("../controlador/login.php",{     // fetch tambien puede enviar datos, ../ porque esta en carpeta js
        "method":"POST",        // estos nombres no te los puedes inventar, son los que son
        "body":datos.toString(),    // enviamos los datos en forma de string
        "headers":{
                "Content-type":"application/x-www-form-urlencoded"      // hay diferentes tipos de contenido, jpg, json ...
            }   //catch- negativo,then -positivo, finally-en cualquier caso
    }).then(respuesta => respuesta.text())
    .then(data => {
        console.log(data);

        if(data == "UsuarioInexistente" || data == "PasswordIncorrecto"){
            document.getElementById("errorPassword").textContent = "Usuario o contraseña incorrectos";
            // window.location.href="index.php?formulario=login"; // no necesitamos otro location porque se tiene que quedar en la misma página
            return;
        }
        //location.reload(); // para recargar la pagina y se sincronize con BD en servidor
        window.location.href="../colores.php";  // aqui solo llegará cuando el usuario exista
    }).catch(error => {
        console.log("Error: ", error);
    })
    })
}

//CREAR USUARIO

const formNewUser = document.forms["formNewUser"] || "No";   // array associatvo donde la clave es el name

if(formNewUser!="No"){
formNewUser.addEventListener("submit",(event)=>{
    event.preventDefault();
    
    let nombre = formNewUser["nombre"].value.trim();
    //PENDIENTE corregir el nombre
    let password = formNewUser["password"].value.trim();
    let password2 = formNewUser["password2"].value.trim();
    let idioma = formNewUser["idioma"].value;
    let email = formNewUser["email"].value.trim();

    const mensajeError ="Contenido requerido";

    // console.log(nombre,password,password2,idioma,email);

        document.getElementById("errorUsuario").textContent = "";
        document.getElementById("errorPassword").textContent = "";
        document.getElementById("errorEmail").textContent = "";
    

    if(nombre===""&&password===""&&password2===""&&email===""){
        document.getElementById("errorUsuario").textContent = mensajeError;
        document.getElementById("errorPassword").textContent = mensajeError;
        document.getElementById("errorEmail").textContent = mensajeError;
        return;
    }
    if(nombre===""){
        document.getElementById("errorUsuario").textContent = mensajeError;
        return;
    }
    if(password===""||password2===""){
        document.getElementById("errorPassword").textContent = mensajeError;
        return;
    }
    if(email===""){
        document.getElementById("errorEmail").textContent = mensajeError;
        return;
    }
    // si las 2 contraseñas no coinciden
    if(password !== password2){
        document.getElementById("errorPassword").textContent = "Las contraseñas no coinciden";
        return;
    }
    //Comprobacion por REGEX

    // enviar datos a acceso.php
    const datos = new URLSearchParams();    // datos es el objeto
    datos.append("nombre",nombre);    //mismos nombres que en el insert/update
    datos.append("password",password);
    datos.append("password2",password2);
    datos.append("email",email);
    datos.append("idioma",idioma);

    fetch("../controlador/acceso.php",{     // fetch tambien puede enviar datos, ../ porque esta en carpeta js
        "method":"POST",        // estos nombres no te los puedes inventar, son los que son
        "body":datos.toString(),    // enviamos los datos en forma de string
        "headers":{
                "Content-type":"application/x-www-form-urlencoded"      // hay diferentes tipos de contenido, jpg, json ...
            }   //catch- negativo,then -positivo, finally-en cualquier caso
    }).then(respuesta => respuesta.text())
    .then(data => {
        console.log(data);
        // location.reload(); // para recargar la pagina y se sincronize con BD en servidor
        window.location.href="../colores.php";
    }).catch(error => {
        console.log("Error: ", error);
    })
    })
}