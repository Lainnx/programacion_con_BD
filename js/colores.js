//obtener el objeto formulario del html

const formInsert = document.forms["formInsert"];

formInsert.addEventListener("submit",(e)=>{
    e.preventDefault();
    document.getElementById("errorUsuario").textContent = "";
    document.getElementById("errorColor").textContent = "";
    //obtener los datos del formulario
    const usuario = formInsert["usuario"].value.trim();  // el input tiene name="usuario"
    const color = formInsert["color"].value.trim();
    const nombre_que_no_se_corresponde_con_lo_que_hace = formInsert["nombre_que_no_se_corresponde_con_lo_que_hace"].value;
    const token = formInsert["token"].value;


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
});