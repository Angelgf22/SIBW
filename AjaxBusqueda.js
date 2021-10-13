$(document).ready(function() {
    $("#search-serie").keyup(function(){

        var buscado = $('#search-serie').val();
        var tipo= $('#tipo').val();

        if(buscado === ""){
            $("#cargando").hide();
            $("#listaResultados").hide();
        }else{
            $.ajax({
                data: {buscado: buscado, tipo: tipo},
                url: 'ajax.php',
                type: 'POST',
                beforeSend: function () {
                    $("#listaResultados").show();
                    $("#cargando").show();
                },
                success: function(respuesta){
                    $("#cargando").hide();
                    formatoRespuesta(respuesta);
                }
            });
        }
    });
});


function formatoRespuesta(respuesta) {
    res = '';

        for (i = 0 ; i < respuesta.length ; i++) {
                    res += '<li><a href=evento.php?ev='+respuesta[i].id +'><span>'+respuesta[i].nombre+'</span></a></li>';
        }


    $("#listaResultados").html(res);
}