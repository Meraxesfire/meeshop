//------------------------------------LOGICA PARA PANTALLA VENTAS.PHP-------------------------

//LOGICA DE FILTRO DE INFO en la tabla de productos disponibles:
//primero buscamos el archivo que contiene el codigo de filtrado y la tabla donde se va a volcar todo
document.getElementById('formDeFiltroVenta').addEventListener('submit', function (e) {
    if (e.target && e.target.id === 'formDeFiltroVenta') {
        e.preventDefault();
        const datos = new FormData(e.target);//objeto formData: alamacena el contenido del target del evento disparado

        fetch('pantallas/filtro_producto_venta.php', {
            method: 'POST',
            body: datos
        })
            .then(res => res.text())
            .then(html => {
                const tabla = document.querySelector('#cuerpoTablaVenta');
                if (tabla) {
                    tabla.innerHTML = html;
                }
            })
            .catch(err => console.error('Error', err));
    }
});

function recargarPaginaVentas() { //función para recargar la página al filtrarse
    fetch('../pantallas/ventas.php')
        .then(res => res.text())
        .then(html => {
            document.querySelector('.contenido').innerHTML = html
        })
        .catch(err => console.error('Error cargando contenido de tabla despues de filtrar'));//control para saber si se cargó la paginaó
};




//METER PRODUCTOS EN CARRITO -----evento del botón '+' junto a linea de producto: 
// click en boton más y se añade al carrito--------------

const contenedorVenta = document.getElementById('cuerpoEspacioVenta');

if (contenedorVenta) { //si existe el contenedor.

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('botonAnadirProducto')) { //busca el elemento html que sea objetivo del evento y que contenga la clase botonAnadirProducto

            var fila = e.target.closest('tr'); //guardo el tr mas cercano al elemento html que se le aplique el evento (e.target)
            var celdas = fila.querySelectorAll('td.datoEditableVentas');//sacamos todas las celdas de cada fila y crea una NODELIST (no es array aunque usa length)
            var datos = [];//esto será el contenedor para ir pintando lo que almacene de cada celda de fila.

            for (var i = 0; i < celdas.length; i++) { //iteración sobre cada celda (td) de cada tr para que var datos se vaya llenando y vaya pintando el valor
                var texto = celdas[i].querySelector('.textoVentas');//textoVentas.textContent nos va a dar el valor de cada  dato
                if (texto) {
                    datos[i] = texto.textContent.trim();//si existe el contenido, datos, almacena lo que tiene el span de la tabla(.textoVentas)
                } else {
                    datos[i] = celdas[i].textContent.trim();//si no existe el contenido, datos, almacena lo que tiene el td (para los casos de iva, stock y pvp)
                }
            }

            // Fragmento para buscar si este EAN ya esta en el carrito
            var carrito = document.getElementById('cuerpoEspacioVenta');//buscamos el espacio en el que hay que mirar
            var filasCarrito = carrito.querySelectorAll('tr'); //buscamos los elementos tr dentro del espacio que está pinntandolos
            var yaEsta = false;  // esat variable es aconsejada para usar como interruptor de "encendido apagado" de la funcion, se usa si no existe lo que estamos buscando

            for (var j = 0; j < filasCarrito.length; j++) {
                var tdEAN = filasCarrito[j].querySelectorAll('td')[1];//aquí se alamacena el contenido del [1] del array de datos osea el EAN del tr que esté en el cuerpoEspacioVenta

                if (tdEAN && tdEAN.textContent.trim() === datos[0]) { //AQUI LA LOGICA PARA SABER SI ESTÁ O NO.
                    //Empezar con la condicion verdadera 
                    // ya que asíno pintamos por defecto todo. Al ejecutar primero el FOR
                    //antes que el if(!yaEsta) da la posibilidad de buscar amtes y poner el estado true al 
                    //boolean de estado, permitiendo que SI NO (!yaEsta) está se pinte la fila entera.

                    // Si coincide la condición Sumamos 1 a la cantidad (columna 0 del nuevaFila.innerHTML que hay en la condición en negativo del if) 
                    var tdCantidad = filasCarrito[j].querySelectorAll('td')[0];
                    var actual = parseInt(tdCantidad.textContent) || 1;
                    tdCantidad.textContent = actual + 1;

                    yaEsta = true;  // Aquí usamos la variable yaesta para controlar la otra opcion de que no esté la linea que necesitamos. marcamos que sí está
                    break;          // salimos del bucle, ya se ha terminado.
                }
            }

            //Si NO estaba en ninguna fila, creamos la nueva
            if (!yaEsta) { //ponemos el !yaesta despues del for para que por defecto no pinte todo ya que el valor por defecto es false.
                var nuevaFila = document.createElement('tr');
                nuevaFila.classList.add('filaVenta');//le añado esta clase para manejar el estilo de las filas
                nuevaFila.innerHTML =
                    '<td class="datoVenta" id="cantidadProducto">1</td>' +
                    '<td class="datoVenta">' + datos[0] + '</td>' +
                    '<td class="datoVenta">' + datos[1] + '</td>' +
                    '<td class="datoVenta">' + datos[2] + '</td>' +
                    '<td class="datoVenta">' + datos[3] + '</td>' +
                    '<td class="datoVenta">' + datos[5] + '</td>' +
                    '<td class="datoVenta"id="precioProducto">' + datos[6] + '</td>' +
                    '<td><button class="botonMenos" style="border:none;color:white;padding:5px 10px;border-radius:10px;cursor:pointer;">-</button></td>';
                //El ultimo elemento es un boton que tendrá la función de eliminar la fila.
                carrito.appendChild(nuevaFila);
            }

            //prueba de funcionamiento de data-id (que está oculto) para mas tarde usarlo como clave para la bdd de la tabla de venta y detalles_venta
            //--------------------
            if (e.target.classList.contains('botonAnadirProducto')) {
                const filaCerca = e.target.closest('tr');
                const idFila = filaCerca.dataset.id;
                nuevaFila.dataset.id = idFila;
                alert("producto con id:" + idFila);
            }
        }

        // FUNCION PARA ELIMINAR DEL CARRITO
        if (e.target.classList.contains('botonMenos')) { //buscamos si existe el objetivo de evento con clase botonMenos
            var fila = e.target.closest('tr'); //guardamos la fila que lo contiene
            if (fila) fila.remove(); //borramos la fila que lo contiene.
        }
    });

}

//---------CALCULAR EL TOTAL DE LA VENTA---------
document.addEventListener('click', function () {
    calcularTotalVenta();
});
function calcularTotalVenta() {
    let total = 0; //el total empieza en  0
    let carrito = document.getElementById('cuerpoEspacioVenta');
    let filasCarrito = carrito.querySelectorAll('tr');
    for (let i = 0; i < filasCarrito.length; i++) { //itera tantas veces como filas tenga la tabla
        let cantidadProducto = filasCarrito[i].querySelectorAll('td')[0]; //cantidad del producto
        let precioProducto = filasCarrito[i].querySelectorAll('td')[6]; //precio del producto
        total += parseFloat(cantidadProducto.textContent) * parseFloat(precioProducto.textContent.replace(',', '.')); //hago el replace porque al mostrar mis decimales con "," el parseFloat solo interpreta hasta la "," y necesita "." para entenderlo como float
    }
    document.getElementById('totalVentaCantidad').textContent = total.toFixed(2);
}

//---------BOTON FINALIZAR VENTA ------------------------------------------------------------------------------------
//El boton finalizar venta genera un archivo con el ticket de la venta y lo envia a la bdd

const botonFinalizar = document.getElementById('botonFinalizarVenta');

//1º) enviar datos de la venta a bbdd (tabla ventas y detalles de venta)
botonFinalizar.addEventListener('click', async () => {
    //--envio a tabla ventas--
    const filasCarrito = document.querySelectorAll('#cuerpoEspacioVenta tr'); //capturo las filas que haya en el carrito
    //uso queryselectorall para que devuelva una nodelist y poder recorrela con .length

    //Verifico si hay productos en el carrito
    if (filasCarrito.length === 0) {
        alert("No hay productos en el carrito de venta");//avisamos de que no hay nada para enviar
        return;
    }

    //Ahora verifico que el metodo de pago esté seleccionado, aunque no lo voy a guardar, quizas más adelante si lo haga.
    const metodoPago = document.querySelector('input[name="metodoDePago"]:checked')?.value;
    if (!metodoPago) {
        alert("Por favor, selecciona un método de pago.");
        return;
    }

    const productosParaEnviar = [];
    //A continuación iteramos con un foreach cada fila para sacar la ID y la cantidad de los productos en carrito.
    //Es lo unico que saco del JS, ya que el resto de datos los obtengo de la bbdd en el archivo finaliza_ventas.php.
    filasCarrito.forEach(fila => {
        productosParaEnviar.push({
            id: fila.dataset.id, //el dato del dataset que introducimos en este js de modo oculto para poder extraerlo facilmente
            cantidad: parseInt(fila.querySelector('#cantidadProducto').textContent),
        });
    });

    //Ahora ENVÍO CON FETCH los datos de productosParaEnviar a la pantalla finaliza_ventas.php
    //para que pueda hacer las consultas a la bdd y guardar los datos en las tablas ventas y detalles_venta.
    //Uso un bucle try, catch para manejar posibles errores.
    try {
        //envio los datos de productosParaEnviar a la pantalla finaliza_ventas.php
        const response = await fetch('pantallas/finalizar_ventas.php', { //fetch inicia una petición de red hacia un endpoint 
            //devuelve una promesa que se resuelve en el objeto response(respuesta del servidor)
            //await: pausa la función hasta tener respuesta de servidor
            method: 'POST',//indica el metodo http que voy a usar
            headers: { 'Content-Type': 'application/json' }, //indica el tipo de contenido que voy a enviar
            body: JSON.stringify({ //convierte el objeto JS en una cadena JSON para enviarlo
                productos: productosParaEnviar, //envio el array de productos
                metodo: metodoPago //envio el metodo de pago
            })
        })

        const data = await response.json(); //convierte la respuesta del servidor en un objeto JS porque primero lo enviamos como JSON 
        //para que lo entienda el servidor.

        if (data.success) {
            alert("¡Venta realizada! ID: " + data.idVenta);
            // Aquí llamarás al PDF más adelante
            location.reload(); // Por ahora recargamos para limpiar todo
        } else {
            alert("Error: " + data.error);
        }

    } catch (err) {
        console.error("Error en la comunicación:", err);
    }


    //Este ultimo bloque borra los elementos del carrito para poder realizar una nueva venta al pulsar FINALIZAR VENTA
    const cuerpoEspacioVenta = document.getElementById('cuerpoEspacioVenta');
    cuerpoEspacioVenta.innerHTML = '';
    document.getElementById('totalVentaCantidad').textContent = '0.00';

});
