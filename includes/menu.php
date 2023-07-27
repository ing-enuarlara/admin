<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="index.php" class="brand-link">
    <img src="<?=REDIRECT_ROUTE?>files/logo/AdminZEFELogo.png" alt="AdminZEFE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminZEFE</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?=REDIRECT_ROUTE?>files/perfil/<?=$datosUsuarioActual['usr_foto']?>" class="img-circle elevation-2" alt="User Image" style="margin-top: 14px;">
    </div>
    <div class="info">
        <a href="#" class="d-block"><?=$datosUsuarioActual['usr_nombre']?></br>
        <i><?=$datosUsuarioActual['utipo_nombre']?></i></a>
    </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
        <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
        </button>
        </div>
    </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if(validarAccesoModulo($configuracion['conf_id_empresa'], 1)){?>
        <li class="nav-item">
            <a href="<?=REDIRECT_ROUTE?>modules/index.php" class="nav-link <?php if($paginaActual['pag_id_modulo']==1){echo "active";}?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <?php }?>
        <?php if(validarAccesoModulo($configuracion['conf_id_empresa'], 4)){?>
        <li class="nav-item">
            <a href="#" class="nav-link <?php if($paginaActual['pag_id_modulo']==4){echo "active";}?>">
                <i class="nav-icon fas fa-user"></i>
                <p>Mi Cuenta<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Editar Perfil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Mis Ventas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Mi calendario</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
        <?php if(validarAccesoModulo($configuracion['conf_id_empresa'], 2)){?>
        <li class="nav-item">
            <a href="#" class="nav-link <?php if($paginaActual['pag_id_modulo']==2){echo "active";}?>">
                <i class="nav-icon fas fa-regular fa-toolbox"></i>
                <p>Administrativo<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/administrativo/bd_read/usuarios.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/administrativo/bd_read/roles.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Roles</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
        <?php if(validarAccesoModulo($configuracion['conf_id_empresa'], 3)){?>
        <li class="nav-item">
            <a href="#" class="nav-link <?php if($paginaActual['pag_id_modulo']==3){echo "active";}?>">
                <i class="nav-icon fas fa-solid fa-money-bill"></i>
                <p>Comercial<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/clientes.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Producto<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/categorias.php" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Categorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/marcas.php" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Sub-Categorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/tipo-producto.php" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Tipo de Productos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/productos.php" class="nav-link">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/cotizaciones.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cotizaciones</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/pedidos.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pedidos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/remisiones.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Remisiones</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/comercial/bd_read/facturacion.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Facturación</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
        <?php if(validarAccesoModulo($configuracion['conf_id_empresa'], 5)){?>
        <li class="nav-item">
            <a href="#" class="nav-link <?php if($paginaActual['pag_id_modulo']==5){echo "active";}?>">
                <i class="nav-icon fas fa-cogs"></i>
                <p>Sistema<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <?php if($datosUsuarioActual['usr_tipo']==1){ ?>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/sistema/bd_read/paginas.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Páginas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/sistema/bd_read/modulos.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Módulos</p>
                    </a>
                </li>
                <?php }?>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/sistema/bd_read/configuracion-sistema.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Configuración del Sistema</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Historial de acciones</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
        <?php if(validarAccesoModulo($configuracion['conf_id_empresa'], 7)){?>
        <li class="nav-item">
            <a href="#" class="nav-link <?php if($paginaActual['pag_id_modulo']==7){echo "active";}?>">
                <i class="nav-icon fas fa-regular fa-earth-americas"></i>
                <p>Pagina Web<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/pagina-web/bd_read/configuracion.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Configurar Pagina</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/pagina-web/bd_read/configuracion-color-store.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cambiar Colores</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=REDIRECT_ROUTE?>modules/pagina-web/bd_read/legales.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Paginas Legales</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
        <?php if($datosUsuarioActual['usr_tipo']==1){?>
        <li class="nav-item">
            <a href="<?=REDIRECT_ROUTE?>modules/client_admin/bd_read/clientes-admin.php" class="nav-link <?php if($paginaActual['pag_id_modulo']==6){echo "active";}?>">
                <i class="nav-icon fas fa-business-time"></i>
                <p>Clientes AdminZEFE</p>
            </a>
        </li>
        <?php } ?>
        <li class="nav-item" style="position: absolute; margin-top: 695px;">
            <a href="<?=REDIRECT_ROUTE?>salir.php" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Cerrar Sesion</p>
            </a>
        </li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>