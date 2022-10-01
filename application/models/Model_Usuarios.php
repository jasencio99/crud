<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Usuarios extends CI_Model 
{
    public function existe($user)
    {
        $this->db->select('id,usuario, pass, status');
        $this->db->from("tb_login");
        $this->db->where("usuario",$user);
        $result=$this->db->get()->row();
        return $result;

    }


    public function verificaEstado($id)
    {
        $this->db->select('status','usuario');
        $this->db->from("tb_login");
        $this->db->where("id", $id);
        $result=$this->db->get()->row();
        return $result;

    }



    public function codigo($codigo)
    {
        $this->db->select('login_id, codigo');
        $this->db->from("tb_usuarios");
        $this->db->where("codigo", $codigo);
        $result=$this->db->get()->row();
        return $result;
       
    }

    //Verifica si el codigo ya existe, lo usamos para volver a ejecutar la funcion genera código
    public function Existecodigo($codigo)
    {
        $this->db->select('codigo');
        $this->db->from("tb_usuarios");
        $this->db->where("codigo", $codigo);
        $result=$this->db->get()->row();
        return $result;
       
    }

    //Obtenemos el código del usuario
    public function enviaCodigo($login_id)
    {
        $this->db->select('codigo, email');
        $this->db->from("tb_usuarios");
        $this->db->where("login_id", $login_id);
        $result=$this->db->get()->row();
        return $result;
       
    }

        //Crea las credenciales
    public function saveLogin($data)
       {     
           return $this->db->insert('tb_login', $data);        
       }

       //Crea el Usuario con sus datos
       public function saveUser($data)
       {     
           return $this->db->insert('tb_usuarios', $data);        
       }

       //Obtiene el ultimo valor creado en la tabla tb_login, lo usamos para pasarselo como FK a la tabla tb_suarios
       public function obtieneId()
       {     
        $this->db->select_max('id');
        $this->db->from("tb_login");
        $result=$this->db->get()->row();
        return $result;    
       }

       //Cambia el estatus inicial del usuario de 0 a 1, 0(No validado), 1(validado)

       public function update($id)
       {
        $sql = "UPDATE `tb_login` SET `status` = 1 WHERE `id` = '$id';";
        return $query = $this->db->query($sql);   
        }


        public function email($email)
    {
        $this->db->select('login_id, email');
        $this->db->from("tb_usuarios");
        $this->db->where("email", $email);
        $result=$this->db->get()->row();
        return $result;
       
    }


        public function codigoRec($id, $codigo)
       {
        $sql = "UPDATE `tb_login` SET `codigo_rec` = '$codigo' WHERE `id` = '$id';";
        return $query = $this->db->query($sql);   
        }

        public function updatepass($id, $fecha, $pass)
       {
        $sql = "UPDATE `tb_login` SET `fecha_modificacion` = '$fecha', `pass` = '$pass'  WHERE `id` = '$id';";
        return $query = $this->db->query($sql);   
        }


   

}