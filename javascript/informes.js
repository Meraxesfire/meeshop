
//------------------------------------LOGICA PARA PANTALLA INFORMES.PHP-------------------------

//CREACION de FILTROS DE BUSQUEDA DE INFORMES

const botonLupa = document.getElementById("botonLupaInformes");
const formulario = document.querySelector(".formularioInformes");

if (!botonLupa) {
    console.error("No se encontró el botón botonLupaInformes");
} else if (!formulario) {
    console.error("No se encontró el formulario");
} else {
    botonLupa.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("Botón lupa clickeado");

        const datos = new FormData(formulario);

        //Función fetch para aplicar los filtros a la tabla de informes y agregar html en la tabla sin recargar toda la pagina
        fetch('pantallas/filtro_informes.php', {
            method: 'POST',
            body: datos
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.text();
            })
            .then(html => {
                const tabla = document.querySelector(".cuerpoTablaInformes");
                if (tabla) {
                    tabla.innerHTML = html;
                    console.log("Tabla actualizada");
                } else {
                    console.error("No se encontró .cuerpoTablaInformes");
                }
            })
            .catch(err => console.error('Error en fetch:', err));
        
        return false;
    });
}