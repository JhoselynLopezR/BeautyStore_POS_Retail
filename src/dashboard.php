<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    margin:0;
     background:#F7F4EF;
    font-family:'Segoe UI', sans-serif;
}

.sidebar{
    width:250px;
    height:100vh;
    background:#F8DDEA;
    position:fixed;
    left:0;
    top:0;
    padding:25px 18px;
    border-right:none;
    overflow-y:auto;
}

.logo{
    text-align:center;
    margin-bottom:30px;
}

.logo h2{
    color:#B94E8A;
    font-weight:bold;
}

.logo p{
    color:#8a8a8a;
    margin-top:-5px;
}

.menu{
    margin-top:15px;
}

.menu a{
    display:flex;
    align-items:center;
    gap:12px;
    text-decoration:none;
    color:#555;
    padding:12px 14px;
    border-radius:14px;
    margin-bottom:8px;
    transition:0.3s;
    font-size:16px;
}

.menu a:hover{
    background:#EFA5C8;
    color:white;
}

.menu a.active{
    background:#EFA5C8;
    color:white;
    font-weight:bold;
}

.main{
    margin-left:250px;
    padding:15px 22px;
}

.topbar{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    margin-bottom:15px;
}

.profile{
    display:flex;
    align-items:center;
    gap:10px;
    margin-right:10px;
}

.profile img{
    width:42px;
    height:42px;
    border-radius:50%;
}

.welcome{
    background: linear-gradient(
        135deg,
        #FFD9E8,
        #E7DCFF
    );

    border-radius:28px;

    height:170px;

    padding:0 0 0 40px;

    margin-bottom:20px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    overflow:hidden;
}

.welcome-content{
    width:42%;
    padding-right:20px;
    z-index:2;
}

.welcome h1{
    color:#111;
    font-weight:800;
    font-size:22px;
    line-height:1.2;
    margin-bottom:10px;
}

.welcome p{
    color:#2f2f2f;
    font-size:18px;
    line-height:1.4;
    margin:0;
}

.welcome-image{
    width:58%;
    height:100%;

    display:flex;
    justify-content:flex-end;
    align-items:flex-end;
}

.welcome-image img{
    height:100%;
    width:100%;
    object-fit:cover;
    object-position:right center;
}
.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:18px;
}

.card-box{
    background:white;
    border-radius:18px;
    padding:12px 15px;
    box-shadow:0 4px 10px rgba(0,0,0,0.03);
}

.card-box h5{
    color:#777;
    font-size:14px;
    margin-bottom:2px;
}

.card-box h2{
    font-weight:bold;
    color:#2D2D2D;
    font-size:22px;
    margin:0;
}

.sections{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:14px;
}

.section-box{
    background:white;
    border-radius:18px;
    padding:15px;
    min-height:100px;
    box-shadow:0 4px 10px rgba(0,0,0,0.03);
}

.section-box h4{
    font-size:18px;
    margin-bottom:10px;
}

</style>

</head>

<body>

<div class="sidebar">

    <div class="logo">

        <h2>BeautyStore</h2>
        <p>POS Retail</p>

    </div>

    <div class="menu">

        <a href="#" class="active">
            <i class="fa-solid fa-house"></i>
            Inicio
        </a>

        <a href="usuarios.php">
            <i class="fa-solid fa-users"></i>
            Usuarios
        </a>

        <a href="compras.php">
            <i class="fa-solid fa-cart-shopping"></i>
            Compras
        </a>

        <a href="#">
            <i class="fa-solid fa-bag-shopping"></i>
            Ventas
        </a>

        <a href="productos.php">
            <i class="fa-solid fa-box"></i>
            Productos
        </a>

        <a href="#">
            <i class="fa-solid fa-address-book"></i>
            Clientes
        </a>

        <a href="proveedores.php">
            <i class="fa-solid fa-truck"></i>
            Proveedores
        </a>

        <a href="#">
            <i class="fa-solid fa-boxes-stacked"></i>
            Kardex / Inventario
        </a>

        <a href="#">
            <i class="fa-solid fa-money-bill-wave"></i>
            Cuentas por Cobrar
        </a>

        <a href="#">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            Cuentas por Pagar
        </a>

        <a href="#">
            <i class="fa-solid fa-chart-column"></i>
            Reportes
        </a>

        <a href="#">
            <i class="fa-solid fa-gear"></i>
            Configuración
        </a>

    </div>
</div>

</div>

<div class="main">

    <div class="topbar">

        <div class="profile">

            <img src="https://cdn-icons-png.flaticon.com/512/6997/6997662.png">

            <div>

                <strong>
                    <?php echo $_SESSION['nombre']; ?>
                </strong>

                <br>

                <span style="color:#888; font-size:14px;">
                    Administradora
                </span>

            </div>

        </div>

    </div>

    <div class="welcome">

        <div class="welcome-content">

            <h1>
                Hola, 
                <?php echo $_SESSION['nombre']; ?>✨
            </h1>

            <p>
                Bienvenido(a) de nuevo a BeautyStore 💄
            </p>

        </div>

        <div class="welcome-image">

            <img src="assets/images/MAKEUP (3).png">

        </div>

    </div>

    <div class="cards">

        <div class="card-box">

            <div style="display:flex; align-items:center; gap:12px;">

                <div style="
                    width:50px;
                    height:50px;
                    border-radius:50%;
                    background:#FFE0EC;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    font-size:22px;
                    color:#ff5fa2;
                ">

                    <i class="fa-solid fa-bag-shopping"></i>

                </div>

                <div>

                    <h5>Ventas del día</h5>
                    <h2>Q0.00</h2>

                </div>

            </div>

        </div>

        <div class="card-box">

            <div style="display:flex; align-items:center; gap:12px;">

                <div style="
                    width:50px;
                    height:50px;
                    border-radius:50%;
                    background:#EEE1FF;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    font-size:22px;
                    color:#9b5cff;
                ">

                    <i class="fa-solid fa-cart-shopping"></i>

                </div>

                <div>

                    <h5>Compras del día</h5>
                    <h2>Q0.00</h2>

                </div>

            </div>

        </div>

        <div class="card-box">

            <div style="display:flex; align-items:center; gap:12px;">

                <div style="
                    width:50px;
                    height:50px;
                    border-radius:50%;
                    background:#DDF3FF;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    font-size:22px;
                    color:#3d9cff;
                ">

                    <i class="fa-solid fa-users"></i>

                </div>

                <div>

                    <h5>Clientes registrados</h5>
                    <h2>0</h2>

                </div>

            </div>

        </div>

        <div class="card-box">

            <div style="
                display:flex;
                align-items:center;
                gap:12px;
            ">

                <div style="
                    width:50px;
                    height:50px;
                    border-radius:50%;
                    background:#FFF1D9;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    font-size:22px;
                    color:#f2a100;
                ">

                    <i class="fa-solid fa-box"></i>

                </div>

                <div>

                    <h5>Productos en stock</h5>
                    <h2>0</h2>

                </div>

            </div>

        </div>

    </div>

    <div class="sections">

        <div class="section-box">

            <h4>
                Actividad reciente
            </h4>

            <div style="
                text-align:center;
                margin-top:10px;
            ">

                <div style="
                    width:80px;
                    height:80px;
                    margin:auto;
                    border-radius:50%;
                    background:#FFEAF3;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    font-size:32px;
                    color:#ff5fa2;
                ">

                    <i class="fa-solid fa-clipboard-check"></i>

                </div>

                <h5 style="
                    color:#555;
                    margin-top:12px;
                ">
                    Aún no hay actividad registrada
                </h5>

                <p style="
                    color:#999;
                    margin-top:5px;
                    font-size:14px;
                ">
                    Aquí aparecerán las ventas, compras y movimientos recientes.
                </p>

            </div>

        </div>

        <div class="section-box">

            <h4>
                Recordatorios
            </h4>

            <div style="
                background:#F8F1FF;
                border-radius:18px;
                padding:18px;
                margin-top:15px;
            ">

                <div style="
                    display:flex;
                    align-items:center;
                    gap:15px;
                ">

                    <div style="
                        width:55px;
                        height:55px;
                        border-radius:50%;
                        background:#E8D7FF;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                        color:#9b5cff;
                        font-size:24px;
                    ">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>

                    <div>

                        <h5 style="margin:0;">
                            Todo al día
                        </h5>

                        <p style="
                            margin:0;
                            color:#777;
                            font-size:14px;
                        ">
                            No tienes recordatorios pendientes.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>