<?php
session_start();
//Si no hay sesión activa, redirige al login:
if (!isset($_SESSION['empleada'])) {
    header("location:index.php");
    exit();
}

$empleada = $_SESSION['empleada'];
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

<!-------------------------------LOGICA DE CARGA DE PANTALLAS PARA hacer  una SPA (Sigle Page App)---------------------------------------------------------------------------->

<!--CARGA DE CONTENIDO DE PANTALLAS EN DIV DE DASHBOARD PARA HACER LA SPA de las  
pantallas(opciones/botones) y su js correspondiente del menu en el espacio del div llamado "contenido".-->

<script>
function cargarPantalla(nombre) { //nombre=nombre del archivo que cargará
    fetch('pantallas/' + nombre + '.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('contenido').innerHTML = html;

            // Gestión del Script Dinámico porque debe cambiar con cada pantalla para que el navegador no guarde la ejecución de la pantalla anterior
            //Esto es así por que: El navegador parsea el HTML pero ignora los <script> que vienen en ese contenido. 
            // Por eso venta.js nunca se ejecuta cuando está incluido como etiqueta en venta.php. debe incluirse aqui
            const scriptID = 'script-pantalla';
            const viejoScript = document.getElementById(scriptID);
            if (viejoScript) viejoScript.remove();

            const nuevoScript = document.createElement('script'); //crea un script en el documento que trae a la pantalla de dashboard.php
            nuevoScript.id = scriptID;                            //sustituimos un script por otro ya que al cragar cada pantalla el navegador sigue cargando el script de la pantalla que haya estado antes
            nuevoScript.src = 'javascript/' + nombre + '.js?v=' + Date.now(); // Al usar date.now carga siempre los milisegundos que es lo unico que asegura que sea una pagina nueva completamente evitando asi que cargue un caché y forzanmdolo a cargar una nueva pagina
            nuevoScript.type = 'text/javascript';
            document.body.appendChild(nuevoScript);
        })
        .catch(err => console.error("Error al cargar:", err));
}

// Evento para los botones del menú
document.querySelectorAll('.option').forEach(btn => { //por cada option carga la pagina php y crea su script gracias a la funcion cargarPantalla("atributo nombre de la pantalla en cuestion que es el mismo nombre en el boton")
    btn.addEventListener('click', function() {
        cargarPantalla(this.getAttribute('name'));
    });
});

// Carga inicial por defecto
window.onload = () => cargarPantalla('venta');
</script>









