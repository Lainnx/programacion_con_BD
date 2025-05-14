//capturar el objeto formulario

const formLogin= document.forms["formLogin"]   // array associatvo donde la clave es el name

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
        //location.reload(); // para recargar la pagina y se sincronize con BD en servidor
        window.location.href="../colores.php";
    }).catch(error => {
        console.log("Error: ", error);
    })
    })