


function showAndHide() {
    var x= document.getElementById("comentarios");

    if(x.style.display === "block")
        x.style.display= "none"
    else
        x.style.display= "block"

}

function asteriscos(palabra){
    var res="";
    for(var i=0; i< palabra.length; i++)
        res=res+"*"

    return res
}

function to_regex(palabras){

	var palabras_regex= []
	
	for(var i=0; i<palabras.length; i++)
		palabras_regex[i]= new RegExp(palabras[i], "i")
		
	return palabras_regex
}

function compruebaComentario(palabras) {
    //["pito", "culo", "peo", "caca", "mierda", "feo", "mazorca", "XD"]
    var palabras_regex= to_regex(palabras)

    comentario= String(document.getElementById("comentario").value)

        for(var i=0; i< palabras.length; i++)
            comentario= comentario.replace(palabras_regex[i], asteriscos(palabras[i]))

    document.getElementById("comentario").value= comentario;
}



function validarDatos(){
    correcto= true
    var nombre= document.getElementById("nombre").value
    if( nombre === '')
        correcto= false
    else {
        correo= document.getElementById("correo").value
        var patronCorreo= !(/^([\da-z_\.-]+)@([\da-z\.-]+).([a-z\.]{2,6})$/.test(correo))

        if(patronCorreo)
            correcto= false

        var comentario= document.getElementById("comentario").value
        if(comentario === '')
            correcto= false
    }

    return correcto

}

function guardarComentario() {
    if(validarDatos()){
        var lugar= document.getElementById("comentarios-nuevos")
        var fecha= new Date()
        var mes= fecha.getMonth()+1
        f= '<b>'+fecha.getDate()+"/"+mes+"/"+fecha.getFullYear()+" at "+fecha.getHours()+":"+fecha.getMinutes()+'</b>'
        console.log(f)
        var nombre= document.getElementById("nombre").value
        var comentario= document.getElementById("comentario").value
        var texto= '<div class="info-com"> <h4>' + nombre + '</h4>' + '<p>'+comentario+'</p>'+f+ '</div>'
        lugar.insertAdjacentHTML('beforeend', texto)

        document.getElementById("nombre").value= ""
        document.getElementById("comentario").value= ""
        document.getElementById("correo").value= ""
    } else{
        alert("Rellene correctamente los campos.")
    }



}


function editArea(i){

    var x= document.getElementById("editArea" + i);
    var y= document.getElementById("comentarioTexto" + i);
    var z= document.getElementById("confEditar" + i);
    if(x.style.display === "block" && y.style.display === "none") {
        x.style.display = "none"
        y.style.display = "block"
        z.style.display = "none"
    }
    else{
        x.style.display= "block"
        y.style.display= "none"
        z.style.display = "block"
    }

}
