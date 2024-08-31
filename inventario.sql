-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS inventario;
USE inventario;

-- Tabla `categoria`
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `categoria_id` INT(11) NOT NULL AUTO_INCREMENT,
  `categoria_nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla `usuario`
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `usuario_id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_nombre` VARCHAR(40) NOT NULL,
  `usuario_apellido` VARCHAR(40) NOT NULL,
  `usuario_usuario` VARCHAR(20) NOT NULL,
  `usuario_clave` VARCHAR(200) NOT NULL,
  `usuario_email` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla `producto`
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `producto_id` INT(11) NOT NULL AUTO_INCREMENT,
  `producto_codigo` VARCHAR(70) NOT NULL,
  `producto_nombre` VARCHAR(70) NOT NULL,
  `producto_precio` DECIMAL(30,2) NOT NULL,
  `producto_stock` INT(11) NOT NULL,
  `producto_foto` VARCHAR(500) NOT NULL,
  `categoria_id` INT(11) NOT NULL,
  PRIMARY KEY (`producto_id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla `compras`
DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras` (
  `id_compra` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `fecha_hora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `finalizar` TINYINT(1) NOT NULL,
  `total` DECIMAL(30,2) DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla `orden_producto`
DROP TABLE IF EXISTS `orden_producto`;
CREATE TABLE `orden_producto` (
  `id_compra` INT(11) NOT NULL,
  `producto_id` INT(11) NOT NULL,
  `cantidad_compra` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id_compra`, `producto_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `orden_producto_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`),
  CONSTRAINT `orden_producto_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla `pago`
DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago` (
  `id_pago` INT(11) NOT NULL AUTO_INCREMENT,
  `id_compra` INT(11) NOT NULL,
  `metodo_pago` VARCHAR(50) NOT NULL,
  `estado_pago` VARCHAR(50) NOT NULL,
  `fecha_pago` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pago`),
  KEY `id_compra` (`id_compra`),
  CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla `reseñas`
DROP TABLE IF EXISTS `reseñas`;
CREATE TABLE `reseñas` (
  `id_reseña` INT(11) NOT NULL AUTO_INCREMENT,
  `id_producto` INT(11) NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  `calificacion` INT(1) NOT NULL CHECK (`calificacion` BETWEEN 1 AND 5),
  `comentario` TEXT NOT NULL,
  `fecha_reseña` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reseña`),
  KEY `id_producto` (`id_producto`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`producto_id`),
  CONSTRAINT `reseñas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla `historial_inventario`
DROP TABLE IF EXISTS `historial_inventario`;
CREATE TABLE `historial_inventario` (
  `id_historial` INT(11) NOT NULL AUTO_INCREMENT,
  `id_producto` INT(11) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `tipo_cambio` ENUM('entrada', 'salida') NOT NULL,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_historial`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `historial_inventario_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
