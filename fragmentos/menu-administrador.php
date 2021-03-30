<link rel="stylesheet" href="/dist/css/menu.css">

<section class="section-emtusa" style="background: rgb(34,193,195) !important; background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(45,109,253,1) 100%) !important;">
    <nav>
        <div class="logo-1">
            <img class="logo-emtusa" src="/dist/img/emtusa-logo-cab.png" alt="logoEmtusa.png">
        </div>
        <ul class="nav-links">
            <li><a href="/inicio" class="nav-link"><i class="fas fa-home"></i>Inicio</a></li>
            <li><a href="/solicitudes" class="nav-link"><i class="fas fa-edit"></i>Crear Solicitudes</a></li>
            <li><a href="/consultar-solicitudes" class="nav-link"><i class="fas fa-search"></i>Consultar Solicitudes</a></li>
            <li><a href="/admin/modificar-dias" class="nav-link"><i class="fas fa-search"></i>Gestión Días</a></li>
            <li><a href="/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i>Salir</a></li>
        </ul>
        <div class="burguer">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <div class="logo-2">
            <img class="logo-ayuntamiento" src="/dist/img/ayuntamiento-huelva-logo-cab.png" alt="logoAyuntamiento.png">
        </div>
    </nav>
</section>
<div class="informacion-usuario" style="background: rgb(34,193,195)">
    <span id="info-usuario">
        <div>Ha iniciado sesión como: <p id="nombre"><?php echo $_SESSION['Nombre'] . ' ' . $_SESSION['Apellidos'] ?></p>
        </div>
    </span>
</div>