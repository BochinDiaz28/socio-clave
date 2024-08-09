<?php
  echo "<script>console.log('Eliminando cookies')</script>";
  session_unset();
  session_destroy();
  unset($_COOKIE["LoginSC"]);
?>

<?php require RUTA_APP . '/vistas/inc/header.php'; ?>

<div class="container-fluid">
  <div class="row min-vh-100 flex-center g-0">
    <div class="col-lg-8 col-xxl-5 py-3 position-relative">
      
      <div class="card overflow-hidden z-index-1">
        <div class="card-body p-0">
          <div class="row g-0 h-100">
            <div class="col-md-5 text-center" style="background-color: #0C787B;">
              <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                <!--/.bg-holder-->
                <div class="z-index-1 position-relative">
                  <a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" 
                     href="<?php echo constant('RUTA_URL'); ?>/ingresar">
                    <?php echo constant('NOMBRE_SITIO'); ?></a>
                  <p class="opacity-75 text-white">Socio Clave</p>
                </div>
              </div>
             
            </div>
            <div class="col-md-7 d-flex flex-center">
              <div class="p-4 p-md-5 flex-grow-1">
                <div class="row flex-between-center">
                  <div class="col-auto">
                    <h3>Ingresar</h3>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label class="form-label" for="email">Usuario</label>
                  <input class="form-control" id="email" type="email" />
                </div>
                <div class="mb-3">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Clave</label>
                  </div>
                  <input class="form-control" id="password" type="password" />
                </div>
                <div class="row flex-between-center">
                  <div class="col-auto">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" id="autoL" checked="checked" style="background-color: #0C787B; border-color: #0C787B;"/>
                      <label class="form-check-label mb-0" for="autoL">Recuerdame</label>
                    </div>
                  </div>
                  <!--
                  <div class="col-auto"><a class="fs--1" href="<?php //echo constant('RUTA_URL'); ?>/inicio" style="color: #0C787B;">Olvido su Clave?</a></div>
                  -->
                </div>

                <div class="mb-3">
                  <button class="btn btn-primary d-block w-100 mt-3" 
                          type="bottom" onclick="Controlar_Ingreso()" name="submit"
                          style="background-color: #0C787B; border-color: #0C787B;">Ingresar</button>
                </div>
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>

<script>
    function Controlar_Ingreso()
    {
        var usuario  = $("#email").val();
        var password = $("#password").val();
        if(document.getElementById("autoL").checked==true){ var Activo=1; }else{ var Activo=0; }
        var apiUrl   = "<?php echo constant('RUTA_REST');?>/rest-api/Auth.php" 
        var data = { 
            Usuario  : usuario, 
            Password : password,
            Google   : "No" 
        } 
        fetch(apiUrl,{ 
            method : 'POST',  
            headers: { 'Content-type' : 'application/json' },
            body   : JSON.stringify(data) 
        }) 
        .then(response => response.json() ) 
        .then(data => {  
            console.log(data);
            if (data['result']['status']!=='ok') {
              alert( data['result']['status'] );
            }else{
              console.log("Ingreso a rta");
              var result    = data['result']['status'];
              var token     = data['result']['token'];
              var rol       = data['result']['rol'];
              var usuario   = data['result']['usuario'];
              var id        = data['result']['id'];
              var empresaID = data['result']['empresaID'];
              let login     = [id,usuario,rol,token,empresaID];
              Swal.fire({
                  type             : 'success',
                  title            : 'Bienvenido!',
                  showConfirmButton: false,
                  timer            : 1500
              }).then(function() {
                  console.log('Sesion Iniciada.');
                  //CREO EL TOKEN PARA MANTENER SESSION INICIADA
                  localStorage.setItem('LoginSC', token);
                  //SELECCIONO  RECUERDAME = 1
                  if(Activo==1){
                    localStorage.setItem('TokenSCAuto', "Si");
                  }else{
                    localStorage.setItem('TokenSCAuto', "No");
                  }
                  document.cookie = "LoginSC="+login;
                  window.location = "<?php echo constant('RUTA_URL');?>/redireccionLogin/"+login;
              });
           
            }
        }) 
    }
</script>