<?php
require APPPATH . 'libraries/REST_Controller.php';
class Users extends REST_Controller
{
        
        public function __construct()
        {
                parent::__construct();
                $this->load->model("user_model");
        }
        
        //GET All users and single User
        public function index_get($id = 0)
        {
                //Checking if id exists then get particular user's detail
                if($id>0)
                {
                        $this->user_model->get_user($id);
                }
                else
                {
                        /*===================================================*/
                        /* ==================Set custom content type============*/
                                //$this->response->format = "json";
                        /*===================================================*/                                

                        $all_users = $this->user_model->get_all_users();
                        if($all_users === false)
                        {       
                                /*===================================================*/
                                        /* ==================Set custom HEADERS============*/
                                                // header('X-total-pages: 5000');                        
                                                // header('Page: 56');
                                /*===================================================*/                        
                                
                                $this->response(array("msg" => "No user Found." , "data" => array()), REST_Controller::HTTP_OK);

                        }
                        else {
                                $this->response(array("msg" => "Users Found." , "data" => $all_users), REST_Controller::HTTP_OK);
                        }
                }                
                
        }
        
        //Create User with post method
        public function index_post()
        {     
                /*===================================================*/
                //If json data is posted then add below snippests..... Else Remove it.
                                
                 $input = file_get_contents("php://input");
                 $input_decode = json_decode($input , true);

                $uname = isset($input_decode["uname"]) ? $input_decode["uname"] : "";
                $uemail = isset($input_decode["uemail"]) ? $input_decode["uemail"] : "";
                $upassword = isset($input_decode["upassword"]) ? $input_decode["upassword"] : "";
                $ucpassword = isset($input_decode["ucpassword"]) ? $input_decode["ucpassword"] : "";


                 $data = array(
                        'uname' => isset($uname) ? $uname : "",
                        'uemail' => isset($uemail) ? $uemail : "",
                        'upassword' => isset($upassword) ? $upassword : "",
                        'ucpassword' => isset($ucpassword) ? $ucpassword : "",
                );

                $this->form_validation->set_data($data);                
                /*===================================================*/

                $this->form_validation->set_rules("uname", 'Username', 'required|is_unique[users.uname]');
                $this->form_validation->set_rules('uemail', 'Email', 'required|valid_email|is_unique[users.uemail]');
                $this->form_validation->set_rules('upassword', 'Password', 'required');
                $this->form_validation->set_rules('ucpassword', 'Confirm Password', 'required|matches[upassword]');


                //Validate this form
                if ($this->form_validation->run() == FALSE)
                {                        
                       $errors =  $this->form_validation->error_array();
                       return $this->response(array("error"=> true , "msg" =>  array_values($errors) ),REST_Controller::HTTP_BAD_REQUEST);
                }
                else
                {
                       $create_user = $this->user_model->create_user(
                               array(
                                       "uname" => $uname,
                                       "uemail" => $uemail,
                                       "upassword" => md5($upassword)
                                )
                        );

                       if($create_user === false)
                       {
                                return $this->response(array("error" => true , "msg" => array("Error while creating user.")) , REST_Controller::HTTP_BAD_REQUEST);
                       }
                       else
                       {
                               return $this->response(array("error" => false , "msg" => array("Signup Seccessfully.")), REST_Controller::HTTP_CREATED);
                       }
                }
        }

        //Update User with PUT method.
        public function index_put($id)
        {
                echo "PUT".$id;
        }

        //Delete user with Delete method
        public function index_delete($id)
        {
              $deleted =   $this->user_model->delete_user($id);
              if($deleted === true)
              {
                        echo "deleted";
              }
              else
              {
                        echo "Error";
              }
        }
}
?>