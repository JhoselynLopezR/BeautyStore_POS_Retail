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
    correo VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    intentos_fallidos INT DEFAULT 0,
    estado ENUM('activo', 'bloqueado') DEFAULT 'activo',
    fecha_bloqueo DATETIME,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

-- RECUPERACIÓN DE CONTRASEÑA

CREATE TABLE recuperacion_contrasena (
    id_recuperacion INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion DATETIME NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

-- =========================================
-- PRODUCTOS
-- =========================================

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL
);

CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(100) NOT NULL,
    nit VARCHAR(20),
    telefono VARCHAR(20),
    correo VARCHAR(100)
);

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    id_proveedor INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    marca VARCHAR(50),
    tono VARCHAR(50),
    fecha_vencimiento DATE,
    precio_costo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock_actual INT NOT NULL DEFAULT 0,
    stock_minimo INT DEFAULT 5,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
);

-- =========================================
-- COMPRAS
-- =========================================

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
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- =========================================
-- CUENTAS POR PAGAR
-- =========================================

CREATE TABLE cuentas_por_pagar (
    id_cpp INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    saldo_total DECIMAL(10,2) NOT NULL,
    fecha_vencimiento DATE,
    estado ENUM('pendiente','parcial','pagado') DEFAULT 'pendiente',
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra)
);

CREATE TABLE pagos_proveedores (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_cpp INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('efectivo','transferencia','tarjeta') NOT NULL,
    descripcion VARCHAR(255),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cpp) REFERENCES cuentas_por_pagar(id_cpp)
);

-- =========================================
-- DEVOLUCIONES COMPRAS
-- =========================================

CREATE TABLE devoluciones_compras (
    id_dev_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    motivo TEXT,
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra)
);

CREATE TABLE detalle_dev_compras (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_dev_compra INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    monto DECIMAL(10,2),
    FOREIGN KEY (id_dev_compra) REFERENCES devoluciones_compras(id_dev_compra),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- =========================================
-- CLIENTES
-- =========================================

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    nit VARCHAR(20) DEFAULT 'C/F',
    telefono VARCHAR(20),
    correo VARCHAR(100)
);

-- =========================================
-- VENTAS
-- =========================================

CREATE TABLE facturas (
    id_factura INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_empleado INT NOT NULL,
	numero_factura VARCHAR(30) NOT NULL UNIQUE,
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
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_factura) REFERENCES facturas(id_factura),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- =========================================
-- CUENTAS POR COBRAR
-- =========================================

CREATE TABLE cuentas_por_cobrar (
    id_cpc INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT NOT NULL,
    saldo_total DECIMAL(10,2) NOT NULL,
    fecha_vencimiento DATE,
    estado ENUM('pendiente','parcial','pagado') DEFAULT 'pendiente',
    FOREIGN KEY (id_factura) REFERENCES facturas(id_factura)
);

CREATE TABLE pagos_clientes (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_cpc INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('efectivo','transferencia','tarjeta') NOT NULL,
    descripcion VARCHAR(255),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cpc) REFERENCES cuentas_por_cobrar(id_cpc)
);

-- =========================================
-- DEVOLUCIONES VENTAS
-- =========================================

CREATE TABLE devoluciones_ventas (
    id_dev_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    motivo TEXT,
    FOREIGN KEY (id_factura) REFERENCES facturas(id_factura)
);

CREATE TABLE detalle_dev_ventas (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_dev_venta INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    monto DECIMAL(10,2),
    FOREIGN KEY (id_dev_venta) REFERENCES devoluciones_ventas(id_dev_venta),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- =========================================
-- KARDEX
-- =========================================

CREATE TABLE kardex (
    id_kardex INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    tipo_movimiento ENUM('COMPRA','VENTA','DEV_COMPRA','DEV_VENTA','AJUSTE') NOT NULL,
    cantidad INT NOT NULL,
    stock_resultante INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descripcion VARCHAR(255),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- =========================================
-- CAJA (VALOR AGREGADO)
-- =========================================

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