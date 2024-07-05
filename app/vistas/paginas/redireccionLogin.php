<?php
$string = $datos['Val'];
//$string = json_encode($_COOKIE["LoginNow"]);
$string    = json_encode($string);
$datosX    = json_decode($string,true);
$porciones = explode(",", $datosX);  
$rol       =$porciones[2];
//INICIO LA SESSION
$_SESSION['id']        = $porciones[0]; // PASO USUARIO ID
$_SESSION['nombre']    = $porciones[1]; // PASO NOMBRE DE USUARIO
$_SESSION['rol']       = $porciones[2]; // PASO ROL
$_SESSION['token']     = $porciones[3]; // PASO TOKEN
$_SESSION['empresaID'] = $porciones[4]; // PASO TOKEN
$_SESSION['login']     = True;          // CREO UN DATOS MAS DE LOING EN TRUE

//header("Location: https://testpaquteria.sistema-online.cl/inicio");
//exit();
?>
<script>
    //POR TODOS LOS CASOS REDIRECCIONO A HOME
    window.location = "<?php echo constant('RUTA_URL');?>/inicio";
</script>
<?php //if($rol==150){ ?>
    <!--
    <script>
        //POR TODOS LOS CASOS REDIRECCIONO A HOME
        window.location = "<?php//echo constant('RUTA_URL');?>/inicio";
    </script>
    -->
<?php //}else if($rol==100) {?>
<!--
    <script>
        window.location = "<?php// echo constant('RUTA_URL');?>/inicio";
    </script>
    -->
<?php //}  ?>