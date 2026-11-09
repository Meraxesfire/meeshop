CREATE TABLE IF NOT EXISTS empresa (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS empleadas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    usuario VARCHAR(80) NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    id_empresa INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_empleadas_usuario (usuario),
    CONSTRAINT fk_empleadas_empresa FOREIGN KEY (id_empresa) REFERENCES empresa (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS productos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    EAN VARCHAR(32) NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    categoria VARCHAR(60) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    iva DECIMAL(5, 2) NOT NULL DEFAULT 21,
    PRIMARY KEY (id),
    UNIQUE KEY uq_productos_ean (EAN)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ventas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_empleada INT UNSIGNED NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    CONSTRAINT fk_ventas_empleada FOREIGN KEY (id_empleada) REFERENCES empleadas (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS detalle_ventas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_venta INT UNSIGNED NOT NULL,
    id_producto INT UNSIGNED NOT NULL,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_detalle_venta FOREIGN KEY (id_venta) REFERENCES ventas (id),
    CONSTRAINT fk_detalle_producto FOREIGN KEY (id_producto) REFERENCES productos (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO empresa (id, nombre)
VALUES (1, 'Meeshop Demo');

INSERT IGNORE INTO empleadas (id, nombre, usuario, contraseña, id_empresa)
VALUES (1, 'Usuario de demostración', 'demo', 'meeshop-demo', 1);

INSERT IGNORE INTO productos (EAN, nombre, categoria, precio, stock, iva) VALUES
    ('8400000000011', 'Bolso de lino', 'accesorios', 29.90, 12, 21),
    ('8400000000028', 'Camiseta básica', 'ropa', 14.50, 25, 21),
    ('8400000000035', 'Collar dorado', 'joyeria', 19.95, 8, 21),
    ('8400000000042', 'Zapatillas urbanas', 'zapatos', 49.90, 6, 21),
    ('8400000000059', 'Bufanda de invierno', 'ropa', 18.00, 15, 21),
    ('8400000000066', 'Pendientes aro', 'joyeria', 12.75, 20, 21),
    ('8400000000073', 'Cartera compacta', 'accesorios', 22.00, 10, 21),
    ('8400000000080', 'Botines clásicos', 'zapatos', 64.90, 4, 21);

INSERT IGNORE INTO ventas (id, id_empleada, fecha, total) VALUES
    (1, 1, '2026-10-12 10:30:00', 51.61),
    (2, 1, '2026-10-18 15:45:00', 17.55),
    (3, 1, '2026-10-25 12:10:00', 84.52);

INSERT IGNORE INTO detalle_ventas (id, id_venta, id_producto, cantidad, subtotal) VALUES
    (1, 1, 1, 1, 36.18),
    (2, 1, 6, 1, 15.43),
    (3, 2, 2, 1, 17.55),
    (4, 3, 4, 1, 60.38),
    (5, 3, 3, 1, 24.14);
