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




<!--El siguiente script es para cargar el contenido de las 
pantallas(opciones/botones)del menu en el espacio del div llamado "contenido".  -->

<script> /*ESTO ES JS*/
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

/* 2. Captura del envío del formulario (Delegación de eventos) */
// Usamos addEventListener en 'contenido' porque el formulario no existe al cargar la página
document.getElementById('contenido').addEventListener('submit', function(e) {
    // Verificamos si lo que se envió fue el formulario de agregar producto
    if (e.target && e.target.classList.contains('formAgregarProducto')) {
        e.preventDefault(); // EVITA que la página se recargue por completo

        const formData = new FormData(e.target);

        // Enviamos los datos por "detrás" (AJAX)
        fetch('pantallas/almacen.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indica al PHP que es una petición AJAX
            }
        })
        .then(res => res.text())
        .then(data => {
            // Una vez el PHP nos dice que terminó, recargamos solo el div de contenido
            // para mostrar la tabla actualizada con el nuevo producto
            return fetch('pantallas/almacen.php');
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('contenido').innerHTML = html;
        })
        .catch(err => console.error("Error en la petición:", err));
    }
});
</script>


<!--script para comprobar errores y status-:
<script>
document.querySelectorAll('.option').forEach(btn => {
    btn.addEventListener('click', function() {
        const nombre = this.getAttribute('name');
        const url = 'pantallas/' + nombre + '.php';
        
        console.log('Intentando cargar:', url); // Para debug
        
        fetch(url)
            .then(res => {
                console.log('Response status:', res.status); // Para debug
                return res.text();
            })
            .then(html => {
                console.log('HTML recibido:', html.substring(0, 100)); // Para debug
                document.getElementById('contenido').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error); // Para debug
            });
    });
});
</script>-->