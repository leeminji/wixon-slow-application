<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class SL_Controller extends CI_Controller {
    function __construct()
    {
        parent::__construct();
    }

    function _view($page, $option=[]){
        $option = array(
            "header"=> "include/header_v",
            "footer"=> "include/footer_v",
            "sidebar"=>"include/sidebar_v",
            "page" => $page,
            "option" => $option
        );
        
        $this->load->view("layout/main_v", $option);
    }
}

/* End of file SL_Controller.php */
/* Location: ./system/core/SL_Controller.php */
?>