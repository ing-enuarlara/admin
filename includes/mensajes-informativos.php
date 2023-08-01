<?php
if(!empty($_GET['success']) || !empty($_GET['info']) || !empty($_GET['warning']) || !empty($_GET['error'])){
    /* MENSAJES DE EXITO */
    if(!empty($_GET['success'])){
        $tipo = 'success';
        $icono='<i class="icon fas fa-check"></i>';
        switch($_GET['success']){
            case 'SC_1':
                $mensaje = 'El registro fue creado correctamente con el ID único: <b>' . $_GET["idInsertU"] . '</b>';
            break;

            case 'SC_2':
                $mensaje = 'El registro fue eliminado correctamente.';
            break;

            case 'SC_3':
                $mensaje = 'El registro fue actualizado correctamente.';
            break;

            default:
                $mensaje = 'Error desconocido: '.$_GET['success'];
            break;
        }
    }
    
    /* MENSAJE INFORMATIVO */
    if(!empty($_GET['info'])){
        $tipo = 'info';
        $icono='<i class="icon fas fa-info"></i>';
        switch($_GET['info']){
            case 'INF_1':
                $mensaje = 'El usuario no fue encontrado. Por favor verifique.';
            break;


            default:
                $mensaje = 'Error desconocido: '.$_GET['info'];
            break;
        }
    } 
    
    /* MENSAJES DE ALERTA */
    if(!empty($_GET['warning'])){
        $tipo = 'warning';
        $icono='<i class="icon fas fa-exclamation-triangle"></i>';
        switch($_GET['warning']){
            case 'WN_1':
                $mensaje = 'Porfavor llene todos los campos.';
            break;


            default:
                $mensaje = 'Error desconocido: '.$_GET['warning'];
            break;
        }
    } 

    /* MENSAJES DE ERROR */
    if(!empty($_GET['error'])){
        $tipo = 'danger';
        $icono='<i class="icon fas fa-ban"></i>';
        switch($_GET['error']){
            case 'ER_1':
                $mensaje = 'El usuario no fue encontrado. Por favor verifique.';
            break;

            case 'ER_2':
                $mensaje = 'La clave no cumple con todos los requerimientos:<br>
                            - Debe tener entre 8 y 20 caracteres.<br>
                            - Solo se admiten caracteres de la a-z, A-Z, números(0-9) y los siguientes simbolos(. y $).';
            break;

            case 'ER_3':
                $mensaje = 'Este usuario ya se encuentra en uso, por favor use otro.';
            break;


            default:
                $mensaje = 'Error desconocido: '.$_GET['error'];
            break;
        }
    }    
?>
    <div class="alert alert-<?=$tipo?> alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><?=$icono?> Alert!</h5>
        <?=$mensaje?>
    </div>
<?php    
}
?>