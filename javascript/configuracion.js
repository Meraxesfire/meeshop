const form = document.getElementById('formNuevaEmpleada');

if (form) {
	form.addEventListener('submit', function (e) {
		// Aquí puedes validar campos antes de enviar si lo necesitas.
		// No bloqueamos otros forms del dashboard, solo este.
	});
}