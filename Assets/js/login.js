var divLoading = document.querySelector("#divLoading");//variable para el load de espera

document.addEventListener('DOMContentLoaded', function(){
	//metodo para obtener las variables del formulario login.
	if(document.querySelector("#formlogin")){
		let formlogin = document.querySelector("#formlogin");
		formlogin.onsubmit = function(e) {//obtiene el evento cuando hace click en el boton del formulario 
			e.preventDefault();//previene el cierre de ventana de login 
			//variables del formulario login
			let usuario = document.querySelector('#username').value.trim();
			let password = document.querySelector('#txtPassword').value.trim();
			//validacion de los campos si no estan vacios
			if(usuario == "" || password == "")
			{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'TODOS LOS CAMPOS SON OBLIGATORIOS',
				  });
				return false;
			}else{
                divLoading.style.display = "flex";
				//se envian los valores por ajax al metodo login para validar cada una de las variables
				var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');// se crea un objeto de tipo httprequest para el manejo de variables
				var ajaxUrl ="../utils/login.php"; // la direccion donde se encuentra el metodo para el manejo de las validaciones 
				var formData = new FormData(formlogin);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState == 4 && request.status == 200){//validacion de respuesta del metodo LoginUser
						var objData = JSON.parse(request.responseText);
                        if(objData.status === false){
                            if(objData.dato === 1){
                                Swal.fire({
                                    title: 'ATENCION',
                                    html: objData.msg,
                                    icon: 'error'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                        formlogin.reset();
                                        divLoading.style.display = "none";
                                    }
                                  });
                            }else if(objData.dato === 2){
                                Swal.fire({
                                    title: 'ATENCION',
                                    html: objData.msg,
                                    icon: 'error'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                        formlogin.reset();
                                        divLoading.style.display = "none";
                                    }
                                  });
                            }else if(objData.dato === 3){
                                Swal.fire({
                                    title: 'ATENCION',
                                    html: objData.msg,
                                    icon: 'error'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                        formlogin.reset();
                                        divLoading.style.display = "none";
                                    }
                                  });
                            }else{ 
                                Swal.fire({
                                    title: 'ATENCION',
                                    html: objData.msg,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        divLoading.style.display = "flex";
                                        // Realizar la solicitud AJAX
                                        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                                        var ajaxUrl = "../utils/logout.php";
                                        var formData = new FormData(formlogin);
                                        request.open("POST", ajaxUrl, true);

                                        request.onreadystatechange = function() {
                                            if (request.readyState === 4 && request.status === 200) {
                                                var objData = JSON.parse(request.responseText);
                                                if(objData.status){
                                                    window.location.href = 'logout.php';

                                                    // O cerrar la ventana del navegador
                                                    window.close();
                                                    window.location = '../view/Dashboard.php';
                                                }else{
                                                    Swal.fire({
                                                        title: 'ATENCION',
                                                        html: objData.msg,
                                                        icon: 'error'
                                                      });
                                                      formlogin.reset();
                                                }
                                            }
                                        };

                                        request.send(formData);
                                    }
                                });
                            }
                        }else if(objData.status){
                            window.location = '../view/Dashboard.php';
                        }
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	}
}, false);