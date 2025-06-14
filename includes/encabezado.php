<nav class="main-header">
    <?php
    include(RUTA_PROYECTO . "includes/barra-developer.php");
    ?>
</nav>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= REDIRECT_ROUTE ?>modules/index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= $_SESSION["configuracion"]['conf_web'] ?>" class="nav-link" target="_target">Tienda</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" name="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <?php
                try {
                    $consultaNotiMensajes = mysqli_query($conexionBdMicuenta, "SELECT * FROM micuenta_mensajes 
                    INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=men_de 
                    WHERE men_para='" . $_SESSION['id'] . "' AND men_visto=0 AND men_eliminado_para!=1 LIMIT 6");
                } catch (Exception $e) {
                    include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
                }
                $noVistosNoti = mysqli_num_rows($consultaNotiMensajes);
            ?>
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge"><?= $noVistosNoti ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php
                    while($resultadoM = mysqli_fetch_array($consultaNotiMensajes, MYSQLI_BOTH)){
                        $fechaDF=$resultadoM['men_fecha'];
                        include(RUTA_PROYECTO."includes/datos-fechas.php");
                ?>
                    <a href="<?=REDIRECT_ROUTE?>modules/mi_cuenta/bd_read/mailbox-leer.php?id=<?= $resultadoM['men_id'] ?>" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="<?=REDIRECT_ROUTE."files/perfil/".$resultadoM['usr_foto']; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    <?= $resultadoM['usr_nombre'] ?>
                                    <?php if($resultadoM['men_destacado']){ ?>
                                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                    <?php } ?>
                                </h3>
                                <p class="text-sm"><?= $resultadoM['men_asunto'] ?></p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?=$timaLine?></p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                <?php } ?>
                <a href="<?=REDIRECT_ROUTE?>modules/mi_cuenta/bd_read/mailbox.php" class="dropdown-item dropdown-footer">Ver todos los mensajes</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>