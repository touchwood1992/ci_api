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

                return $this->response(array("error" => false , "token" => $encoded ,"msg" => array("Valid Logins")),REST_Controller::HTTP_OK);
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
            return $this->response(array("error" => true , "msg" => array("Invalid token.")) , REST_Controller::HTTP_BAD_REQUEST);
       }
       else
       {           
           $uid = $validated_id["uid"];

           //get details using this user id from database now
            $get_admin =   $this->admin_model->get_admin($uid);

            if($get_admin ===  false)
            {
                $this->response(array("error" => true, "msg" => array("Invalid request")) , REST_Controller::HTTP_BAD_REQUEST);
            }
            else{
                $this->response(array("error" => false , "admin" => $get_admin) , REST_Controller::HTTP_OK);
            }

       }
    }

    //Update admin user profile = update profile using jwt token
    function index_put()
    {
        //Always use json data or form url encoded data for put method in php.
        //If you want to upload images as well then pass images as base64 encoded form in json or for url encoded key so that in backend you can upload it using server methods....

        //If you want to pass form data then use POST method instead of PUT method....



       //Read Token from header and update this user's profile...
       $validated_id = JwtEncodeDecode::validate_token();
       
       if($validated_id === false)
       {
            return $this->response(array("error" => true , "msg" => array("Invalid token.")) , REST_Controller::HTTP_BAD_REQUEST);
       }
       else
       {        
           $uid = $validated_id["uid"];

           //Reading request values...


           //Validating request values...


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
            return $this->response(array("error" => true , "msg" => array("Invalid token.")),REST_Controller::HTTP_BAD_REQUEST);
       }
       else
       {
           $uid = $validated_id["uid"];
           //Delete user using above user id...

           $delete_user = $this->admin_model->delete_admin($uid);
           if($delete_user === false)
           {
               $this->response( array("error" => true , "msg" => array("Error while deleting account...")), REST_Controller::HTTP_BAD_REQUEST);
           }
           else
           {
            $this->response( array("error" => false , "msg" => array("Account deleted Successfully...")), REST_Controller::HTTP_OK);
           }
       }
    }
}
?>