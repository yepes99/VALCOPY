SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS valcopy;
CREATE DATABASE valcopy DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE valcopy;

CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    user VARCHAR(255),
    nombre VARCHAR(255),
    apellidos VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    telefono VARCHAR(255),
    direccion VARCHAR(255),
    ciudad VARCHAR(255),
    codigo_postal VARCHAR(255),
    pais VARCHAR(255),
    tipo_usuario ENUM('cliente', 'administrador'),
    fecha_alta DATETIME,
    fecha_baja DATETIME,
    foto_perfil VARCHAR(255)
);


CREATE TABLE categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255)
);

CREATE TABLE productos (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255),
    descripcion TEXT,
    categoria INT,
    precio DECIMAL(10,2),
    disponibilidad ENUM('disponible', 'agotado'),
    medidas VARCHAR(255),
    imagen VARCHAR(255),
    CONSTRAINT fk_categoria FOREIGN KEY (categoria) REFERENCES categorias(id_categoria)
);


CREATE TABLE pedidos (
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    fecha_pedido DATETIME,
    estado ENUM('pendiente', 'enviado', 'entregado', 'cancelado'),
    total DECIMAL(10,2),
    metodo_pago VARCHAR(255),
    transportista VARCHAR(255),
    numero_seguimiento VARCHAR(255),
    CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE lineas_pedido (
    id_linea_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT,
    id_producto INT,
    cantidad INT,
    precio DECIMAL(10,2),
    CONSTRAINT fk_pedido FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    CONSTRAINT fk_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE facturas (
    id_factura INT PRIMARY KEY AUTO_INCREMENT,
    id_pedido INT,
    fecha_factura DATETIME,
    total DECIMAL(10,2),
    iva DECIMAL(10,2),
    forma_pago VARCHAR(255),
    CONSTRAINT fk_pedido_factura FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido)
);

CREATE TABLE detalles_factura (
    id_detalle_factura INT PRIMARY KEY AUTO_INCREMENT,
    id_factura INT,
    id_producto INT,
    nombre_producto VARCHAR(255),
    cantidad INT,
    precio_unitario DECIMAL(10,2),
    CONSTRAINT fk_factura FOREIGN KEY (id_factura) REFERENCES facturas(id_factura),
    CONSTRAINT fk_producto_factura FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);