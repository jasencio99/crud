<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** access library REST_Controller, remember is library is a REST Server resource*/
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


class Api_User extends REST_Controller 
{
    public function __construct() {
        parent::__construct();
      
        $this->load->model('Model_Usuarios','user');
     
    }

//Recibe como parametro al Usuario, para obtener sus credencias y vericar si la contraseña es válida
    function index_get ()
    
    {
        $valores= count($_GET);
        if(isset($_GET['usuario'])&& $valores==1)
    { 
        $usuario = $this->input->Get("usuario");
        if( $this->user->existe($usuario))
        {
            $datos= $this->user->existe($usuario);
            $dat = $datos->id;
            
            $res = array
                (
                    'status'=>1,
                    'data'=>$this->user->existe($usuario),
                    'codigo'=>$this->user->enviaCodigo($dat)
                );
        }
        else
        {
            $res = array
                (
                    'status'=>0
                    
                );

        }
    }
    else if(isset($_GET['email'])&& $valores==1)
    {
        $email= $this->input->Get("email");
        if($this->user->email($email))
        {
        $res = array
        (
            'data'=>$this->user->email($email)
            
        );
    }
    else
    {
        $res = array
        (
            'data'=>'No encontrado'
            
        );

    }
    }
       
        $this-> response($res,200);
       

    }

    public function index_post()
    {
       
        //Contamos los valores que vienen en el métod post
        $valores= count($_POST);

        //En caso que el Metodo POST contenga 8 valores, ejecutamos la funcion de SaveUser
     if($valores===8)
       {
        
            $nombres = $this->input->post("nombres");
		    $apellidos = $this->input->post("apellidos");
		    $carrera = $this->input->post("carrera");
            $anio = $this->input->post("anio");
            $correlativo = $this->input->post("correlativo");
		    $email = $this->input->post("email");
            $codigo = $this->CreaCodigo(8);
            $login_id= $this->input->post("login_id");

   		
			$data = array
            (
				"nombres"=>$nombres,
				"apellidos"=>$apellidos,
				"carrera"=>$carrera,
                "anio"=>$anio,
                "correlativo"=>$correlativo,
				"email"=>$email,
                "codigo"=>$codigo,
                "login_id"=>$login_id
			
			);
           
                $datos = $this->user->saveUser($data);
          
                if($datos) 
            {

                $datos = array
                (
                    "status"=> 201,
                    "message"=> 'Usuario Creado'
                   
                );

                
            } 
            else 
            {

                $datos = array(
                    "status"=> 400,
                    "message"=> 'insert failed'
                   
                );
               
            }
          

        } 
        
        //En caso que en el método POST vayan 2 valore se ejecuta la funcion de SaveLogin
        else if($valores==2 && isset($_POST['usuario']))
        {
            $usuario = $this->input->post("usuario");
            $pass = $this->input->post("pass");
        
            //Hasheamos la contraseña por medio de la funcion que incluye PHP de password_hash
            $passHas = password_hash($pass, PASSWORD_DEFAULT);
        
        
            $data = array(
                "usuario"=>$usuario,
                "pass"=>$passHas
            );
           
                $datos = $this->user->saveLogin($data);
          
            if($datos) 
            {
                $id= $this->user->obtieneId();
                $datos = array(
                    "status"=> 200,
                    "message"=> 'login Creado',
                    "id"=>$id
                );

                
                
                } 
                else {
                $datos = array(
                    "status"=> 400,
                    "message"=> 'insert failed'
                   
                );
               
            }

        }
        
        //En caso que en el método POST vaya 1 valor se ejecuta la funcion de Actualiazar status
        else if($valores==1 && isset($_POST['codigo']))
        {
            $codigo = $this->input->post("codigo");
            
            $consulta = $this->user->codigo($codigo);
            $id = $consulta->login_id;

            $consulta2 = $this->user->verificaEstado($id);
            $estado = $consulta2->status;

            if($estado==0)
            {

                $datos = $this->user->update($id);
          
                    if($datos) 
                {
               
                         $datos = array
                    (
                        "status"=> 0,
                        "message"=> 'Verificado',
                    
                    );

                
                } 
                    else 
                {
                         $datos = array
                    (
                         "status"=> 400,
                         "message"=> 'Update failed',
                        "id"=>$id
                    );
               
                }
            }
            else
            {
                $datos = array
                (
                "status"=>1,
                "message"=> 'Codigo Invalido'
                );

            }

        

        } 
        else if($valores==2 && isset($_POST['fecha']))
        {
            $pass = $this->input->post("pass");
            $fecha= date("Y-m-d H:i:s");
          
            $passHas = password_hash($pass, PASSWORD_DEFAULT);

            
            $codigo = $this->CreaCodigo(8);
            $datos = $this->user->codigoRec($id, $codigo);
          
            if($datos) 
        {
       
                 $datos = array
            (
                "status"=> 0,
                "message"=> 'Verificado'
            
            );

        
        } 
            
        } 

        else if($valores==1 && isset($_POST['login_id']))
        {
            $id = $this->input->post("login_id");
            $fecha= date("Y-m-d H:i:s");
          
            //$passHas = password_hash($pass, PASSWORD_DEFAULT);

            $codigo = $this->CreaCodigo(8);
            $datos = $this->user->codigoRec($id, $codigo);
          
            if($datos) 
        {
                 $datos = array
            (
                "status"=> 1,
                "message"=> 'Codigo Generado'
            
            );

        
        } 
            
           
        

        } 
       
       
			
        $this-> response($datos,200);
        

    }

    //Funcion que genera el código de 8 dígitos

    function CreaCodigo($num)
{
    $codigo ="";
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        
    $max = strlen($cadena); 

    for ($i=0; $i < $num; $i++) {
        $codigo .= $cadena[mt_rand(0, $max-1)];
    }

    if($this->user->existecodigo($codigo))
    {
        CreaCodigo(8);
        
    }
    else
    {
        return $codigo;
    }
  

}

}