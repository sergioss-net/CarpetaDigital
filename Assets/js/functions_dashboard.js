document.addEventListener('DOMContentLoaded', function(){
    
    var formCarpeta = document.querySelector("#formCarpeta");
    formCarpeta.onsubmit = function(e) {
        e.preventDefault();
        var empresa=  document.querySelector('#id_empresa').value ;
        var nivel=  document.querySelector('#nivel').value ;
        var Nombre = document.getElementById('NombreCarpeta').value;
       


        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                Swal.fire({
                    icon: 'error',
                    title: 'OOPS...',
                    text: 'VERIFICA LOS CAMPOS EN ROJO!'
                });
                return false;
            } 
        }

        if( Nombre.trim() === ''){
            Swal.fire({
                icon: 'error',
                title: 'OPS..',
                text: 'EL NOMBRE ES OBLIGATORIO!'
              });
        }else{
            divLoadingNuevo.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = '../utils/crearCarpeta.php'; 
            var formData = new FormData(formCarpeta);
            formData.append('empresa', empresa);
            formData.append('nivel', nivel);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
               if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status){
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            html: objData.msg,
                          }).then(function() {
                            formCarpeta.reset();
                            $('#modalCarpeta').modal('hide');
                            window.location.reload();
                          });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: objData.msg,
                          });
                    }
               }
               divLoadingNuevo.style.display = "none";
                return false;
            }
        }
        
        
    }
 

});
function verSup(id_carpeta, nivel,id_empresa) {
    var nivelNuevo = nivel + 1;
    window.location = 'SubFolder.php?id_carpeta=' + id_carpeta + '&nivel=' + nivelNuevo +'&id_empresa=' +id_empresa;
}
function crear (id_Empresa,nivel){
    document.querySelector('#id_empresa').value = id_Empresa;
    document.querySelector('#nivel').value = nivel;
    document.querySelector("#formCarpeta").reset();
    document.getElementById('NombreCarpeta').classList.remove('is-valid');
    document.getElementById('NombreCarpeta').classList.remove('is-invalid');
    $("#modalCarpeta").modal('show');
}

function ver (id_Empresa,nivel){
    window.location = 'Folders.php?id_empresa=' + id_Empresa + '&nivel='+nivel;
}
function buscar() {
    var consulta = document.querySelector('input[name="consulta"]').value;
    var carpetas = document.querySelector("#carpetas");
    var tablaResultados = document.querySelector("#tablaResultados");
    var titulo_carpeta = document.querySelector("#titulo_carpeta");
    
    if (consulta != "") {
        titulo_carpeta.style.display = 'none';
        carpetas.style.display = 'none';
        tablaResultados.style.display= 'block';
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = '../utils/buscar.php?consulta=' + consulta;
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if(request.readyState == 4 && request.status == 200){
                 var objData = JSON.parse(request.responseText);
 
                 // Obtener la tabla donde insertaremos los resultados
                 var tabla = document.getElementById("miTabla");
                 var tbody = tabla.getElementsByTagName("tbody")[0];
 
                 // Limpiar la tabla si ya tenía resultados anteriores
                 tbody.innerHTML = "";
 
                 // Iterar sobre los resultados y crear filas de tabla
                 for (var i = 0; i < objData.length; i++) {
                    var fila = document.createElement("tr");
                    var documento = document.createElement("td");
                    documento.textContent = objData[i].Nombre_documento;
                    var tipoDocumento = document.createElement("td");
                    tipoDocumento.textContent = objData[i].Tipo_Documento;
                    var noActa = document.createElement("td");
                    noActa.textContent = objData[i].No_Acta;
                    var observaciones = document.createElement("td");
                    observaciones.textContent = objData[i].Observaciones;
                    var estado = document.createElement("td");
                    estado.textContent = objData[i].Estado;
                    var opciones = document.createElement("td");
                    opciones.innerHTML = objData[i].opciones; // Inserta el HTML de los botones
            
                    fila.appendChild(documento);
                    fila.appendChild(tipoDocumento);
                    fila.appendChild(noActa);
                    fila.appendChild(observaciones);
                    fila.appendChild(opciones); // Agrega la celda de botones
            
                    tbody.appendChild(fila);
                }
             }
         }
    } else {
        titulo_carpeta.style.display = 'flex';
        carpetas.style.display = 'flex';
        tablaResultados.style.display = 'none';
    }

        

    
}
function fntDownload(id_documento){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = '../utils/Descargar_archivo.php?id_documento='+id_documento; 
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var downloadLink = document.createElement('a');
            downloadLink.href = '../utils/Descargar_archivo.php?id_documento=' + id_documento;
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
        
            // Simular el clic en el enlace de descarga
            downloadLink.click();
        
            // Eliminar el enlace después de la descarga
            document.body.removeChild(downloadLink);
        }
    }

}

function fntView(id_documento){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = '../utils/Ver_Documento.php?id_documento=' + id_documento;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            // Obtener la URL del archivo PHP
            var url = '../utils/Ver_Documento.php?id_documento=' + id_documento;

            // Abrir el archivo en una nueva ventana o pestaña
            window.open(url, '_blank');
        }
    }
}