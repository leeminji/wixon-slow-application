<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends SL_Controller {

	function __construct(){
		parent::__construct();
		$this -> load -> model('setting/config_m');
		$this -> load -> model('auth/auth_m');
		$this -> load -> model('auth/login_log_m');
		$this -> load -> model('auth/member_m');

		$this -> load -> helper(array('form', 'url','alert','token'));
	}
	
	/* 로그인 처리 */
	public function login(){
		if( $this -> session -> userdata('logged_in') == TRUE ) {
			alert_back('로그인한 상태입니다.');
			exit;
		}
		$this -> load -> library('form_validation');
		$this -> load -> library('user_agent');
		
		$this -> form_validation -> set_rules('mb_id', '아이디', 'required|alpha_numeric');
		$this -> form_validation -> set_rules('mb_passwd', '비밀번호', 'required|min_length[4]|max_length[20]');
		$msg = "";
		
		if ($this -> form_validation -> run() == TRUE) {
		    //token값 체크
		    check_token();

			$auth_data = array(
				'mb_id' => $this -> input -> post('mb_id', TRUE),
				'mb_passwd' => $this -> input -> post('mb_passwd', TRUE),
				'return_url' => trim($this -> input -> post('return_url', TRUE)),
			);
			
			$result = $this->auth_m->login($auth_data);
			
			$logdata = array(
			    "mll_ip" => $this->input->ip_address(),
			    "mll_useragent" => $this->agent->agent_string(),
			    "mb_id" => $result != null ? $result->mb_id : $auth_data['mb_id'],
				"mb_idx" => $result != null ? $result->mb_idx : "",
				"mll_url" => ""
			);

			if ( $result != null && ($auth_data['mb_id'] == $result->mb_id && password_verify( $auth_data['mb_passwd'], $result -> mb_passwd )) ) {
				if($result -> mb_state != 1){
				    $msg = "탈퇴되거나 정지된 계정입니다. 계정 복원시 관리자에게 문의해주세요";
				    
				    $logdata['mll_success'] = 0;
				    $logdata["mll_msg"] = $msg;
				    $this -> login_log_m -> login_log_insert($logdata);
				    
				    alert($msg, '/auth/login');
				}else{

					//세션설정
					$ss_userInfo = array(
						"userinfo" => $this->member_m->get_member($result->mb_idx),
						"logged_in" => TRUE
					);
				    
				    //세션 저장
					$this -> session -> set_userdata($ss_userInfo);
					
    				//로그인 시간 저장
    				$this->auth_m -> setLatestDateById($result->mb_id);
    				$msg = "로그인 되었습니다";
    				
    				//로그저장
    				$logdata["mll_msg"] = $msg;
    				$logdata['mll_success'] = 1;
    				$this -> login_log_m -> login_log_insert($logdata);
					
					if( $auth_data['return_url'] && (trim($auth_data['return_url']) != "")){
						alert($msg."(is_return).{$auth_data['return_url']}", $auth_data['return_url']);
					}else{
						alert($msg, "/dashboard/9");
					}
				}
			} else {
			    $msg = "아이디나 비밀번호를 확인해 주세요.";
				
				//로그저장
			    $logdata["mll_msg"] = $msg;
				$logdata['mll_success'] = 0;
				
			    $this -> login_log_m -> login_log_insert($logdata);
			    alert($msg, '/auth/login');
				exit;
			}
		} else {
			$this->form_validation->set_error_delimiters();
			$option = array(
				"title"=>"로그인",
				"token" => get_token(),
				"return_url" => trim($this->input->get('return_url')),
				"error" => $this->form_validation->error_array()
			);

			$this->_login_view("/auth/login_v",$option);
		}
	}


	/* 로그아웃 */
	public function logout() {
		$this -> session -> sess_destroy();
		//var_dump($this->session);
		alert('로그아웃 되었습니다.', '/auth/login');
		exit;
	}
	
}
?>