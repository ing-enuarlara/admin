<div class="d-flex justify-content-end" style="padding: 1.25rem 1.25rem 0;">
    <?php if(!empty($filtro) || !empty($busqueda)){ ?>
        <a href="<?=$_SERVER['PHP_SELF'];?>" class="btn btn-warning mr-5"> Quitar Filtro</a>
    <?php }?>
    <form class="form-inline" action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
        <input class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Search" name="search" value="<?=$busqueda?>" autofocus>
        <button class="btn btn-info my-2 my-sm-0" type="submit">Buscar</button>
    </form>
</div>