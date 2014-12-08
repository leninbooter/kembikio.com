function nomape_valido(campo)
{
	return /^[A-Za-zñÑ]{1,50}$/.test( campo.val() );
}

function email_valido(campo)
{
	return  /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test( campo.val() );
}

function email_conf_valido(campo)
{
	return campo.val() == $('#email').val();
}

function telefono_valido(campo)
{
	return  /^(?:\d|\+){1}[0-9]{1,19}$/.test( campo.val() );
}

function comcar_valido(campo)
{
	return  /^[A-Za-z]{0,150}$/.test( campo.val() );
}

function comments_valido(campo)
{
	return  /^[A-Za-z0-9_.,\s]{5,2000}$/.test( campo.val() );
}

function direccion_valida(campo)
{
	return /^[A-Za-z0-9ñÑ\_\-\.\,\#\s]{5,200}$/.test( campo.val() );
}

function cp_valido(campo)
{
	return /^[0-9]{4,5}$/.test( campo.val() );
}

function blink(ele) {
    blink1(ele);
}
function blink1(ele) {
    ele.removeClass();
    ele.addClass("bordetitilante");
    setTimeout(function () { blink2(ele); }, 150);
}

function blink2(ele) {
    ele.removeClass();
    ele.addClass("bordenormal");
	setTimeout(function () { blink3(ele); }, 150);
}

function blink3(ele) {
    ele.removeClass();
    ele.addClass("bordetitilante");
	setTimeout(function () { blink4(ele); }, 150);
}

function blink4(ele) {
    ele.removeClass();
    ele.addClass("bordenormal");
	setTimeout(function () { blink5(ele); }, 150);
}

function blink5(ele) {
    ele.removeClass();
    ele.addClass("bordetitilante");
	setTimeout(function () { blink6(ele); }, 150);
}

function blink6(ele) {
    ele.removeClass();
    ele.addClass("bordenormal");
}

$( '#nombre' ).focusout(function() {
	if( !nomape_valido( $(this) ) )
	{
		blink( $(this) );
	}
});

$( '#apellido' ).focusout(function() {
	if( !nomape_valido( $(this) ) )
	{
		blink( $(this) );
	}
});

$( '#email' ).focusout(function() {
	if( !email_valido( $(this) ) )
	{
		blink( $(this) );
	}
});

$( '#email_conf' ).focusout(function() {
	if( !$(this).val() == $('#email').val() )
	{
		blink( $(this) );
	}
});

$( '#direccion' ).focusout(function() {
	if( !direccion_valida( $(this) ) )
	{
		blink( $(this) );
	}

});

$( '#cp' ).focusout(function() {
	if( !cp_valido( $(this) ) )
	{
		blink( $(this) );
	}

});

$( '#telefono' ).focusout(function() {
	if( !telefono_valido( $(this) ) )
	{
		blink( $(this) );
	}
});

$( '#empresa' ).focusout(function() {
	if( !comcar_valido( $(this) ) )
	{
		blink( $(this) );
	}
});

$( '#cargo' ).focusout(function() {
	if( !comcar_valido( $(this) ) )
	{
		blink( $(this) );
	}
});

$( '#comentarios' ).focusout(function() {
	if( !comments_valido( $(this) ) )
	{
		blink( $(this) );
	}
});

/* informacion/contactanos */
$( '#form_contacto' ).submit( function( event ) {
	event.preventDefault();
	
	errores = '<ul>';
	
	if( !nomape_valido( $('#nombre') ) )
	{
		errores = errores + '<li>El nombre es obligatorio y debe tener solo letras</li>';
	}
	
	if( !nomape_valido( $('#apellido') ) )
	{
		errores = errores + '<li>El apellido es obligatorio y debe tener solo letras</li>';
	}
	
	if( !email_valido( $('#email') ) )
	{
		errores = errores + '<li>El email es obligatorio y debe tener el formato <i>usuario@dominio.com</i></li>';
	}
	
	if( !telefono_valido( $('#telefono') ) )
	{
		errores = errores + '<li>El número de teléfono es obligatorio, debe tener solo números y puede contener el signo + adelante</li>';
	}
	
	if( !comcar_valido( $('#empresa') ) )
	{
		errores = errores + '<li>El nombre de su empresa solo puede contener letras y números</li>';
	}
	
	if( !comcar_valido( $('#cargo') ) )
	{
		errores = errores + '<li>El nombre de su cargo solo puede contener letras y números</li>';
	}
	
	if( !comments_valido( $('#comentarios') ) )
	{
		errores = errores + '<li>Debe introducir algun comentario y este, solo puede contener letras números y los signos _ , y . </li>';
	}
	
	errores = errores + '</ul>';
	
	if( errores != '<ul></ul>')
	{
		$('#respuesta_form_contacto').html(errores);
		$('#respuesta_form_contacto').css("display", "inline-block");
	}else {
		var form = $(this);
        var str = form.serialize();
		$.ajax({
			type: "POST",
			url: "enviar_coments",
			data: str
		})
		.done(function( msg ) {
			$('#respuesta_form_contacto').html( msg );
			$('#respuesta_form_contacto').css("display", "inline-block");
		})
		.fail(function( msg ) {
			$('#respuesta_form_contacto').html( "Hubo un error enviando el formulario. Por favor, vuelva a intentarlo." );
			$('#respuesta_form_contacto').css("display", "inline-block");
		});
	
	}
});

/* Compra */
$( '#form_reg_pedido' ).submit( function( event ) {
	
	errores = '<ul>';
	
	if( !nomape_valido( $('#nombre') ) )
	{
		errores = errores + '<li>El nombre es obligatorio y debe tener solo letras</li>';
	}
	
	if( !nomape_valido( $('#apellido') ) )
	{
		errores = errores + '<li>El apellido es obligatorio y debe tener solo letras</li>';
	}
	
	if( !email_valido( $('#email') ) )
	{
		errores = errores + '<li>El email es obligatorio y debe tener el formato <i>usuario@dominio.com</i></li>';
	}
	
	if( !email_conf_valido( $('#email_conf') ) )
	{
		errores = errores + '<li>El email de confirmación no es el mismo.</i></li>';
	}
	
	if( !direccion_valida( $('#direccion') ) )
	{
		errores = errores + '<li>La dirección es obligatoria y solo puede contener letras, números y los signos - _ , . y #</i></li>';
	}
	
	if( !cp_valido( $('#cp') ) )
	{
		errores = errores + '<li>El cógido postal es obligatorio y debe contener de cuatro a cinco dígitos numéricos.</li>';
	}
	
	if( !telefono_valido( $('#telefono') ) )
	{
		errores = errores + '<li>El número de teléfono es obligatorio, debe tener solo números y puede contener el signo + adelante</li>';
	}
	
	errores = errores + '</ul>';
	
	if( errores != '<ul></ul>')
	{
		window.scrollTo(0,0);
		$('#mensaje').html( errores );
		$('#errores').slideDown("fast");
		return false;
	}else
	{		
		return true;
	}
	
});
