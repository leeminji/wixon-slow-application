<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class SL_Controller extends CI_Controller {
    
    protected $midx = null;

    function __construct(){
        parent::__construct();

        $member = array(
            'mb_id'=> 'admin',
            'mb_level' => 10,
            'mb_group' => 'G01'
        );

        $this->load->helper(array("alert","common", "menu"));
        $this->load->model('setting/menu_m');

		//현재화면 메뉴 고유번호
		$last_segment = $this->uri->total_segments();        
        $this->midx = ( is_numeric($this->uri->segment($last_segment))) ? $this->uri->segment($last_segment) : 1;

    }

    //로그인차단
    function _require_login($return_url)
	{
        // 로그인이 되어 있지 않다면 로그인 페이지로 리다이렉션
        if($this->session->userdata('logged_in') == null){
            $this->load->helper('alert');
			$msg = "로그인 먼저 해 주세요";
			$url = '/auth/login?return_url='.rawurlencode($return_url);            
            redirect($url);
        }
    }

    //로그인뷰
    function _login_view($page, $option=[]){
        $option = array(
            "header"=> "include/header_v",
            "footer"=> "include/footer_v",
            "page" => $page,
            "option" => $option
        );
        $this->load->view("layout/layout_login_v", $option);
    }

    //레이어뷰
    function _layer_view($page, $option=[]){
        // 로그인 체크
		$return_url = "/".uri_string();
        $this->_require_login($return_url);

        $option = array(
            "page" => $page,
            "option" => $option
        );
        $this->load->view("layout/layout_layer_v", $option);
    }

    //json 뷰
    function _json_view($result){
        // 로그인 체크
		$return_url = "/".uri_string();
        $this->_require_login($return_url);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));       
    }

    //기본뷰
    function _view($page, $option=[]){

        // 로그인 체크
		$return_url = "/".uri_string();
        $this->_require_login($return_url);
        
        //메뉴설정
        $this->normal_menu = get_to_menu($this->menu_m->get_all_items(1), $this->midx); //menu
        $this->manage_menu = get_to_menu($this->menu_m->get_all_items(2), $this->midx); //manager
        $this->account_menu = get_to_menu($this->menu_m->get_all_items(3), $this->midx); //account
        $this->setting_menu = get_to_menu($this->menu_m->get_all_items(4), $this->midx); //account 
        
        $menu_info = $this->menu_m->get_item($this->midx);
        $option = array(
            "header"=> "include/header_v",
            "footer"=> "include/footer_v",
            "sidebar"=>"include/sidebar_v",

            "page" => $page,
            "menu_info" => $menu_info,
            "option" => $option,
            "title" => "{$menu_info->mm_name} > SLOW",

            "normal_menu"=>$this->normal_menu,
            "manage_menu"=>$this->manage_menu,
            "account_menu"=>$this->account_menu,
            "setting_menu"=>$this->setting_menu,
        );

        $this->load->view("layout/main_v", $option);
    }
}

/* End of file SL_Controller.php */
/* Location: ./system/core/SL_Controller.php */
?>