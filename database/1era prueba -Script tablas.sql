-- =========================================
-- BASE DE DATOS: db_cosmeticos
-- =========================================
CREATE DATABASE IF NOT EXISTS Proyecto_Ventas;
USE Proyecto_Ventas;

-- =========================================
-- MÓDULO SEGURIDAD
-- =========================================

CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(30) NOT NULL
);

CREATE TABLE empleados (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    estado ENUM('activo', 'inactivo', 'bloqueado') DEFAULT 'activo',
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

-- =========================================
-- MÓDULO COMPRAS 
-- =========================================

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL
);

CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(100) NOT NULL,
    nit VARCHAR(20)
);

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    precio_costo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock_actual INT NOT NULL DEFAULT 0,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

CREATE TABLE compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_proveedor INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('efectivo', 'transferencia', 'credito') NOT NULL,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
);

CREATE TABLE detalle_compras (
    id_detalle_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    costo_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE devoluciones_compras (
    id_dev_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    motivo TEXT NOT NULL,
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra)
);

CREATE TABLE cuentas_por_pagar (
    id_cpp INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    saldo_pendiente DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'pagado', 'parcial') DEFAULT 'pendiente',
    fecha_limite DATE,
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra)
);

-- KARDEX (DENTRO DE COMPRAS - CONTROL DE MOVIMIENTOS)
CREATE TABLE kardex (
    id_kardex INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida') NOT NULL,
    cantidad INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descripcion VARCHAR(255), -- Ej: "Entrada por compra #10" o "Salida por factura #5"
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- =========================================
--  MÓDULO VENTAS
-- =========================================

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    nit VARCHAR(20) DEFAULT 'C/F'
);

CREATE TABLE facturas (
    id_factura INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_empleado INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('efectivo', 'transferencia', 'tarjeta', 'credito') NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

CREATE TABLE detalle_facturas (
    id_detalle_fac INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_factura) REFERENCES facturas(id_factura),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE devoluciones_ventas (
    id_dev_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    motivo TEXT NOT NULL,
    FOREIGN KEY (id_factura) REFERENCES facturas(id_factura)
);

CREATE TABLE cuentas_por_cobrar (
    id_cpc INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT NOT NULL,
    saldo_pendiente DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'pagado', 'parcial') DEFAULT 'pendiente',
    fecha_vencimiento DATE,
    FOREIGN KEY (id_factura) REFERENCES facturas(id_factura)
);

--  CAJA (DENTRO DE VENTAS - CONTROL FINANCIERO)
CREATE TABLE caja (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT NOT NULL,
    tipo_movimiento ENUM('ingreso', 'egreso') NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    medio_pago ENUM('efectivo', 'banco') NOT NULL,
    descripcion VARCHAR(255),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

