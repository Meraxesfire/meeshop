
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de venta</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/tui1luo.css">
</head>
<body>

    <div>
        <h1 class="titulo">Punto de venta</h1>
    </div>
    <div class= "contenido_venta">   
        <div class="espacio1">
            <div class="busquedaProductos">
                <p class="tituloBuscar">Buscar producto</p>
                <div class="contenedorInputLupa">
                    <input class="caja_busqueda"name="busqueda" placeholder="Nombre del producto"></input>
                    <button class="botonLupa" data-tooltip="Buscar"><i class="fa-solid fa-magnifying-glass iconoLupa"></i></button>
                </div>
            </div>
            <div class="menuProductos">
                <p>Productos</p>
                <div class="burbujas_productos"> <!--  titulo + 4 clases (ropa, accesorios, alimentos, bebidas ,etc) -->
                    <button class="categoria catinicial">Ropa</button>
                    <button class="categoria">Accesorios</button>
                    <button class="categoria">Joyería</button>
                    <button class="categoria catfinal">Zapatos</button>
                </div>
            </div>
        </div>


        <div class ="espacio2">
            <p>Calculadora</p>
        </div>
    </div>
</body>
</html>