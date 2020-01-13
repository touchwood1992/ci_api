<?php
//All these below methods works because in config file we have configured composer_autoload to  TRUE. app/There we have installed jwt using composer....

use \Firebase\JWT\JWT;

class JwtEncodeDecode
{
    static function jwt_encode($payload)
    {
            //CI instance to get all library and all config , helper properties...
            $CI =& get_instance();

            //Getting key from config file...
            $key = $CI->config->item("jwt_key");

            //Encode jwt now...
            try {
                return $jwt = JWT::encode($payload, $key);
            } catch (\Throwable $th) {
                return false;
            }
        
    }
    
    static  function jwt_decode($jwt)
    {
        //CI instance to get all library and all config , helper properties...
        $CI =& get_instance();

        //Getting key from config file...
        $key =  $CI->config->item("jwt_key");

        //Decode jwt now...
        try {
            return $decoded = JWT::decode($jwt, $key , array('HS256'));
        } catch (\Throwable $th) {
            return false;
        }    
    }

    static function validate_token()
    {        
        $CI =& get_instance();
        
        //Get all Headers from incoming request...        
        $all_headers = $CI->input->request_headers();

        //Checking that out header exists in incoming request or not...
        $token  = isset($all_headers["auth-token"] ) ? $all_headers["auth-token"]  : "";

        if($token === "")
        {
            (new self)->throw_out("Token Missing",401);
        }
        else
        {
            //Validate Token
            $decoded_value = self::jwt_decode($token);
            if($decoded_value === false)
            {
                (new self)->throw_out("Invalid Token",401);
            }
            else
            {
                    //Append user id to request fro further process in controller...
            }
        }
        
    }
    function throw_out($msg,$status)
    {
        $CI =& get_instance();
        $CI->output->set_status_header($status);  
        $CI->output->set_content_type('application/json', 'utf-8');    
        $CI->output->set_output(json_encode(array("error" => true , "msg" => array($msg)), JSON_PRETTY_PRINT)); 
        $CI->output->_display();
        exit;;
    }
}
?>