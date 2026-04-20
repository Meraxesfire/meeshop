
//------------------------------------LOGICA PARA PANTALLA INFORMES.PHP-------------------------

//CREACION de FILTROS DE BUSQUEDA DE INFORMES

const botonLupaInformes = document.getElementById("botonLupaInformes");

botonLupaInformes.addEventListener("click", function (e) {
    e.preventDefault();

    const formulario = e.target.closest("form");//busca el formulario mas cercano al elemento que disparó el evento para no poner dos eventos al mismo elemento.
    const datos = new FormData(formulario); //el objeto formData almacena el contenido del formulario.

    //Función fetch para aplicar los filtros a la tabla de informes y agregar html en la tabla sin recargar toda la pagina
    fetch('/meeshop/pantallas/filtro_informes.php', {
        method: 'POST',
        body: datos
    })
        .then(res => res.text())
        .then(html => {
            const tabla = document.querySelector(".cuerpoTablaInformes");
            if (tabla) {
                tabla.innerHTML = html;
            } else {
                console.error("No se encontró .cuerpoTablaInformes");
            }
        })
        .catch(err => console.error('Error', err));
})