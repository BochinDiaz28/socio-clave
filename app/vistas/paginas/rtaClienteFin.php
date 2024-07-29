<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<div class="content">
    <div class="card mb-3">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img img-fluid src="<?php echo constant('RUTA_URL'); ?>/public/img/logosEmpresas/logo.png" alt="Logo">
            </div> 
        </div>
        <div class="card-header">
            <h5 class="mb-0">Muchas gracias por tu respuesta, revisaremos a la brevedad, un afectuoso saludo!</h5>
        </div>
        <hr>
        <div class="form-group text-center">
            <a class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" href="<?php echo constant('RUTA_URL'); ?>">
                <span class="fas fa-check" data-fa-transform="shrink-3"></span> Regresar
            </a>
        </div>
    </div>
</div>
<?php require RUTA_APP . '/vistas/inc/footer2.php'; ?>
