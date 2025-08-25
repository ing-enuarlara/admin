<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="<?= REDIRECT_ROUTE ?>files/logo/logo3.png" alt="AdminOCB" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminOCB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= REDIRECT_ROUTE ?>files/perfil/<?= $_SESSION["datosUsuarioActual"]['usr_foto'] ?>" class="img-circle elevation-2" alt="User Image" style="margin-top: 14px;">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $_SESSION["datosUsuarioActual"]['usr_nombre'] ?></br>
                    <i><?= $_SESSION["datosUsuarioActual"]['utipo_nombre'] ?></i></a>
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
                <li <?= agregarClass(MENU_PADRE, [1]) ?>>
                    <a href="<?= REDIRECT_ROUTE ?>modules/index.php" <?= agregarClass(MENU, [1]) ?>>
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php
                if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::MI_CUENTA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::MI_CUENTA)) {
                    $arrayPaginas = [109, 111, 113, 114, 115, 117, 122, 123, 124, 125];
                ?>
                    <li <?= agregarClass(MENU_PADRE, $arrayPaginas) ?>>
                        <a href="#" <?= agregarClass(MENU, $arrayPaginas) ?>>
                            <i class="nav-icon fas fa-user"></i>
                            <p>Mi Cuenta<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::EDITAR_PERFIL) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::EDITAR_PERFIL) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 109, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/perfil-editar.php" <?= agregarClass(MENU, [109]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Editar Perfil</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::MIS_VENTAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::MIS_VENTAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 113, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mis-ventas.php" <?= agregarClass(MENU, [113]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mis Ventas</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::MIS_PEDIDOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::MIS_PEDIDOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 114, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mis-pedidos.php" <?= agregarClass(MENU, [114]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mis Pedidos</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CAMBIAR_CLAVE) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CAMBIAR_CLAVE) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 111, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/clave-editar.php" <?= agregarClass(MENU, [111]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cambiar Clave</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::MI_CALENDARIO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::MI_CALENDARIO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 115, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mi-calendario.php" <?= agregarClass(MENU, [115, 117]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mi calendario</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::MENSAJES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::MENSAJES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 122, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/mi_cuenta/bd_read/mailbox.php" <?= agregarClass(MENU, [122, 123, 124, 125]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mensajes</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php
                if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::ADMINISTRATIVO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::ADMINISTRATIVO)) {
                    $arrayPaginas = [42, 43, 45, 48, 49, 67];
                ?>
                    <li <?= agregarClass(MENU_PADRE, $arrayPaginas) ?>>
                        <a href="#" <?= agregarClass(MENU, $arrayPaginas) ?>>
                            <i class="nav-icon fas fa-regular fa-toolbox"></i>
                            <p>Administrativo<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::ROLES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::ROLES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 42, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/administrativo/bd_read/roles.php" <?= agregarClass(MENU, [42, 43, 45]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::USUARIOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::USUARIOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 48, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/administrativo/bd_read/usuarios.php" <?= agregarClass(MENU, [48, 49, 67]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php
                if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::COMERCIAL) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::COMERCIAL)) {
                    $arrayPaginas = [20, 21, 23, 26, 27, 29, 32, 33, 35, 56, 59, 60, 62, 69, 70, 71, 75, 76, 77, 87, 88, 95, 96, 98, 103, 105, 107, 145, 146, 147, 154, 155, 157, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 193, 194, 196];

                    $arrayPaginas2 = [160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190];

                    $arrayPaginas3 = [20, 21, 23, 26, 27, 29, 32, 33, 35, 56, 59, 60, 62, 145, 146, 147];
                ?>
                    <li <?= agregarClass(MENU_PADRE, $arrayPaginas) ?>>
                        <a href="#" <?= agregarClass(MENU, $arrayPaginas) ?>>
                            <i class="nav-icon fas fa-solid fa-money-bill"></i>
                            <p>Comercial<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CLIENTES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CLIENTES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 69, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/clientes.php" <?= agregarClass(MENU, [69, 70, 71]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/proveedores.php" <?= agregarClass(MENU, []) ?> >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Proveedores</p>
                                </a>
                            </li> -->
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CATALOGO_PRINCIPAL) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CATALOGO_PRINCIPAL)) { ?>
                                <li <?= agregarClass(MENU_PADRE, $arrayPaginas2) ?>>
                                    <a href="#" <?= agregarClass(MENU, $arrayPaginas2) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Catalogo Principal<i class="right fas fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview" <?= agregarClass(SUB_MENU, $arrayPaginas2) ?>>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CATEGORIAS_CATALOGO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CATEGORIAS_CATALOGO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 172, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/categorias-catalogo.php" <?= agregarClass(MENU, [172, 173, 174, 175, 176, 177]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Categorias Del Catalogo</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::SUBCATEGORIAS_CATALOGO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::SUBCATEGORIAS_CATALOGO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 178, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/marcas-catalogo.php" <?= agregarClass(MENU, [178, 179, 180, 181, 182, 183, 190]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Sub-Categorias Del Catalogo</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::TIPOS_ARTICULOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::TIPOS_ARTICULOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 184, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/tipo-articulos.php" <?= agregarClass(MENU, [184, 185, 186, 187, 188, 189]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
													<p>Año</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::ARTICULOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::ARTICULOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 160, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/catalogo-principal.php" <?= agregarClass(MENU, [160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Articulos</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::PRODUCTOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::PRODUCTOS)) { ?>
                                <li <?= agregarClass(MENU_PADRE, $arrayPaginas3) ?>>
                                    <a href="#" <?= agregarClass(MENU, $arrayPaginas3) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Producto<i class="right fas fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview" <?= agregarClass(SUB_MENU, $arrayPaginas3) ?>>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CATEGORIAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CATEGORIAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 26, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/categorias.php" <?= agregarClass(MENU, [26, 27, 29]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Categorias</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::SUBCATEGORIAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::SUBCATEGORIAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 32, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/marcas.php" <?= agregarClass(MENU, [32, 33, 35]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Sub-Categorias</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::TIPOS_PRODUCTOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::TIPOS_PRODUCTOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 59, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/tipo-producto.php" <?= agregarClass(MENU, [59, 60, 62]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Marcas</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::PRODUCTO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::PRODUCTO) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 20, 'PAG')) { ?>
                                            <li class="nav-item">
                                                <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/productos.php" <?= agregarClass(MENU, [20, 21, 23, 56, 145, 146, 147]) ?>>
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Productos</p>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::COMBOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::COMBOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 193, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/combos.php" <?= agregarClass(MENU, [193, 194, 196]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Combos</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::OFERTAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::OFERTAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 154, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/ofertas.php" <?= agregarClass(MENU, [154, 155, 157]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ofertas</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::COTIZACIONES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::COTIZACIONES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 75, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/cotizaciones.php" <?= agregarClass(MENU, [75, 76, 77]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cotizaciones</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::PEDIDOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::PEDIDOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 87, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/pedidos.php" <?= agregarClass(MENU, [87, 88]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pedidos</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::REMISIONES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::REMISIONES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 95, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/remisiones.php" <?= agregarClass(MENU, [95, 96, 98]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Remisiones</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::FACTURACION) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::FACTURACION) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 103, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/facturacion.php" <?= agregarClass(MENU, [103, 105, 107]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Facturación</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php
                if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::SISTEMA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::SISTEMA)) {
                    $arrayPaginas = [2, 3, 4, 8, 9, 10, 83];
                ?>
                    <li <?= agregarClass(MENU_PADRE, $arrayPaginas) ?>>
                        <a href="#" <?= agregarClass(MENU, $arrayPaginas) ?>>
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Sistema<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CONFIG_SISTEMA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CONFIG_SISTEMA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 83, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/sistema/bd_read/configuracion-sistema.php" <?= agregarClass(MENU, [83]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Configuración del Sistema</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::PAGINAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::PAGINAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 2, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/sistema/bd_read/paginas.php" <?= agregarClass(MENU, [2, 3, 4]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Páginas</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::MODULOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::MODULOS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 8, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/sistema/bd_read/modulos.php" <?= agregarClass(MENU, [8, 9, 10]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Módulos</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::HISTORIAL_ACCIONES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::HISTORIAL_ACCIONES)) { ?>
                                <li class="nav-item">
                                    <a href="#" <?= agregarClass(MENU, []) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Historial de acciones</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php
                if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::PAGINA_WEB) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::PAGINA_WEB)) {
                    $arrayPaginas = [38, 40, 50, 51, 52, 130, 131, 133, 136, 137, 138, 139, 140, 142, 148, 149, 151];
                ?>
                    <li <?= agregarClass(MENU_PADRE, $arrayPaginas) ?>>
                        <a href="#" <?= agregarClass(MENU, $arrayPaginas) ?>>
                            <i class="fa fa-globe nav-icon"></i>
                            <p>Pagina Web<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::BLOGS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::BLOGS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 130, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/pagina-web/bd_read/blogs.php" <?= agregarClass(MENU, [130, 131, 133, 137, 138]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Blogs</p>
                                    </a>
                                </li>
                            <?php if (validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 139, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/pagina-web/bd_read/categorias-blogs.php" <?= agregarClass(MENU, [139, 140, 142]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Categorias Blogs</p>
                                    </a>
                                </li>
                            <?php } } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::SLIDERS_BANNERS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::SLIDERS_BANNERS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 148, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/pagina-web/bd_read/sliders.php" <?= agregarClass(MENU, [148, 149, 151]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sliders & Banners</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::RESENAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::RESENAS) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 136, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/pagina-web/bd_read/feedback.php" <?= agregarClass(MENU, [136]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ver Reseñas</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CONFIG_PAGINA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CONFIG_PAGINA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 38, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/pagina-web/bd_read/configuracion.php" <?= agregarClass(MENU, [38]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Configurar Pagina</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::COLOR_PAGINA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::COLOR_PAGINA) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 40, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/pagina-web/bd_read/configuracion-color-store.php" <?= agregarClass(MENU, [40]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cambiar Colores</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::PAGINAS_LEGALES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::PAGINAS_LEGALES) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 50, 'PAG')) { ?>
                                <li class="nav-item">
                                    <a href="<?= REDIRECT_ROUTE ?>modules/pagina-web/bd_read/legales.php" <?= agregarClass(MENU, [50, 51, 52]) ?>>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Paginas Legales</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (validarAccesoModulo($_SESSION["idEmpresa"], Modulos::CLIENTES_ADMIN) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], Modulos::CLIENTES_ADMIN) && validarAccesoRol($_SESSION["datosUsuarioActual"]['usr_tipo'], 14, 'PAG')) { ?>
                    <li <?= agregarClass(MENU_PADRE, [14, 15, 16]) ?>>
                        <a href="<?= REDIRECT_ROUTE ?>modules/client_admin/bd_read/clientes-admin.php" <?= agregarClass(MENU, [14, 15, 16]) ?>>
                            <i class="nav-icon fas fa-business-time"></i>
                            <p>Clientes AdminOCB</p>
                        </a>
                    </li>
                <?php }
                if (!isset($_SESSION['admin'])) { ?>
                    <li class="nav-item cerrar-sesion">
                        <a href="<?= REDIRECT_ROUTE ?>salir.php" class="nav-link">
                            <i class="nav-icon far fa-circle text-danger"></i>
                            <p class="text text-sesion">Cerrar Sesión</p>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item cerrar-sesion">
                        <a href="<?= REDIRECT_ROUTE ?>includes/return-admin-panel.php" class="nav-link">
                            <i class="nav-icon far fa-circle text-danger"></i>
                            <p class="text text-sesion">RETORNAR</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<style>
    .cerrar-sesion {
        background-color: #3b0d0d;
        border-radius: 10px;
    }

    .text-sesion {
        color: #ffffff;
    }
</style>