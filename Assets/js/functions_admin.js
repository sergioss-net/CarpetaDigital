
//tets para validar texto
function testText(txtString){
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}
//tets para validar texto
function testTextNumber(txtString){
    var stringText = new RegExp(/^[a-zA-Z0-9\s!@#$%^&*(),.?":{}|<>_+-=\\/\[\]]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}
// test para validar numeros 
function testEntero(intCant){
    var intCantidad = new RegExp(/^([0-9])*$/);
    if(intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}

// test para validar el un email
function fntEmailValidate(email){
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }
}
function fntValidTextNumber(){
	let validTextNumber = document.querySelectorAll(".validTextNumber");
    validTextNumber.forEach(function(validTextNumber) {
        validTextNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testTextNumber(inputValue)){
				this.classList.add('is-invalid');
			}else{
                this.classList.add('is-valid');
				this.classList.remove('is-invalid');
			}				
		});
	});
}
// funcion para validar texto comparando la cadena test
function fntValidText(){
	let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText) {
        validText.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
                this.classList.add('is-valid');
				this.classList.remove('is-invalid');
			}				
		});
	});
}
// funcion para validar numeros con respecto al test
function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber) {
        validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
                this.classList.add('is-valid');
				this.classList.remove('is-invalid');
			}				
		});
	});
}
// funcion para validar email con respecto al test
function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)){
				this.classList.add('is-invalid');
			}else{
                this.classList.add('is-valid');
				this.classList.remove('is-invalid');
			}				
		});
	});
}

// funcion para eliminar comillas simples y dobles en los inputs
function quitarComillas(elemento) {
    var valor = elemento.value;
    valor = valor.replace(/["']/g, ''); // reemplazar comillas dobles y simples con una cadena vacía
    elemento.value = valor;
}
function quitarAcentosYComillas(elemento) {
    var valor = elemento.value;
    
    // Quitar acentos
    valor = valor.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

    // Quitar comillas dobles y simples
    valor = valor.replace(/["']/g, '');
    
    // Actualizar el valor del input con el texto sin acentos ni comillas
    elemento.value = valor;
  }
// carga las funciones cada que carga la pagina 
window.addEventListener('load', function() {
	fntValidText();
	fntValidEmail(); 
	fntValidNumber();
    fntValidTextNumber();
}, false);
var botonRetroceso = document.getElementById('botonRetroceso');

// Agrega un evento de clic al botón
botonRetroceso.addEventListener('click', function() {
  // Llama al método back() del objeto history para retroceder una página
  history.back();
});