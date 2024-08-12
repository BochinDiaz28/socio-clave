<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<!--vista ejemplo desde el modelo/articulo-->
<?php $empresaID = $datos['empresaID'];
      $usuarioID = $datos['usuarioID'];  ?>
<div class="content">

    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>

        <div class="card mb-3 overflow-hidden">
            <div class="card-header">
                <h5 class="mb-0">Cambio de Contraseña</h5>
            </div>
            <div class="card-body bg-light">
                <div class="mb-3">
                    <label class="form-label" for="password">Contraseña Anterior</label>
                    <input class="form-control" id="password" type="password" autocomplete="off"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="newpassword">Nueva Contraseña</label>
                    <input class="form-control" id="newpassword" type="password" autocomplete="off"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="confirmpassword">Confirmar Contraseña</label>
                    <input class="form-control" id="confirmpassword" type="password" autocomplete="off"/>
                </div>
                <button class="btn btn-primary d-block w-100" type="button" onclick="CambioPassword()">Cambiar Contraseña </button>
                
            </div>
        </div>   

</div>

<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>


<script>

    function CambioPassword()
    { 
        var oPass = $('#password').val();
        var nPass = $('#newpassword').val();
        var cPass = $('#confirmpassword').val();
        if(nPass===cPass){
            var usuarioID = <?php echo $usuarioID; ?>;
            Swal.fire({
                title: '<strong>Confirma cambiar contraseña?</strong>',
                icon: 'info',
                html: 'Debera acceder con la nueva contraseña',
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Cambiar!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i> Cancelar',
                cancelButtonAriaLabel: 'Thumbs down'
            }).then((result) => {
                if (result.value) {
                    var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/UsuarioCambioClave.php'; 
                    var data = { 
                        usuarioID : usuarioID,
                        nPass     : nPass,
                        oPass     : oPass
                    } 
                    fetch(apiUrl,{ 
                        method: 'PUT',  
                            headers: {'Content-type' : 'application/json'},
                            body: JSON.stringify(data) 
                        })
                        .then(response =>  
                            response.json() 
                        )
                        .then(data => {
                            console.log(data);
                            if(data[0]["error"]){
                                Swal.fire({
                                    type: 'error',
                                    icon: 'error',
                                    title: ''+data[0]["error"]+'',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            }else{
                                var retornoID = data[0]['rta']; 
                                Swal.fire({
                                    type: 'success',
                                    icon: 'success',
                                    title: 'Clave cambiada con exito!',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                
                            }
                        }) 

                }
            })
        }else{
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Sus claves no cohinciden!',
                showConfirmButton: false,
                timer: 2000
            })
        }
    }


    
</script>