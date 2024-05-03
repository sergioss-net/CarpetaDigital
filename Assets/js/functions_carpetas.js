var tablaArchivos;

var divLoading = document.querySelector("#divLoading");  
var divLoadingNuevo = document.querySelector("#divLoadingNuevo");  

document.addEventListener('DOMContentLoaded', function(){
    tablaArchivos = $('#tablaArchivos').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": "../utils/Archivos.php?id_carpeta="+ id_carpeta_value,
            "dataSrc":""
        },
        "columns":[
            {"data":"Nombre_documento"},
            {"data":"Observaciones"},
            {"data":"opciones"},       
        ], 
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10, 
        "order":[[0,"desc"]]  
    });

    var Guardar_Datos = document.querySelector("#Guardar_Datos");
    Guardar_Datos.onsubmit = function(e){
        e.preventDefault();
        var empresa = document.querySelector("#id_empresa").value;
        var nivel = document.querySelector("#nivel").value;
        var id_carpeta = document.querySelector("#id_carpeta").value;
        var Tipo_documento = document.querySelector("#Documento").value;
        var Observaciones = document.querySelector("#Observaciones").value;
        var Archivo = document.querySelector("#Archivo").value;

        if(Archivo == ""){
            Swal.fire({
                icon: 'error',
                title: 'OPS....',
                text: 'EL ARCHIVO ES OBLIGATORIO'
            });
        }
        if (Observaciones == ""){
            document.getElementById("Observaciones").classList.add("is-invalid");
        }
    

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'VERIFIACA LOS CAMPOS EN ROJO!'
                });
                return false;
            } 
        }
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = '../utils/ComercioRegistro.php'; 
            var formData = new FormData(Guardar_Datos);
            formData.append('empresa', empresa);
            formData.append('nivel', nivel);
            formData.append('id_carpeta', id_carpeta);
            formData.append('Tipo_documento', Tipo_documento);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
               if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            html: objData.msg,
                        }).then(function() {
                            Guardar_Datos.reset();
                            $('#Modal_Datos').modal('hide');
                            tablaArchivos.api().ajax.reload();
                           
                        });
                    }
                    
               }
               divLoading.style.display = "none";
            }
        }

    var formCarpeta = document.querySelector("#formCarpeta");
    formCarpeta.onsubmit = function(e) {
        e.preventDefault();
        var empresa=  document.querySelector('#id_empresa').value ;
        var nivel=  document.querySelector('#nivel').value ;
        var id_carpeta=  document.querySelector('#id_carpeta').value ;
        var Nombre = document.getElementById('NombreCarpeta').value;

       

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Verifica los campos en Rojo!'
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
            formData.append('id_carpeta', id_carpeta);
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
 
    // var formCarpetaActualizar = document.querySelector("#formCarpetaActualizar");
    // formCarpetaActualizar.onsubmit = function(e){
    //     e.preventDefault();
    //     var empresa=  document.querySelector('#id_empresa_actualizar').value ;
    //     var nivel=  document.querySelector('#nivel_actualizar').value ;
    //     var id_carpeta=  document.querySelector('#id_carpeta_actualizar').value ;
    //     var Nombre = document.getElementById('NombreCarpetaActualizar').value;
    //     let elementsValid = document.getElementsByClassName("valid");
    //     for (let i = 0; i < elementsValid.length; i++) { 
    //         if(elementsValid[i].classList.contains('is-invalid')) { 
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'VERIFIACA LOS CAMPOS EN ROJO!'
    //             });
    //             return false;
    //         } 
    //     }

    //     if( Nombre.trim() === ''){
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'OPS..',
    //             text: 'EL NOMBRE ES OBLIGATORIO!'
    //           });
    //     }else{
    //         divLoading.style.display = "flex";
    //         var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    //         var ajaxUrl = '../utils/ActualizarCarpeta.php'; 
    //         var formData = new FormData(formCarpetaActualizar);
    //         formData.append('empresa', empresa);
    //         formData.append('nivel', nivel);
    //         formData.append('id_carpeta', id_carpeta);
    //         request.open("POST",ajaxUrl,true);
    //         request.send(formData);
    //         request.onreadystatechange = function(){
    //            if(request.readyState == 4 && request.status == 200){
    //                 var objData = JSON.parse(request.responseText);
    //                 if(objData.status){
    //                     Swal.fire({
    //                         icon: 'success',
    //                         title: 'Exito',
    //                         html: objData.msg,
    //                       }).then(function() {
    //                         formCarpetaActualizar.reset();
    //                         $('#modalActualizar').modal('hide');
    //                         tablaArchivos.api().ajax.reload();
    //                       });
    //                 }else{
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Oops...',
    //                         html: objData.msg,
    //                       });
    //                 }
    //            }
    //            divLoading.style.display = "none";
    //            return false;
    //         }
    //     }
    // }



});
function verSup(id_carpeta, nivel,id_empresa) {
    var nivelNuevo = nivel + 1;
    // Redirigir a la nueva URL
    window.location = 'SubFolder.php?id_carpeta=' + id_carpeta + '&nivel=' + nivelNuevo +'&id_empresa=' +id_empresa;
}
function crearSub (id_carpeta,nivel,id_empresa){ 
    
    document.querySelector('#id_carpeta').value = id_carpeta;
    document.querySelector('#nivel').value = nivel;
    document.querySelector('#id_empresa').value = id_empresa;
    document.querySelector("#formCarpeta").reset();
    document.getElementById('NombreCarpeta').classList.remove('is-valid');
    document.getElementById('NombreCarpeta').classList.remove('is-invalid');
    $("#modalCarpeta").modal('show');
}

function subirArchivo (id_carpeta_archivo,nivel_archivo,id_empresa_archivo,nombre_carpeta){
    
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = '../utils/info_carpeta.php?id_carpeta='+id_carpeta_archivo; 
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
             var carpeta = objData.Nombre_Carpeta;
             document.querySelector('#titleModal').innerHTML = carpeta;

            if(nombre_carpeta == carpeta){
                
               document.querySelector("#id_empresa").value = id_empresa_archivo;
               document.querySelector("#id_carpeta").value = id_carpeta_archivo;
               document.querySelector("#nivel").value = nivel_archivo;
               document.querySelector("#Tipo_Documento_hidden").value = carpeta;
               document.querySelector("#Documento").value = carpeta;
                
               if(nombre_carpeta == "ACTA ASAMBLEA" || nombre_carpeta == "ACTA CONSTITUTIVA" || nombre_carpeta == "ACTA SOCIOS"){
                    var numero_acta = document.querySelector("#numero");
                    numero_acta.style.display = 'block';
               }

               let elementsValid = document.getElementsByClassName("valid");
               for (let i = 0; i < elementsValid.length; i++) {
                   if (elementsValid[i].classList.contains('is-invalid') || elementsValid[i].classList.contains('is-valid')) {
                       elementsValid[i].classList.remove('is-invalid');
                       elementsValid[i].classList.remove('is-valid');
                   }
               }
               $("#Modal_Datos").modal('show');
               
            }

        }
    }
   
   
}

function Actualizar(id_carpeta){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = '../utils/info_carpeta.php?id_carpeta='+id_carpeta; 
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            console.log(objData);
            document.getElementById('id_empresa_actualizar').value = objData.id_empresa;
            document.getElementById('id_carpeta_actualizar').value = objData.id_carpeta;
            document.getElementById('nivel_actualizar').value = objData.Nivel;
            document.getElementById('NombreCarpetaActualizar').value = objData.Nombre_Carpeta;
            document.getElementById('color_actualizar').value = objData.color;
            $("#modalActualizar").modal('show');
        }
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
function buscar() {
    var consulta = document.querySelector('input[name="consulta"]').value;
    var carpetas = document.querySelector("#carpetas");
    var tablaResultados = document.querySelector("#tablaResultados");
    var titulo_carpeta = document.querySelector("#titulo_carpeta");
    var archivostabla = document.querySelector("#archivostabla");
    
    if (consulta != "") {
        titulo_carpeta.style.display = 'none';
        carpetas.style.display = 'none';
        tablaResultados.style.display= 'block';
        archivostabla.style.display = 'none';

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
                    var Nombre = document.createElement("td");
                    Nombre.textContent = objData[i].Nombre;
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
                    fila.appendChild(Nombre);
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
        archivostabla.style.display = 'block';
    }

        

    
}