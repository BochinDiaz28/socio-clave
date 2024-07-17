

//FUNCION GENERAL DE FECHAS
function InvertirFecha(fecha) {
	//INVERTIR FECHA SALVADO LA HORA
    var nueva  = fecha.split(" ")[0]; //tomo la fecha
    var hora   = fecha.split(" ")[1]; //tomo la hora
		hora   = hora.substr(0,5); //quito las sentecimas a la hora
    var format = nueva.split("-"); //tomo yy-mm-dd separados por guion
    var ultima = format[2]+'-'+format[1] +'-'+format[0] //invierto el formato a hora legible
    return ultima+' '+hora; //retorno nuevo formato y hora.
}
function InvertirFechaCorta(fecha){
	//INVERTIR FECHA CORTA
	var nueva  = fecha.split(" ")[0]; //tomo la fecha
	var format = nueva.split("-"); //tomo yy-mm-dd separados por guion
	var ultima = format[2]+'-'+format[1] +'-'+format[0] //invierto el formato a hora legible
	return ultima; //retorno nuevo formato
	
}
function MesATexto(fecha) {
    //ENVIAR LA FECHA EN FORMATO BD
    var mes       = fecha.split("-")[1]; 
	var meses     = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oc", "Nov", "Dic"];
	var numeroMes = parseInt(mes);
	if(! isNaN(numeroMes) && numeroMes >= 1  && numeroMes <= 12 ) {
		var ElMesEs = meses[numeroMes - 1];
	}
    return ElMesEs;
}
function TomarDia(fecha) {
    //ENVIAR LA FECHA EN FORMATO BD
    var diayhora = fecha.split("-")[2]; 
	var dia      = diayhora.split(" ")[0]; 
    return dia;
}

function calculateAge(birthday) {
	var birthday_arr = birthday.split("-");
	var birthday_date = new Date(birthday_arr[2], birthday_arr[1] - 1, birthday_arr[0]);
	var ageDifMs = Date.now() - birthday_date.getTime();
	var ageDate = new Date(ageDifMs);
	return Math.abs(ageDate.getUTCFullYear() - 1970);
}
//FIN FUNCIONES DE FECHAS


function NumeroChile(amount,decimals){
	amount += ''; // por si pasan un numero en vez de un string
	amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

	decimals = decimals || 0; // por si la variable no fue fue pasada

	// si no es un numero o es igual a cero retorno el mismo cero
	if (isNaN(amount) || amount === 0) 
		return parseFloat(0).toFixed(decimals);

	// si es mayor o menor que cero retorno el valor formateado como numero
	amount = '' + amount.toFixed(decimals);

	var amount_parts = amount.split('.'),
		regexp = /(\d+)(\d{3})/;

	while (regexp.test(amount_parts[0]))
		amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

	return amount_parts.join('.');
}

function calculateTimeDifference(checkin, checkout) {
	// Convertir las cadenas de fecha y hora a objetos Date
	let checkinDate = new Date(checkin);
	let checkoutDate = new Date(checkout);

	// Calcular la diferencia en milisegundos
	let differenceInMillis = checkoutDate - checkinDate;

	// Convertir la diferencia de milisegundos a minutos
	let differenceInMinutes = Math.floor(differenceInMillis / (1000 * 60));

	// Calcular horas y minutos
	let hours = Math.floor(differenceInMinutes / 60);
	let minutes = differenceInMinutes % 60;

	// Formatear la respuesta
	let result;
	if (hours > 0) {
		result = `${hours}h:${minutes}min`;
	} else {
		result = `${minutes} minutos`;
	}

	return result;
}
