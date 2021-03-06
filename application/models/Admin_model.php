<?php 
class Admin_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }

    //Signup
    function create_admin($fields)
    {
        
        $this->db->insert("admins",$fields);
        //print_r($this->db->error()); exit;
        $last_insert_id = $this->db->insert_id();
        if($last_insert_id > 0)
        {
            return $last_insert_id;
        }
        else
        {
            return false;
        }
    }
    
    //Login
    function login_admin($uname , $password)
    {
        $this->db->select("aid");

        $this->db->group_start();
        $this->db->where("aemail" , $uname);        
        $this->db->or_where("aname" , $uname);
        $this->db->group_end();

        $this->db->where("apassword" , md5($password));
        $user =   $this->db->get("admins");

        //print_r($this->db->last_query());

        if($user->num_rows() > 0)
        {
          $user_row =   $user->row_array();
          return $user_row['aid'];
        }
        else
        {
            return false;
        }
    }

    //Get Profile
    function get_admin($id)
    {
        $this->db->select("aid,aname,aemail,adate");
        $this->db->where("aid" , $id );
        $admin = $this->db->get("admins");

        if($admin->num_rows() > 0)
        {
            $ar = $admin->row_array();
            return $ar;
        }
        else {
            return false;
        }
        
    }

    //Update profile
    function update_admin($id , $fields)
    {
            
    }

    //Delete profile    
    function delete_admin($id)
    {
        $deleted = $this->db->delete("admins" , array("aid" => $id));
        
        if($deleted)
        {
            //Delete all records from users table as well.....
            return true;
        }
        else
        {
            return false;
        }

    }
}
?>