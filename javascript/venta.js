//------------------------------------LOGICA PARA PANTALLA VENTAS.PHP-------------------------

//LOGICA DE FILTRO DE INFO en la tabla de productos disponibles:
//primero buscamos el archivo que contiene el codigo de filtrado y la tabla donde se va a volcar todo
document.getElementById('contenido').addEventListener('submit', function (e){
    if (e.target && e.target.id === 'formDeFiltroVenta'){
        e.preventDefault();
        const datos = new FormData(e.target);//objeto formData: alamacena el contenido del target del evento disparado

        fetch('pantallas/filtro_producto_venta.php',{
            method: 'POST',
            body:datos
        })
        .then(res => res.text())
        .then(html=> {
            const tabla = document.querySelector('#cuerp    oTablaVenta');
            if(tabla){

                tabla.innerHTML = html;
            }
        })
        .catch(err => console.error('Error', err));
    }
});

function recargarPaginaVentas(){ //función para recargar la página al filtrarse
    fetch('../pantallas/ventas.php')
    .then(res => res.text())
    .then(html => {document.querySelector('.contenido').innerHTML=html
    })
.catch(err=>console.error('Error cargando contenido de tabla despues de filtrar'));
}





//METER PRODUCTOS EN CARRITO -----evento del botón '+' junto a linea de producto: click en boton más y se añade al carrito

document.addEventListener('click', function(e){//uso addEventListener porque la tabla se carga dinamicamente y no existen los botons de + por defecto.
    if(e.target.classList.contains('botonAnadirProducto')){ //si el boton se encuentra y se pulsa....
        var fila = e.target.closest('tr');//buscar la fila (tr) del producto deonde está el botón pulsado

        var datos=[]; //aqui el array que almacenará los datos
        var celdas = fila.querySelectorAll('td.datoEditableVentas');

        for(i=0;i<celdas.length;i++){ //aquí iteramos para guardar cada elemento del producto
            var texto = celdas[i].querySelector('.textoVentas'); //por si tiene span con texto
            if(texto){
                datos[i] =texto.textContent.trim(); //guarda el dato de la posicion que itera en la posicion correspondientr del array datos que he creado
            }else{
                datos[i] = celdas[i].textContent.trim();
            }
        }

        var nuevaFila = document.createElement('tr');//creo un nuevo elemento de dom en este caso un tr
        nuevaFila.innerHTML= //Añado los elementos al tr que se va a crear
           '<td>1</td>'+ 
           '<td>'+datos[0]+'</td>'+
           '<td>'+datos[1]+'</td>'+
           '<td>'+datos[2]+'</td>'+
           '<td>'+datos[3]+'</td>'+
           //no pongo stock saltamos ese dato [4]
           '<td>'+datos[5]+'</td>'+
           '<td>'+datos[6]+'</td>'+
           '<td><button class="botonMenos" style="background:#dc3545;border:none;color:white;padding:5px 10px;border-radius:10px;cursor:pointer;">-</button></td>'
        //Ahora añado la fila creada al espacio de carrito

        var carritoVenta = document.getElementById('cuerpoEspacioVenta');

            if (carritoVenta){
                carritoVenta.appendChild(nuevaFila);
            }
        }


        //borrar producto del carrito:
        // ========================================
    // ELIMINAR PRODUCTO DEL CARRITO (botón -)
    // ========================================
    
    // ¿Se ha pulsado un botón "-"?
    if (e.target.classList.contains('botonMenos')) {
        
        // Borramos la fila completa donde está el botón
        var filaABorrar = e.target.closest('tr');
        if (filaABorrar) {
            filaABorrar.remove();
        }
    }
});