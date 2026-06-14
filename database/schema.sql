CREATE DATABASE IF NOT EXISTS pasteleria
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE pasteleria;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) DEFAULT '',
    rol ENUM('admin', 'cocina', 'mozo', 'cliente') DEFAULT 'cliente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255) DEFAULT '',
    destacado TINYINT(1) DEFAULT 0,
    categoria VARCHAR(50) DEFAULT '',
    etiqueta VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ingredientes_extra (
    id VARCHAR(50) PRIMARY KEY,
    label VARCHAR(100) NOT NULL,
    costo DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS comandas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mesa INT NOT NULL,
    cliente VARCHAR(100) NOT NULL,
    tiempo INT DEFAULT 0,
    vip TINYINT(1) DEFAULT 0,
    estado ENUM('pendiente', 'preparacion', 'listo', 'entregado') DEFAULT 'pendiente',
    usuario_id INT DEFAULT NULL,
    total DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS comanda_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comanda_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    cantidad INT DEFAULT 1,
    variante VARCHAR(100) DEFAULT NULL,
    FOREIGN KEY (comanda_id) REFERENCES comandas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS historial_entregas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comanda_id INT NOT NULL,
    entregado_por INT DEFAULT NULL,
    entregado_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    observaciones VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (comanda_id) REFERENCES comandas(id) ON DELETE CASCADE,
    FOREIGN KEY (entregado_por) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pilares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed: usuarios (password: admin123)
INSERT IGNORE INTO usuarios (nombre, email, password, telefono, rol) VALUES
('Administrador', 'admin@pasteleria.com', '$2y$10$E6opM6xHHcPPEBwQGywBeeyu/CMoZKJFBmXURWdv3bYDXolNmmudC', '999000000', 'admin'),
('Juan Díaz', 'juan@pasteleria.com', '$2y$10$E6opM6xHHcPPEBwQGywBeeyu/CMoZKJFBmXURWdv3bYDXolNmmudC', '999111111', 'mozo'),
('María López', 'maria@pasteleria.com', '$2y$10$E6opM6xHHcPPEBwQGywBeeyu/CMoZKJFBmXURWdv3bYDXolNmmudC', '999222222', 'cocina'),
('Cliente Demo', 'cliente@pasteleria.com', '$2y$10$E6opM6xHHcPPEBwQGywBeeyu/CMoZKJFBmXURWdv3bYDXolNmmudC', '999333333', 'cliente');

-- Seed: productos
INSERT IGNORE INTO productos (id, nombre, descripcion, precio, imagen, destacado, categoria, etiqueta) VALUES
(1, 'Torta de Chocolate Gourmet', 'Triple capa de chocolate belga con relleno de ganache y fresas frescas.', 89.00, 'assets/images/torta-chocolate.jpg', 1, 'tortas', 'MAS VENDIDO'),
(2, 'Alfajores de Lucuma', 'Deliciosos alfajores artesanales con relleno de lucuma y banados en azucar impalpable.', 45.00, 'assets/images/alfajores-lucuma.jpg', 0, 'alfajores', NULL),
(3, 'Cheesecake de Maracuya', 'Suave cheesecake sobre base crujiente con cobertura de maracuya fresco.', 72.00, 'assets/images/cheesecake-maracuya.jpg', 1, 'tortas', 'MAS VENDIDO'),
(4, 'Suspiro Limeno', 'El clasico postre peruano con manjarblanco y merengue perfumado con vino oporto.', 38.00, 'assets/images/suspiro-limeno.jpg', 0, 'postres', NULL),
(5, 'Tarta de Tres Leches', 'Esponjoso bizcocho banado en tres leches con crema batida y canela.', 68.00, 'assets/images/tres-leches.jpg', 1, 'tortas', 'MAS VENDIDO'),
(6, 'Galletas de Mantequilla', 'Galletas artesanales con chispas de chocolate belga y un toque de vainilla.', 28.00, 'assets/images/galletas-mantequilla.jpg', 0, 'galletas', NULL);

-- Seed: ingredientes_extra
INSERT IGNORE INTO ingredientes_extra (id, label, costo) VALUES
('extra-choco', 'Chocolate extra', 2.50),
('extra-fruta', 'Frutas frescas', 3.00),
('extra-crema', 'Crema batida', 1.50),
('extra-nueces', 'Nueces caramelizadas', 2.00);

-- Seed: pilares
INSERT IGNORE INTO pilares (id, titulo, descripcion) VALUES
(1, 'Recetas Tradicionales', 'Transmitidas de generacion en generacion, cada receta guarda el secreto del sabor autentico limeno.'),
(2, 'Ingredientes Frescos', 'Seleccionamos solo insumos de primera calidad, frescos y naturales para cada creacion.'),
(3, 'Horneras Artesanales', 'Coccion lenta en hornos de barro que garantizan la textura y el aroma inconfundibles.'),
(4, 'Toque Familiar', 'Cada postre lleva el carino y la dedicacion de una familia que endulza Lima desde 1924.');

-- Seed: comandas
INSERT IGNORE INTO comandas (id, mesa, cliente, tiempo, vip, estado) VALUES
(101, 4, 'Cliente VIP', 8, 1, 'entregado'),
(102, 7, 'Familia Rodriguez', 15, 0, 'pendiente'),
(103, 2, 'Maria Garcia', 22, 0, 'entregado'),
(104, 1, 'Pedro Sanchez', 5, 0, 'pendiente'),
(105, 5, 'Cliente VIP', 18, 0, 'entregado'),
(106, 8, 'Lucia Mendoza', 25, 0, 'pendiente');

INSERT IGNORE INTO comanda_items (comanda_id, nombre, cantidad, variante) VALUES
(101, 'Torta de Chocolate Gourmet', 1, 'Sin gluten'),
(101, 'Suspiro Limeno', 2, NULL),
(102, 'Cheesecake de Maracuya', 1, NULL),
(102, 'Alfajores de Lucuma', 3, 'Caja regalo'),
(103, 'Tarta de Tres Leches', 1, NULL),
(104, 'Suspiro Limeno', 1, NULL),
(104, 'Galletas de Mantequilla', 2, NULL),
(104, 'Torta de Chocolate Gourmet', 1, 'Extra chocolate'),
(105, 'Torta de Chocolate Gourmet', 2, NULL),
(105, 'Suspiro Limeno', 1, NULL),
(105, 'Cheesecake de Maracuya', 1, NULL),
(106, 'Tarta de Tres Leches', 1, NULL),
(106, 'Alfajores de Lucuma', 2, NULL);

-- Seed: historial_entregas
INSERT IGNORE INTO historial_entregas (comanda_id, entregado_por, entregado_at, observaciones) VALUES
(101, 2, DATE_SUB(NOW(), INTERVAL 2 HOUR), 'Entregado a tiempo'),
(103, 2, DATE_SUB(NOW(), INTERVAL 1 DAY), 'Cliente satisfecho'),
(105, 2, DATE_SUB(NOW(), INTERVAL 3 DAY), 'Sin novedades');
