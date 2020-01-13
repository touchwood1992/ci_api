<?php
class User_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }

    //Getting all users
    function get_all_users()
    {
      $all_users =  $this->db->get("users");

      if($all_users->num_rows() > 0)
      {
          return $all_users->result_array();
      }
      else {
          return false;
      }
    }

    //Insert New User
    function create_user($data)
    {
        $this->db->insert("users",$data);
        $inserted_id = $this->db->insert_id();
        if($inserted_id)
        {
            return $inserted_id;
        }
        else
        {
            //Error message get from CI
                //echo $this->db->error()['message']; exit;
            return false;
        }
    }

    //Getting Particular users
    function get_user($id)
    {
            echo $id; exit;
    }

    //Update Existing User
    function update_user()
    {

    }

    //Delete User
    function delete_user($id)
    {
            $deleted = $this->db->delete("users",array("uid" => $id));
            if($deleted)
            {
                return true;
            }
            else
            {
                return false;
            }
    }
}
?>