<?php
session_start();
//Si no hay sesión activa, redirige al login:
if (!isset($_SESSION['empleada'])){
    header("location:index.php");
    exit();
}

$empleada=$_SESSION['empleada'];
?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Menu principal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/tui1luo.css">
</head>
<body class="body_dashboard">
        <div class= "menu_bienvenida">
            <img class="logo_menu" src="images/logo_cropped_final.png">
            <button class="option" name="venta">Punto de venta</button>
            <button class="option" name="informes">Informes</button>
            <button class="option"name="almacen">Almacen</button>
            <button class="option" name="configuracion">Configuracion</button>
            <form class="logout" action="logout.php" method="post">
                <button class="logout-btn" data-tooltip="Cerrar sesión">
                <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
            <div id="contenido" class="contenido_dashboard">           
            </div>
        </div>
</body>
</html>

<!-------------------------------LOGICA DE CARGA DE PANTALLAS PARA hacer  una SPA (Sigle Page App)----------------------------------------------------------------------------

El siguiente script es para cargar el contenido de las 
pantallas(opciones/botones)del menu en el espacio del div llamado "contenido".  -->

<script> /*ESTO ES JS: hace que cada boton se identifique con una pantalla a cargar en el div #contenido*/
document.querySelectorAll('.option').forEach(btn => {
    btn.addEventListener('click', function() {
        const nombre = this.getAttribute('name');
        fetch('pantallas/' + nombre + '.php')
            .then(res => res.text())
            .then(html => {
                document.getElementById('contenido').innerHTML = html;
            });
    });
});

//----------------------------------------- LOGICA PARA PANTALLA ALMACEN------------------------------------------------------------------------------
/*LOGICA DE FILTRO DE PALABRAS, EAN Y CATEGORIA.--
En Dashboard recibe el codigo de ejecución de la query que está en almacen.php y procesa el html desde aqui     
A CONTINUACION: CODIGO JS PARA QUE EL FILTRADO DE LA TABLA SE REALICE CON FETCH (AJAX) Y SEA DINAMICO SINN RECARGAR TODA LA PÁGINA
Para ello eliminamos el 'method' y el 'action' del formulario que hace submit al filtrado de datos y añadimos "addEventListener"
al boton submit del filtrado y le asignamos una función para hacer más limpio el codigo html -*/ 
    
document.getElementById('contenido').addEventListener('submit', function(e) {
    // 1. Log de control: ¿Entra el evento al contenedor?
    console.log("Evento submit detectado en el contenedor.");
    
    // 2. Averiguar si: ¿Es el formulario que buscamos?
    if (e.target && e.target.id === 'formDeFiltro') {
        e.preventDefault();
        console.log("Formulario de filtro interceptado.");

        const datos = new FormData(e.target);
        // 3. Ver qué estamos enviando
        for (let [key, value] of datos.entries()) {
        }
        fetch('pantallas/filtro_productos.php', { //usamos fetch para es
            method: 'POST',
            body: datos
        })
        .then(res => {
            return res.text();
        })
        .then(html => {
            const tabla = document.querySelector('.cuerpoTabla');
            if (tabla) {
                tabla.innerHTML = html;
            } else {
                console.error("No se encontró .cuerpoTabla");
            }
        })
        .catch(err => console.error("Error", err));
    }
});


// RECARGAR la pantalla del almacén (usada al terminar de editar los datos con la funcion de edicion inline de los productos registrados)
function recargarPantallaAlmacen() {
    fetch('pantallas/almacen.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('contenido').innerHTML = html;
        })
        .catch(err => console.error("Error al recargar la pantalla de almacén:", err));
}

// CAPTURA PRODUCTO DEL ALMACEN (BBDD) AL HACER SUBMIT EN EL FORM y envia datos por AJAX a almacen.php --NO CAPTURA LOS DATOS SINO EL SUBMIT--
/*Este codigo se crea AQUI y no en almacen.php porque JS hace que el navegador busque en el momento de ejecución y al cargar la pagina almacen no está activa primeramente por defecto.
ponerlo en el dashboard.php hace que el listenner esté atento a cuando cargue almacen.php en el dashboard.
Uso addEventListener en 'contenido' porque no existe pantalla cargada por defecto al cargar la página*/

document.getElementById('contenido').addEventListener('submit', function(e) {
    // Verificamos si lo que se envió fue el formulario de agregar producto
    if (e.target && e.target.classList.contains('formAgregarProducto')) { //PERO SOLO EJECUTA ESTE CODIGO PARA SUBMIT SI SUBMIT TIENE la clase 'formAgregarProducto'!!!!! NO HAY PELIGRO de uso en otra pantalla
        e.preventDefault(); // EVITA que la página se recargue por completo
        
        const formData = new FormData(e.target);

        // Envia los datos asincronos con fetch (AJAX)
        fetch('pantallas/almacen.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indica que es una petición AJAX
            }
        })
        .then(res => res.text()) //.then es una herramienta asincrona:usa '.' sobre el objeto Promise para ofrecer una respuesta a cada camino posible de esa respuesta (eso serán los parametros de .then)
                                //PRIMER .THEN: Cuando la peticion HTTP se complete
                                //'res' es la respuesta del servidor.
        .then(data => { //SEGUNDO .THEN: cuando ya tenemos el texto de la primera respuesta.
                        //'data' es el texto que devuelve 'almacen.php'.
            return fetch('pantallas/almacen.php');// Cuando res termina, recargamos solo el div de contenido para mostrar la tabla actualizada con el nuevo producto
        })
        .then(res => res.text())//TERCER .THEN: Usa el resultado de la ultima promesa del return
        .then(html => { //CUARTO .THEN: Cuando la carga del html se completa actualizada incluyendo el texto de la tercera promesa.
            document.getElementById('contenido').innerHTML = html;
        })
        .catch(err => console.error("Error en la petición:", err));
    }
});

// EDICION INLINE de ciertas columnas de PANTALLA ALMACEN (se reflejan en la bbdd)
document.addEventListener('click', e => {
    let btn = e.target.closest('.botonEditar');
    if (!btn) return;

    let celda = btn.closest('[data-id]');
    let span = celda.querySelector('.texto-editable');
    let oldVal = span.innerText;
    let columna = celda.dataset.columna;


    let input = document.createElement('input');
    input.value = celda.dataset.columna == 'precio' ? parseFloat(oldVal) : oldVal;//.dataset es un objeto con todos los atributos de "data-*" (en este caso data-id)
        //aqui se hace una comparación con == y operador ternario (?,:)
    input.className = 'caja_busqueda_editable';//aplica clase a input parq que se vea distinto

    if (columna == 'categoria'){ //Aqui lógica del CASO del data-set'CATEGORIA' ya que para ese caso quiero, al editar, un desplegable para evitar errores del usuario en la bbdd que rompan el flujo.------------------------------------------
		let select = document.createElement('select');
		select.className='caja_busqueda_editable';
		
		let opciones = ['ropa','accesorios','joyeria', 'zapatos'];//definimos qué opciones serán las que aparezcan en el neuvo select
		opciones.forEach(cat =>{ 								//para cada opcion le damos un 'option' como valor de categoria
			let option = document.createElement('option'); 		//primero creamos la variable opcion y a su valor le daremos el calor de cada categoria que entra por parametro.
			option.value=cat;									//el valor de la opcion será el del parametro (nombre de categoria)
			option.textContent=cat;								//al texto interno tambien le damos el value de categoria que entra por parametro.
			if(cat==oldVal)option.selected=true;
			select.appendChild(option);							//añadimos la opcion de aquella sobre la que está iterando el foreach en este momento.
		});
        span.style.display='none'; 								//Aquí le borro el estilo por defecto para añadirle
		celda.insertBefore(select, btn);						//reemplazamos span por select
		select.focus();
		
		select.onchange =function(){ 							//Logica para guardar al seleccionar onchange
			if(this.value!==oldVal){
				fetch('pantallas/actualizar_producto.php',{
					method:'POST',
					headers:{'Content-Type':'application/x-www-form-urlencoded'},
					body: `id=${celda.dataset.id}&columna=categoria&valor=${this.value}`
				})
				.then(()=>{
					recargarPantallaAlmacen();
				});
				span.innerText = this.value;
			}
			this.remove();
			span.style.display='';
		};
		 select.onblur = function() { //Esto confirma la edición es para perder el foco.
		  this.remove();
		  span.style.display = '';
		};
		return;


   }else{ //Si no es data-set 'categoria' añadimos un input para el editbale.
		 let input = document.createElement('input');
		  input.value = celda.dataset.columna == 'precio' ? parseFloat(oldVal) : oldVal;//.dataset es un objeto con todos los atributos de "data-*" (en este caso data-id)																	//aqui se hace una comparación con == y operador ternario (?,:)
		  input.className = 'caja_busqueda_editable';//aplica clase a input parq que se vea distinto
		  
		  span.style.display = 'none';
		  celda.insertBefore(input, btn);//insertBefore inserta ntes de, en este caso, antes del btn
		  input.focus();				//coloca el cursor dentro del input para que sea intuitivo para el usuario
		 
		  
		  input.onkeydown = e => {		 //onkeydown hace acción cuando una tecla es presionada (en este caso crea evento "e")
				if (e.key != 'Enter') return;//e.key indica qué tecla pulsó, y si NO es Enter sale del evento.
				e.preventDefault();			//evita el comportamiento automatico de enter
				
				//A continuación ENVIAR DATOS AL SERVIDOR y se postean en la bbdd modificados.
				if (input.value != oldVal) {//si el valor antiguo no es igual al nuevo:
				  fetch('pantallas/actualizar_producto.php', {
					method: 'POST',			//post es mas seguro para enviar datos de un form a una bbdd
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},// indica que los datos se enviaran en formato estandar de formulario HTML
					body: `id=${celda.dataset.id}&columna=${celda.dataset.columna}&valor=${input.value}`//template, id de producto y nombre de la columna que lo contiene asi como el valor.
					})
					.then(res=>{
						if(res.ok){
							//todo lo que vaya a cambiar en la pantalla va aqui
							span.innerText = input.value; //actualiza valor al añadido en el input visualmente
							recargarPantallaAlmacen();
						}
					})
				  .catch(err =>console.error("Error en comunicacion:", err)); //controlar el error y mostrar aviso
				}
			};
				input.onblur = () => {//.onblur indica que se da el evento cuando el input pierde el foco(click fuera)
				input.remove(); //elimina el input y muestra el span
				span.style.display = '';
				};
		}
});

</script>
