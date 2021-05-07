<link rel="stylesheet" href="/dist/css/menu-sidebar.css">

<section class="section-emtusa" style="background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(45,109,253,1) 100%) !important">
    <nav>
        <div class="logo-1">
            <img class="logo-emtusa" src="/dist/img/emtusa-logo-cab.png" alt="logoEmtusa.png">
        </div>
        <ul class="nav-links">
            <li><a href="/inicio" class="nav-link"><i class="fas fa-home"></i>Inicio</a></li>
            <li><a href="/admin/crear-solicitudes" class="nav-link"><i class="fas fa-edit"></i>Crear Solicitudes</a></li>
            <li><a href="/admin/cancelar-solicitud" class="nav-link"><i class="fas fa-trash"></i>Cancelar Solicitud</a></li>
            <li><a href="/admin/modificar-dias" class="nav-link"><i class="fas fa-exchange-alt"></i>Modificar Días</a></li>
            <li><a href="/admin/gestion-citas" class="nav-link"><i class="fas fa-stethoscope"></i>Recon. Médicos</a></li>
            <li><a href="/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i>Salir</a></li>
        </ul>
        <div class="burguer">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
    <div class="informacion-usuario">
        <span id="info-usuario">
            <div>Identificado como: <p id="nombre"><?php echo $_SESSION['Nombre'] . ' ' . $_SESSION['Apellidos'] ?></p>
            </div>
        </span>
    </div>
</section>