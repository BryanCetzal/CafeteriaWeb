-- Crear la tabla de Categorías
CREATE TABLE 'Categorias' (
    'id_categoria' INT PRIMARY KEY,
    'nombre_categoria' VARCHAR(255),
    'Tamaño' VARCHAR(255),
    'Leche' VARCHAR(255)
);

-- Crear la tabla de Productos
CREATE TABLE 'Productos' (
    `id_producto` int(11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `details` varchar(500) NOT NULL,
    `price` int(10) NOT NULL,
    `image_01` varchar(100) NOT NULL
    'categoria' int(1), NOT NULL
    FOREIGN KEY ('id_categoria') REFERENCES 'Categorias'('id_categoria')
);

ALTER TABLE `Productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

-- Crear la tabla de Características del Producto
CREATE TABLE 'Caracteristicas_Producto' (
    'id_caracteristica' INT PRIMARY KEY,
    'id_producto' INT,
    'nombre_caracteristica' VARCHAR(255),
    'valor_caracteristica' VARCHAR(255),
    FOREIGN KEY ('id_producto') REFERENCES 'Productos'('id_producto')
);

-- Insertar datos de ejemplo

-- Insertar categorías
INSERT INTO 'Categorias' ('id_categoria', 'nombre_categoria', 'Tamaño', 'Leche')
VALUES
    (1, 'Cafés', 'Intenso', 'Grano Entero'),
    (2, 'Postres', 'Chocolate', 'Dulce');

-- Insertar productos
INSERT INTO Productos (id_producto, nombre_producto, precio, id_categoria)
VALUES
    (1, 'Café Espresso', 2.5, 1),
    (2, 'Tarta de Chocolate', 15.99, 2);

-- Insertar características de productos
INSERT INTO Caracteristicas_Producto (id_caracteristica, id_producto, nombre_caracteristica, valor_caracteristica)
VALUES
    (1, 1, 'Tamaño', 'Mediano'),
    (2, 1, 'Leche', 'Entera'),
    (3, 2, 'Tamaño', 'Grande');


