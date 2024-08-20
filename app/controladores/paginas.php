<?php 
class Paginas extends Controlador{
    public function __construct(){
        //$this->articuloModelo = $this->modelo('Articulo');
    }
    #|->INDEX Y ADMINSITRACION PRINCIPAL
    public function index(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Administración',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Administracion/Administracion', $datos);
            }else if ($_SESSION['rol']==125) {
                # Clientes
                $datos = [
                    'titulo'    => 'Administración',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Administracion/Administracion', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Administración',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Administracion/AdminCliente', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Administración',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Administracion/AdminAgente', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    #|->FIN INDEX Y ADMINSITRACION PRINCIPAL

    #|->LOGIN Y REGISTRO
    public function ingresar(){
        $datos = [
            'titulo' => 'Login'
        ];
        $this->vista('paginas/Login/ingresar', $datos);
    }
    public function registro(){
        
        $datos = [
            'titulo' => 'Registros'
        ];
        $this->vista('paginas/Login/registro', $datos);
    }
    //SIN CONFIGURAR
    public function olvido(){
        
        $datos = [
            'titulo' => 'Recuperar Contraseña'
        ];
        $this->vista('paginas/Login/olvido', $datos);
    }
    #|->FIN LOGIN Y REGISTRO

    #|->REDIRECCION DESDE LOGIN
    public function redireccionLogin($Val){
        //procesar aqui el redireclogin
        $datos = [
            'Val' => $Val
        ];
        $this->vista('paginas/redireccionLogin', $datos);
    }
    #|->FIN REDIRECCION DESDE LOGIN
    
    #|->TAREAS 
    ##|->MODULO ADMINISTRACION
    public function lsttareas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }

    public function tareas($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'tareaID'  => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/AMTareas', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'    => 'Agentes',
                    'tareaID'   => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/AMTareas', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }

    public function lsttareasaceptadas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas aceptadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasAceptadas', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasAceptadas', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }

    public function lsttareasencurso(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasCurso', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Tareas en curso',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasCurso', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }

    public function lsttareasfinalizadas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas finalizadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasFinalizadas', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasFinalizadas', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function lsttareasfalladas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas Falladas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasFalladas', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Falladas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaTareasFalladas', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/Tareas/ListaTareas', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    ##|->MODULO TAREAS CLIENTES
    public function lstsolicitadas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Tareas Solicitadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaClientesSolicitadas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/inicio', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function lstaprobadas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Tareas Aprobadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaClientesAprobadas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Tareas',
                ];
                $this->vista('paginas/inicio', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function lstaceptadas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisor
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Tareas Aceptadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaClientesAceptadas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Tareas Aceptadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaAgentesAceptadas', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
    }
    public function lstencurso(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Tareas en Curso',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaClientesEnCurso', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Tareas en Curso',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaAgentesEnCurso', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
    }

    public function lstfinalizadas(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Tareas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Tareas Finalizadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaClientesFinalizadas', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Tareas Finalizadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Tareas/ListaAgentesFinalizadas', $datos);
            } 
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
    }
    
    #|->FIN TAREAS 

    #|->AGENTES 
    public function lstagentes(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Agentes/ListaAgentes', $datos);
            }else if ($_SESSION['rol']==125) {
                # Superivsor
                $datos = [
                    'titulo'    => 'Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Agentes/ListaAgentes', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [                   
                    'titulo'    => 'Perfil',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Agentes/Perfil', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function agentes($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Agentes',
                    'agenteID'  => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Agentes/AMAgentes', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'    => 'Agentes',
                    'agenteID'  => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }

    public function uploadagentes(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Subir Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Agentes/SubirExcelAgentes', $datos);
            }else if ($_SESSION['rol']==125) {
                # supervisores
                $datos = [
                    'titulo'    => 'Subir Agentes',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Agentes/SubirExcelAgentes', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # agentes
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    #|->FIN AGENTES 

    #|->CLIENTES 
    public function lstclientes(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'         => 'Empresas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/ListaClientes', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'         => 'Empresas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/ListaClientes', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [                   
                    'titulo'    => 'Perfil',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/Perfil', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Administración',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function clientes($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Agentes',
                    'clienteID'  => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/AMClientes', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'    => 'Agentes',
                    'clienteID'  => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/AMClientes', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Perfil',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    #|-->INFORME ESTANDAR DE CLIENTES
    public function finalcliente(){
        //MUESTRA CON VISTA DE CLIENTE
        $datos = [
            'titulo' => 'Contizacion Cliente'
        ];
        $this->vista('paginas/informeCliente', $datos);
    }
    public function rtainforme($id){
        //MUESTRA INTERNA EN ADJUDICADA
        $datos = [
            'titulo' => 'Informe tasknow',
            'cotID'  => $id
        ];
        $this->vista('paginas/rtaCliente', $datos);
    }
    public function rtafin(){
        //MUESTRA INTERNA EN ADJUDICADA
        $datos = [
            'titulo' => 'Respuesta tasknow'
        ];
        $this->vista('paginas/rtaClienteFin', $datos);
    }
    #|--->FORMULARIO EXTRA CLIETNES PARA TAREAS
    public function extratareas($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Forulario Tareas Extra',
                    'clienteID'  => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/LstFormExtra', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'    => 'Forulario Tareas Extra',
                    'clienteID' => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/LstFormExtra', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Perfil',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    

    ##|->Lista de sucursales
    public function lstretails(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'         => 'Empresas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/ListaRetails', $datos);
            }else if ($_SESSION['rol']==125) {
                # Clientes
                $datos = [
                    'titulo'         => 'Empresas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/ListaRetails', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    ##|->upload por excel de sucursales
    public function uploadretails(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Empresas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/SubirExcel', $datos);
            }else if ($_SESSION['rol']==125) {
                # Clientes
                $datos = [
                    'titulo'    => 'Empresas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/SubirExcel', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    ##|->ABM Sucursales
    public function sucursales($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'     => 'Agentes',
                    'sucursalID' => $id,
                    'userID'     => $_SESSION['id'],
                    'empresaID'  => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/AMSucursales', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'     => 'Agentes',
                    'sucursalID' => $id,
                    'userID'     => $_SESSION['id'],
                    'empresaID'  => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Clientes/AMSucursales', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    #|->FIN CLIENTES 

    #|->USUARIOS 
    public function lstusuarios(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Usuarios',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Usuarios/ListaUsuarios', $datos);
            }else if ($_SESSION['rol']==125) {
                # Clientes
                $datos = [
                    'titulo'    => 'Usuarios',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Usuarios',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Usuarios',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function usuarios($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Usuarios',
                    'usuarioID' => $id,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Usuarios/AMUsuarios', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'         => 'Usuarios',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Usuarios',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Usuarios',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function cambiopass(){
        if(isset($_SESSION['nombre'])){ 
            if($_SESSION['rol']==100){
                $datos = [
                    'titulo'    => 'Cambio de Contraseña',
                    'usuarioID' => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID']
                ];
            }elseif ($_SESSION['rol']==125) {
                $datos = [
                    'titulo'    => 'Cambio de Contraseña',
                    'usuarioID' => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID']
                ];
            }elseif ($_SESSION['rol']==150) {
                $datos = [
                    'titulo'    => 'Cambio de Contraseña',
                    'usuarioID' => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID']
                ];
            }elseif ($_SESSION['rol']==200) {
                $datos = [
                    'titulo'    => 'Cambio de Contraseña',
                    'usuarioID' => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID']
                ];
            }              
            $this->vista('paginas/Usuarios/CambioPassword', $datos);
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
    }
    #|->FIN USUARIOS 

    #|-> PAÑOL
    public function lstpanol(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Lista de Inventarios',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/ListaPanol', $datos);
            }else if ($_SESSION['rol']==125) {
                # Clientes
                $datos = [
                    'titulo'    => 'Lista de Inventarios',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/ListaPanol', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Lista de Inventario',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/ListaPanolCliente', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    
    public function panol($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'     => 'Pañol',
                    'panolID'    => $id,
                    'userID'     => $_SESSION['id'],
                    'empresaID'  => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/AMPanol', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'     => 'Pañol',
                    'panolID'    => $id,
                    'userID'     => $_SESSION['id'],
                    'empresaID'  => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/AMPanol', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'     => 'Pañol',
                    'panolID'    => $id,
                    'userID'     => $_SESSION['id'],
                    'empresaID'  => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/AMPanolCliente', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }

    public function panolkits($id){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'     => 'Elementos de Kits',
                    'panolID'    => $id,
                    'userID'     => $_SESSION['id'],
                    'empresaID'  => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/AMPanolKits', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'     => 'Elementos de Kits',
                    'panolID'    => $id,
                    'userID'     => $_SESSION['id'],
                    'empresaID'  => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/AMPanol', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }

    public function uploadpanol(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Subir Inventario',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/SubirExcelPanol', $datos);
            }else if ($_SESSION['rol']==125) {
                # supervisores
                $datos = [
                    'titulo'    => 'Subir Inventario',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/SubirExcelPanol', $datos);
            }else if ($_SESSION['rol']==150) {
                # clientes
                $datos = [
                    'titulo'    => 'Subir Inventario',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Panol/SubirExcelPanolCliente', $datos);
            }else if ($_SESSION['rol']==200) {
                # agentes
                $datos = [
                    'titulo'         => 'Empresas',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    #|-> FIN MODULO PAÑOL

    #|->EMPRESA | ENTORNOS
    public function correo(){
        if(isset($_SESSION['nombre'])){
            if($_SESSION['rol']==100){
                # Admistradores
                $datos = [
                    'titulo'    => 'Conf. Correo',
                    'clienteID'  => 1,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Entornos/AMCorreos', $datos);
            }else if ($_SESSION['rol']==125) {
                # Supervisores
                $datos = [
                    'titulo'    => 'Conf. Correo',
                    'clienteID' => 1,
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/Entornos/AMCorreos', $datos);
            }else if ($_SESSION['rol']==150) {
                # Clientes
                $datos = [
                    'titulo'    => 'Perfil',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/inicio', $datos);
            }else if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'         => 'Inicio',
                ];
                $this->vista('paginas/inicio', $datos);
            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }


    #|->SUBMODULO AGENTES SEGUN APP.
    public function tomartarea(){
        if(isset($_SESSION['nombre'])){
            if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Tomar tarea',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/TareasAgentes/TomarTarea', $datos);
            }else{

            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function tareasasignadas(){
        if(isset($_SESSION['nombre'])){
            if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Tareas asignadas',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/TareasAgentes/TareasAsignadas', $datos);
            }else{

            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    public function tareasencurso(){
        if(isset($_SESSION['nombre'])){
            if ($_SESSION['rol']==200) {
                # Reponedores
                $datos = [
                    'titulo'    => 'Tareas en curso',
                    'userID'    => $_SESSION['id'],
                    'empresaID' => $_SESSION['empresaID'],
                ];
                $this->vista('paginas/TareasAgentes/TareasEnCurso', $datos);
            }else{

            }
        }else{
            $datos = [
                'titulo' => 'Ingresar'
            ];
            $this->vista('paginas/Login/ingresar', $datos);
        }    
        
    }
    
}