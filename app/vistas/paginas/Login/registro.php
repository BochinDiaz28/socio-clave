
<?php require RUTA_APP . '/vistas/inc/header.php'; ?>

  <div class="container-fluid">
    <div class="row min-vh-100 flex-center g-0">
      <div class="col-lg-8 col-xxl-5 py-3 position-relative">
        <img class="bg-auth-circle-shape" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250">
        <img class="bg-auth-circle-shape-2" src="<?php echo constant('RUTA_URL'); ?>/public/assets/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
        <div class="card overflow-hidden z-index-1">
          <div class="card-body p-0">
            <div class="row g-0 h-100">
              <div class="col-md-5 text-center bg-card-gradient">
                <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                  <div class="bg-holder bg-auth-card-shape" style="background-image:url(<?php echo constant('RUTA_URL'); ?>/public/assets/img/icons/spot-illustrations/half-circle.png);">
                  </div>
                  <!--/.bg-holder-->

                  <div class="z-index-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" href="<?php echo constant('RUTA_URL'); ?>/ingresar">Si Envio</a>
                    <p class="opacity-75 text-white">Sistema de recolección y entregar de encomiendas!</p>
                  </div>
                </div>
                <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                  <p class="pt-3 text-white">Ya tienes cuenta?<br>
                  <a class="btn btn-outline-light mt-2 px-4" href="<?php echo constant('RUTA_URL'); ?>/ingresar">Ingresar</a></p>
                </div>
              </div>
              <div class="col-md-7 d-flex flex-center">
                <div class="p-4 p-md-5 flex-grow-1">
                  <h3>Register</h3>
                 
                    <div class="mb-3">
                      <label class="form-label" for="name">Apellido, Nombre o Empresa</label>
                      <input class="form-control" type="text" autocomplete="on" id="name" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="card-name">Celular</label>
                      <input class="form-control" type="text" autocomplete="on" id="cel" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="card-email">Email</label>
                      <input class="form-control" type="email" autocomplete="on" id="email" />
                    </div>
                    <div class="row gx-2">
                      <div class="mb-3 col-sm-6">
                        <label class="form-label" for="card-password">Password</label>
                        <input class="form-control" type="password" autocomplete="on" id="password" />
                      </div>
                      <div class="mb-3 col-sm-6">
                        <label class="form-label" for="confirm-password">Confirmar Password</label>
                        <input class="form-control" type="password" autocomplete="on" id="confirm-password" />
                      </div>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="register-checkbox" />
                      <label class="form-label" for="register-checkbox">Acepto los <a href="#!">terminos </a>y <a href="#!">condiciones</a></label>
                    </div>
                    <div class="mb-3">
                      <button class="btn btn-primary d-block w-100 mt-3" type="button" name="submit" onclick="Controlar_Requeridos()">Registro</button>
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
    function Controlar_Requeridos() 
    {
        var nombre = document.querySelector('#name').value,
            cel = document.querySelector('#cel').value,
            email = document.querySelector('#email').value,
            password = document.querySelector('#password').value,
            repassword = document.querySelector('#confirm-password').value;
        if(document.getElementById("register-checkbox").checked==true){ var activo=1; }else{ var activo=0; }

        if(nombre === '' || cel==='' || email==='' || password==='' ||  repassword==='' ){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
            swal({
                type: 'error',
                title: 'Error!',
                text: 'Todos los datos son obligatorios!'
            })
        } else {
            if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(email)){
                if(password == repassword){
                    if( activo==1){
                        Revisar_Usuario();
                    }else{
                        swal({
                            type : 'error',
                            title: 'Error!',
                            text : 'Debe aceptar los terminos y condiciones de uso!'
                        })
                    }
                }else{
                    swal({
                        type : 'error',
                        title: 'Error!',
                        text : 'Los password no coinciden!'
                    })
                }
            } else {
                swal({
                    type: 'error',
                    title: 'Error!',
                    text: 'El correo es incorrecto!'
                })
            }     
        }
    }

    function Revisar_Usuario()
    {
        var email = $("#email").val();
        var apiUrl="<?php echo constant('RUTA_URL');?>/rest-api/usuarios?Correo="+email;
        fetch(apiUrl) 
        .then(response => response.json() ) 
        .then(data => {           
            //SI EL ARRAY ES > QUE 0 EL SISTEMA DEVUELVE QUE EXISTE EL USUARIO   
            if(data.length == 0) {
                Crear_Usuario();                       
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Lo sentimos, El correo esta en uso!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }) 
    }

    function Crear_Usuario()
    {
        var nombre   = $("#name").val();
        var cel      = $("#cel").val();
        var email    = $("#email").val();
        var password = $("#password").val();
        var apiUrl   ="<?php echo constant('RUTA_URL');?>/rest-api/Clientes" 
        var data = { 
            password : password,
            Email    : email,
            Nombre   : nombre,
            Celular  : cel,
            usuarioID: 0 
        } 
        fetch(apiUrl,{ 
            method: 'POST',  
            headers: { 
                'Content-type' : 'application/json' 
            }, 
            //POR ESTA OPCION SE ENVIAN LOS DATOS AL BODY DE LA API
            body: JSON.stringify(data) 
        }) 
        .then(response => response.json()) 
        .then(data => {  
            console.log(data);
            if(data[0]['retornoID']>0){
                //GENERO AUTO LOGIN CON LOS DATOS DEL FORM DE REGISTRO
                Auto_Ingreso();
            }else{
                Swal.fire({
                    type: 'error',
                    title: 'Hubo un error, por favor intente nuevamente!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }	 
            
        }) 
    }

    function Auto_Ingreso()
    {
        var usuario  = $("#email").val();
        var password = $("#password").val();
        var Activo   = 1;
        var apiUrl   ="<?php echo constant('RUTA_URL');?>/rest-api/Auth" 
        var data = { 
            Usuario  : usuario, 
            Password : password,
            Google   : "No" 
        } 
        fetch(apiUrl,{ 
            method : 'POST',  
            headers: { 
                'Content-type' : 'application/json' 
            }, 
            //POR ESTA OPCION SE ENVIAN LOS DATOS AL BODY DE LA API
            body: JSON.stringify(data) 
            }) 
        .then(response =>  
            response.json() 
        ) 
        .then(data => {  
          console.log(data);
          var result    = data['result']['status'];
          var token     = data['result']['token'];
          var rol       = data['result']['rol'];
          var usuario   = data['result']['usuario'];
          var id        = data['result']['id'];
          var empresaID = data['result']['empresaID'];
          let login     = [id,usuario,rol,token,empresaID];
          if(result == 'ok') {
              Swal.fire({
                  type : 'success',
                  title: 'Bienvenido!',
                  showConfirmButton: false,
                  timer: 1500
              }).then(function() {
                console.log('Sesion Iniciada.');
                //CREO EL TOKEN PARA MANTENER SESSION INICIADA
                localStorage.setItem('LoginPQ', token);
                //SELECCIONO  RECUERDAME = 1
                if(Activo==1){
                  localStorage.setItem('TokenPQAuto', "Si");
                }else{
                  localStorage.setItem('TokenPQAuto', "No");
                }
                document.cookie = "LoginPQ="+login;
                window.location = "<?php echo constant('RUTA_URL');?>/redireccionLogin?Val="+login;
              });
          } else {
              console.log(data);
          }
        }) 
    }
   
</script>
   