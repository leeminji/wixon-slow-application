<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class SL_Controller extends CI_Controller {
    
    protected $midx = null;

    function __construct(){
        parent::__construct();
        
        $this->load->helper(array("alert","common", "menu", "token", "formtag", "form"));
        $this->load->model('setting/menu_m');
        $this->load->model('auth/member_m');

        $this->_require_ip();

		//현재화면 메뉴 고유번호
		$last_segment = $this->uri->total_segments();        
        $this->midx = ( is_numeric($this->uri->segment($last_segment))) ? $this->uri->segment($last_segment) : null;
        
        //로그인 멤버정보
        if($this->session->userdata('logged_in')){ 
            $this->user_info = $this->session->userdata('userinfo');
        }
    }

    function _require_ip(){
        $client_ip = get_client_ip();
        if( !in_array($client_ip, $this->config->item('access_ips')) ){
            alert_back('접근 불가능한 IP 주소입니다.'.$client_ip);
        }
    }

    //window 뷰
    function _win_view($page, $option=[]){
        // 로그인 체크
		$return_url = uri_string();
        $this->_require_login($return_url);

        $option = array(
            "page" => $page,
            "option" => $option
        );
        $this->load->view("layout/layout_win_v", $option);
    }
    
    //로그인차단
    function _require_login($return_url)
	{
        // 로그인이 되어 있지 않다면 로그인 페이지로 리다이렉션
        if($this->session->userdata('logged_in') == null){       
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

    //modal 뷰
    function _modal_view($page, $option=[]){
        // 로그인 체크
		$return_url = uri_string();
        $this->_require_login($return_url);

        $option = array(
            "page" => $page,
            "option" => $option
        );
        $this->load->view("layout/layout_modal_v", $option);
    }
    
    //layer 뷰
    function _layer_view($page, $option=[]){
        // 로그인 체크
		$return_url = uri_string();
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
		$return_url = uri_string();
        $this->_require_login($return_url);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));       
    }

    //권한체크
    function _require_auth(){
        //var_dump($this->user_info);
        $member = $this->user_info;
        $menu_info = $this->menu_m->get_item($this->midx);
        $is_super = $member->mb_level == "M01" && $member->mb_group == "G01";
        $is_level = $menu_info->mm_level == null ? true : in_array($member->mb_level, explode(",", $menu_info->mm_level));
        $is_group = $menu_info->mm_group == null ? true : in_array($member->mb_group, explode(",", $menu_info->mm_group));
        
        if( ($is_group == true && $is_level == true) || $is_super ){
            return;
        }else{
            alert_back("접근권한이 없습니다.");
        }
    }

    //기본뷰
    function _view($page, $option=[]){

        // 로그인 체크
		$return_url = uri_string();
        $this->_require_login($return_url);
        
        //권한체크
        $this->_require_auth();

        if( $this->midx == null ){
            redirect("/dashboard/9");
        }
        
        $menu_info = $this->menu_m->get_item($this->midx);

        $this->menu_type =$this->menu_m->get_all_types();

        //메뉴설정
        $this->normal_menu = get_to_menu($this->menu_m->get_all_items(1), $this->midx); //menu
        $this->manage_menu = get_to_menu($this->menu_m->get_all_items(2), $this->midx); //manager
        $this->account_menu = get_to_menu($this->menu_m->get_all_items(3), $this->midx); //account
        $this->setting_menu = get_to_menu($this->menu_m->get_all_items(4), $this->midx); //account 
        
        
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