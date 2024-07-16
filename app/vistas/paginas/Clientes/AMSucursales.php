<?php require RUTA_APP . '/vistas/inc/header.php'; ?>
<?php require RUTA_APP . '/vistas/inc/menuLateral.php'; ?>
<?php 
    $empresaID = $datos['empresaID']; #|->EMPRESA LOGEADA
    $userID    = $datos['userID'];    #|->USUARIOS LOGEADO
    $sucursalID = $datos['sucursalID'];   #|->AGENTE QUE ESTOY CREANDO O EDITANDO

    #|->RECUPERAMOS DIRECCION GEOLOCALIZADA SI EXISTE Y LA INDICADA EN FORMULARIO
    if ($sucursalID > 0){
        $datos = file_get_contents(''.RUTA_URL.'/rest-api/Retail.php?sucursalID='.$sucursalID);
        foreach(json_decode($datos,true) as $confMaps):  
        $dirIndicada = $confMaps['indicada'];
        if($confMaps['direccion'] != ''){
                $geo = $confMaps['direccion'];
                $lat = $confMaps['lat'];
                $lon = $confMaps['lon'];
            } else {
                #|->INCIALIZO EN SANTIAGO 
                $geo = '';
                $lat = -33.4489;
                $lon = -70.6693;
            }
        endforeach;
    }
?>
<div class="content">
    <?php require RUTA_APP . '/vistas/inc/menuSuperior.php'; ?>

    <style>
        #map {
            height: 500px;
            width: 100%;
        }
        #search-input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 10px;
        }
    </style>

    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-outline-primary btn-sm mr-1 mb-1" type="button" 
            href="<?php echo constant('RUTA_URL'); ?>/lstretails">
                <span class="fas fa-arrow-alt-circle-left me-1" data-fa-transform="shrink-3"></span>
                Regresar a Lista
            </a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Sucursal</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="nombre">Canal *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="canal" placeholder="Grandes superficies" aria-label="" value="" />
                    
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="codigo">Codigo *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="codigo" placeholder="Ej: E503" aria-label="" value="" />
                    <small>Este codigo debe ser unico</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="cadena">Cadena *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="cadena" placeholder="" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="local">Local *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="local" placeholder="" aria-label="" value="" />
                    <small>EJ: E503-ESSY-MAIPU</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="direccion">Dirección *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="direccion" placeholder="" aria-label="" value="" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="formato">Fromato *</label>
                <div class="col-sm-9">
                    <input class="form-control form-control-sm" type="text" id="formato" placeholder="" aria-label="" value="" />
                </div>
            </div>
            <hr>
            <div class="form-group text-center">
                <?php  if ($sucursalID > 0){?> 
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Actualizar
                    </button>
                <?php  }else{ $sucursalID=0; ?>
                    <button class="btn btn-outline-primary btn-sm me-1 mb-1" type="button" onclick="Controlar_Requeridos();">
                        <span class="fas fa-sd-card" data-fa-transform="shrink-3"></span> Guardar
                    </button>
                <?php  }?> 
            </div>
        </div>
    </div>
    <?php  if ($sucursalID > 0){?> 
    <!-- Mapa y buscador -->
    <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Ubique la sucursal en el mapa</h5> 
                <h5><?=$dirIndicada?></h5>                   
            </div>
            <div class="card-body">
                <input id="search-input" type="text" placeholder="Ingresa una dirección" value="<?php if($geo != '') { echo $geo; } ?>"/>
                <div id="map"></div>
                <button id="capture-coordinates" class="btn btn-primary mt-3">Capturar y Guardar Ubicación</button>
                <div id="coordinates" class="mt-2"></div>
            </div>
        </div>
    <?php  }?> 
</div>
<?php require RUTA_APP . '/vistas/inc/footer.php'; ?>
<script>
    $(document).ready(function ()
    {
        var sucursalID  = <?php echo $sucursalID; ?>;
        var empresaID   = <?php echo $empresaID; ?>;
        if(sucursalID>0){
            var url ='<?php echo constant('RUTA_URL'); ?>/rest-api/Retail?sucursalID='+sucursalID+'&consultaGET='+empresaID;
            fetch(url)
            .then(response => response.json())
            .then(data => {
                $.each(data, function(i, item) {
                    if(sucursalID==item.id){
                        //`canal`, `cod_local`, `cadena`, `local`, `direccion`, `lat`, `lon`, `formato_local`
                        $('#canal').val(item.canal); 
                        $('#codigo').val(item.cod_local);
                        $('#cadena').val(item.cadena);
                        $('#local').val(item.local);
                        $('#direccion').val(item.direccion);
                        $('#formato').val(item.formato_local);
                    } 
                });   
            });
           
        }else{

        }    
        
    });
    function Controlar_Requeridos() 
    {
        var canal     = document.querySelector('#canal').value;
        var codigo    = document.querySelector('#codigo').value;
        var cadena    = document.querySelector('#cadena').value;
        var local     = document.querySelector('#local').value;
        var direccion = document.querySelector('#direccion').value;
        var formato   = document.querySelector('#formato').value;
        if(canal === '' || codigo==='' || cadena==='' || local==='' || direccion === '' || direccion === '' || formato===''){  //SI NO VALIDA CORRECTAMENTE TIRA CARTEL
            swal({
                type : 'error',
                title: 'Error!',
                text : 'Todos los datos son requeridos!'
            })
        } else { // CUANDO LOS CAMPOS SON CORRECTOS, EJECUTO AJAX
            Actualizar_Cliente();
        }    
    }
 
    function Actualizar_Cliente()
    {
        var userID     = <?php echo $userID ?>;
        var sucursalID = <?php echo $sucursalID; ?>;
        var empresaID  = <?php echo $empresaID; ?>;
        if(sucursalID==0)
        { 
            var Accion    = 'Crear';
            var rtaAccion = 'Creada!'; 
            var metodo    = 'POST'; 
        }else{
            var Accion    = 'Actualizar';  
            var rtaAccion = 'Actualizada!'; 
            var metodo    = 'PUT'; 
        }
       
        var canal     = document.querySelector('#canal').value;
        var codigo    = document.querySelector('#codigo').value;
        var cadena    = document.querySelector('#cadena').value;
        var local     = document.querySelector('#local').value;
        var direccion = document.querySelector('#direccion').value;
        var formato   = document.querySelector('#formato').value; 
        Swal.fire({
            title: '<strong>Confirma '+Accion+'?</strong>',
            icon : 'info',
            html : 'Sucursal <b>'+codigo +'</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> '+ Accion +'!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/Retail'; 
                var data = { 
                    sucursalID : sucursalID,
                    usuarioID  : userID,
                    canal      : canal,
                    codigo     : codigo,
                    cadena     : cadena,
                    local      : local,
                    direccion  : direccion,
                    formato    : formato,
                    empresaID  : empresaID
                } 
                fetch(apiUrl,{ 
                    method : metodo,  
                    headers: {'Content-type' : 'application/json'},
                    body   : JSON.stringify(data) 
                })
                .then(response => response.json() )
                .then(data => {
                    console.log(data);
                    if(data[0]["error"]){
                        Swal.fire({
                            type : 'error',
                            icon : 'error',
                            title: ''+data[0]["error"]+'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }else{
                        var retornoID = data[0]['retornoID']; 
                        Swal.fire({
                            type : 'success',
                            icon : 'success',
                            title: 'Sucursal '+ rtaAccion +'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(redireccion, 2000); 
                    }
                }) 

            }   
        })
    }

    function redireccion(){
        window.location = "<?php echo constant('RUTA_URL');?>/lstretails";
    }
</script>
<?php  if ($sucursalID > 0){?> 
<script>
        function guardarGeo(direccion, lat, lon) {
        var sucursalID = <?=$sucursalID?>;
        var Accion    = 'Actualizar';  
        var rtaAccion = 'Actualizado!'; 
        var metodo    = 'PUT'; 
        Swal.fire({
            title: '<strong>Confirma actualizar?</strong>',
            icon : 'info',
            html : 'ubicacion real <b>' + direccion + '</b> <br/> ',
            showCancelButton : true,
            focusConfirm     : false,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> ' + Accion + '!',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText      : '<i class="fa fa-thumbs-down"></i> Cancelar',
            cancelButtonAriaLabel : 'Thumbs down'
        }).then((result) => {
            if (result.value) {
                var apiUrl='<?php echo constant('RUTA_URL'); ?>/rest-api/RetailGeoLoc.php'; 
                var data = { 
                    sucursalID : sucursalID,
                    direccion  : direccion,
                    lat        : lat,
                    lon        : lon
                } 
                fetch(apiUrl, { 
                    method : metodo,  
                    headers: {'Content-type' : 'application/json'},
                    body   : JSON.stringify(data) 
                })
                .then(response => response.json() )
                .then(data => {
                    console.log(data);
                    if(data[0]["error"]){
                        Swal.fire({
                            type : 'error',
                            icon : 'error',
                            title: ''+data[0]["error"]+'',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        var retornoID = data[0]['retornoID']; 
                        Swal.fire({
                            type : 'success',
                            icon : 'success',
                            title: 'Sucursal geolocalizada!',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval(redireccion, 2000); 
                    }
                }) 
            }   
        });
    }
</script>
<script>
    let map;
    let marker;
    let geocoder;
    let searchBox;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: <?=$lat?>, lng: <?=$lon?> }, // Coordenadas iniciales (Santiago, Chile)
            zoom: 13,
        });

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
        });

        geocoder = new google.maps.Geocoder();
        searchBox = new google.maps.places.SearchBox(document.getElementById("search-input"));

        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                marker.setPosition(place.geometry.location);
                map.fitBounds(bounds);
            });
        });

        document.getElementById("capture-coordinates").addEventListener("click", () => {
            const position = marker.getPosition();
            document.getElementById("coordinates").innerHTML = `Latitud: ${position.lat()}, Longitud: ${position.lng()}`;
            const direccion = document.getElementById("search-input").value;
            guardarGeo(direccion, position.lat(), position.lng());
        });

        // Si hay una dirección geolocalizada, mover el marcador a esa posición
        <?php if ($geo != ''): ?>
            const latLng = new google.maps.LatLng(<?=$lat?>, <?=$lon?>);
            marker.setPosition(latLng);
            map.setCenter(latLng);
        <?php endif; ?>
    }

    window.initMap = initMap;

</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC87UYx0rcft_8bj0fqLHlV1nBJRyNvJo&callback=initMap&libraries=places"></script>
<?php  }?>