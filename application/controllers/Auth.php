<?php
require APPPATH . 'libraries/REST_Controller.php';
class Auth extends  REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("admin_model");
    }

    //Login and create token

    function index_post()
    {
             $username = $this->input->post("uname");
             $password = $this->input->post("password");

             //Validate the posted data

             $this->form_validation->set_rules("uname" , "Username" ,"required");
             $this->form_validation->set_rules("password", "Password" , "required");

             if($this->form_validation->run() == FALSE)
             {
                 $errors = $this->form_validation->error_array();
                    return $this->response(array("error" => true , "msg" => array_values($errors) ) , REST_Controller::HTTP_BAD_REQUEST);
             }
             else
             {
                 //Check for login
                    $valid = $this->admin_model->login_admin($username , $password);
                    if($valid === false)
                    {
                            return $this->response(array("error" => true , "msg" => array("Invalid Logins")) , REST_Controller::HTTP_BAD_REQUEST);
                    }
                    else {
                        //Generate access token and provide to user
                        $encoded = JwtEncodeDecode::jwt_encode(array("uid" => $valid , "timestamp"=>time()));
                        return $this->response(array("error" => false , "token" => $encoded ,"msg" => array("Valid Logins")) , REST_Controller::HTTP_OK);
                    }                 
             }
    }
}
?>