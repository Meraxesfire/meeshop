//------------------------------------LOGICA PARA PANTALLA VENTAS.PHP-------------------------

//LOGICA DE FILTRO DE INFO en la tabla de productos disponibles:
//primero buscamos el archivo que contiene el codigo de filtrado y la tabla donde se va a volcar todo
document.getElementById('contenido').addEventListener('submit', function (e){
    if (e.target && e.target.id === 'formDeFiltroVenta'){
        e.preventDefault();
        const datos = new FormData(e.target);//objeto formData: alamacena el contenido del target del evento disparado
        for(let[key,value] of datos.entries()){ //entries():convierte un objeto (formData) en arrays de pares clave-valor
        }
        fetch('pantallas/filtro_producto_venta.php',{
            method: 'POST',
            body:datos
        })
        .then(res =>{
            return res.text();
        })
        .then(html=>{
            const tabla = document.querySelector('#cuerpoTablaVenta');
            if(tabla){
                tabla.innerHTML = html;
            }else{
                console.error('No se encontró cuerpoTablaVenta');
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