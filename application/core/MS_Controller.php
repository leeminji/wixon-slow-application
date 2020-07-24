<?php

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class MS_Controller extends CI_Controller {
    private $auth_config;

    function __construct(){
        parent::__construct();
        $this->load->helper(array("alert", "common", "form", "url"));
 
        //IP체크
        $this->_require_ip();
        $this->load->model('tokenCache_m');
        $this->auth_config = array(
            'clientId'                => OAUTH_APP_ID,
            'clientSecret'            => OAUTH_APP_PASSWORD,
            'redirectUri'             => OAUTH_REDIRECT_URI,
            'urlAuthorize'            => OAUTH_AUTHORITY.OAUTH_AUTHORIZE_ENDPOINT,
            'urlAccessToken'          => OAUTH_AUTHORITY.OAUTH_TOKEN_ENDPOINT,
            'urlResourceOwnerDetails' => '',
            'scopes'                  => OAUTH_SCOPES           
        );

        $this->load->library("loaddata");

        //로그인 멤버정보
        if($this->session->userdata('logged_in')){ 
            $this->user_info = $this->session->userdata('userinfo');

            $expectedState = $this->session->userdata('tokenCache');
  
            if (!isset($expectedState['accessToken'])) {
                //MS로그인
                $this->_require_ms_login();
            }
        }else{
            $this->_require_login();
        }
    }

    //ms로그인
    function _require_ms_login(){
        $oauthClient = new GenericProvider($this->auth_config);
        $authUrl = $oauthClient->getAuthorizationUrl();
        
        $this->session->set_userdata("oauthState", $oauthClient->getState());
        redirect($authUrl);
    }

    function _require_ip(){
        $client_ip = get_client_ip();
        if( !in_array($client_ip, $this->config->item('access_ips')) ){
            alert_back('접근 불가능한 IP 주소입니다.'.$client_ip);
        }
    }

    //로그인차단
    function _require_login($return_url=null)
	{
        // 로그인이 되어 있지 않다면 로그인 페이지로 리다이렉션
        if($this->session->userdata('logged_in') == null){       
			$msg = "로그인 먼저 해 주세요";
            $url = '/auth/login';
            if($return_url){
                $url .= "?return_url=".rawurlencode($return_url);
            }
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

    //json 뷰
    function _json_view($result){
        // 로그인 체크
		$return_url = uri_string();
        $this->_require_login($return_url);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));       
    }

}

/* End of file MS_Controller.php */
/* Location: ./system/core/MS_Controller.php */
?>