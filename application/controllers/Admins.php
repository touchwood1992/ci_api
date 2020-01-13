<?php
require APPPATH . 'libraries/REST_Controller.php';

class Admins extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("admin_model");
    }

    //Create admin user profile = signup
    function index_post()
    {
             
        //Stores values into variables from form post...
       $aname = $this->input->post("aname");
       $aemail = $this->input->post("aemail");
       $apassword = $this->input->post("apassword");
       $acpassword = $this->input->post("acpassword");

       //Validate all the request parameters
       $this->form_validation->set_rules('aname', 'Username', 'required|is_unique[admins.aname]');
       $this->form_validation->set_rules('aemail', 'Email', 'required|is_unique[admins.aemail]|valid_email');
       $this->form_validation->set_rules('apassword', 'Password', 'required');
       $this->form_validation->set_rules('acpassword', 'Confirm Password', 'required|matches[apassword]');

       if ($this->form_validation->run() == FALSE)
       {
            $errors =   $this->form_validation->error_array();
            
            return $this->response(array("error"=>true , "msg"=> array_values($errors)), REST_Controller::HTTP_BAD_REQUEST);
       }
       else
       {
            //Process inputed data to insert.....
            $insert_status = $this->admin_model->create_admin(
                array(
                    "aname" => $aname,
                    "aemail" => $aemail,
                    "apassword" => md5($apassword),                    
                )
            );

            if($insert_status == false)
            {
                $this->response(array("error" => true , "msg" => "Something went wrong..."),REST_Controller::HTTP_BAD_REQUEST);
            }
            else {
                //Generate JWT for this user....
                $encoded = JwtEncodeDecode::jwt_encode(array("uid" => $insert_status , "timestamp"=>time()));

                return $this->response(array("error" => false , "token" => $encoded ,"msg" => array("Valid Logins")));
            }
       }

    }

    //Get admin user profile using jwt token
    function index_get()
    {        
       //Read Token from header and get this user's data....

       $validated_id = JwtEncodeDecode::validate_token();
       
       if($validated_id === false)
       {
            return $this->response(array("error" => true , "msg" => array("Invalid token.")));
       }
       else
       {
           $uid = $validated_id["uid"];
           //get details using this user id from database now

       }
    }

    //Update admin user profile = update profile using jwt token
    function index_put()
    {
       //Read Token from header and update this user's profile...
       $validated_id = JwtEncodeDecode::validate_token();
       
       if($validated_id === false)
       {
            return $this->response(array("error" => true , "msg" => array("Invalid token.")));
       }
       else
       {
           $uid = $validated_id["uid"];
           //update details using this user id from database now...
           
       }
    }

    //Delete admin user profile. = delete user  using jwt token
    function index_delete()
    {
        //Read Token from header and Delete this user's profile...
        $validated_id = JwtEncodeDecode::validate_token();
       
       if($validated_id === false)
       {
            return $this->response(array("error" => true , "msg" => array("Invalid token.")));
       }
       else
       {
           $uid = $validated_id["uid"];
           //Delete user using above user id...
       }
    }
}
?>