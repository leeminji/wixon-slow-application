<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends SL_Controller {

	public $set_per_page = 10;
	public $query = ""; //쿼리스트링
	public $stx = ""; //검색어
	public $sfl = ""; // 검색필드
	public $sst = ""; //정렬필드
	public $sod = ""; //정렬순
	public $per_page = ""; //페이지
	public $mb_level = ""; //레벨별
	public $total = ""; //전체 리스트
	
	public $list_href = ""; //목록
	public $write_href = ""; //글쓰기
	
	function __construct(){
		parent::__construct();
		
		$this->mb_level = $this->input->get('mb_level') == null ? "" : $this->input->get('mb_level');
		$this->sfl = $this -> input ->get("sfl", FALSE);
		$this->stx = $this -> input ->get("stx", FALSE);
		$this->sst = $this->input->get("sst", FALSE);
		$this->sod = $this->input->get("sod", FALSE);
		$this->per_page = $this -> input -> get("per_page", FALSE);
		
		$this->query = "";
		if($this->per_page){
			$this->query .= "&per_page=".$this->per_page;
		}
		if($this->stx){
			$this->query .= "&stx=".$this->stx;
		}
		if($this->sfl){
			$this->query .= "&sfl=".$this->sfl;
		}
		if($this->sst){
			$this->query .= "&sst=".$this->sst;
		}
		if($this->sod){
			$this->query .= "&sst=".$this->sod;
		}
		if($this->mb_level){
			$this->query .= "&mb_level=".$this->mb_level;
		}

		$this->load -> model('auth/member_m');
		$this->load -> model("auth/authset_m");
		
		$this->list_href = "/setting/member/lists/{$this->midx}";
		$this->write_href = "/setting/member/write/{$this->midx}";
	}
	
	/* 회원 아이디 중복 체크 */
	function check_member_id(){
		$mb_id = $this -> input -> get('mb_id');
		$result = $this -> member_m -> member_id_chk($mb_id);

		$json_data = array(
			"result" => $result->cnt > 0 ? "true" : "false"
		);

		$this->_json_view($json_data);
	}

	/* 주소에서 메서드가 생략되었을때 실행되는 기본 메서드 */
	public function index(){
		$this -> lists();
	}

	/* 회원 입력 및 수정 */
	public function write(){
	    $data['errors'] = array();
	    $data['view'] = null;
		$this -> load -> helper('form');
		
		//폼 검증 라이브러리 로드
		$this -> load -> library('form_validation');

		//멤버 idx
		$mb_idx = $this->input->post_get('mb_idx') ;
		$state = $mb_idx != null && $mb_idx != '' ? 'update' : 'write';

		if( $_POST ){
			//폼 검증할 필드와 규칙 사전 정의
			$this -> form_validation -> set_rules('mb_level', '회원권한', 'required');
			$this -> form_validation -> set_rules('mb_phone', '전화번호', 'numeric|matches[mb_phone]');
			$this -> form_validation -> set_rules('mb_group', '부서', 'required');
			
			if($state == 'write'){
				$this -> form_validation -> set_rules('mb_id', '아이디', 'required|alpha_numeric|matches[mb_id]');
				$this -> form_validation -> set_rules('mb_name', '이름', 'required');
				$this -> form_validation -> set_rules('mb_passwd', '비밀번호', 'required');
				$this -> form_validation -> set_rules('mb_id_chk', '아이디중복체크', 'required');
				$this -> form_validation -> set_rules('mb_re_passwd', '비밀번호 확인', 'required|matches[mb_passwd]');
				$this -> form_validation -> set_rules('mb_email', '메일', 'valid_email|is_unique[sl_member.mb_email]');
			}
			if($state == 'update'){
				$this -> form_validation -> set_rules('mb_email', '메일', 'valid_email');
			}

			if( $this -> form_validation -> run() == TRUE ){
				$db_data = array(
					'mb_name' => $this -> input -> post('mb_name', TRUE),
					'mb_id' => $this -> input -> post('mb_id', TRUE),
					'mb_email' => $this -> input -> post('mb_email', TRUE),
					'mb_level' => $this -> input -> post('mb_level', TRUE),
					'mb_phone' => $this -> input -> post('mb_phone', TRUE),
					'mb_group' => $this -> input -> post('mb_group', TRUE),
				);

				if( $this->input->post('mb_passwd') ){
					$hash = password_hash($this->input->post('mb_passwd'), PASSWORD_BCRYPT);
					$db_data['mb_passwd'] = $hash;
				}
				$result = false;
				if( $state == 'write'){
					$result = $this -> member_m -> member_insert($db_data);
					if( $result ){
						replace($this->list_href);
					}else{
						alert_back("실패하였습니다.");
					}
				}
				if($state == 'update'){
					$db_data['mb_idx'] = $this->input->post('mb_idx', TRUE);
					$result = $this -> member_m -> member_update($db_data);
					if( $result ){
						replace($this->write_href."?mb_idx={$mb_idx}");
					}else{
						alert_back("실패하였습니다.");
					}	
				}
			}else{
				$this->form_validation->set_error_delimiters();
				$data['errors'] = $this->form_validation->error_array();
			}
		}
		
		//수정
		if($state == 'update'){
			$data['view'] = $this->member_m->get_member($mb_idx);
			$data['title'] = "회원수정";
		}else{
			$data['title'] = "회원등록";
		}

		//회원권한 레벨리스트
		$level_list = $this->member_m->get_level_list();
		$group_list = $this->member_m->get_group_list();
		$data['q'] = $this->query;
		$data['level_list'] = make_array($level_list, "ml_idx", "ml_name");
		$data['group_list'] = make_array($group_list, "mg_idx", "mg_name");
		$this -> _view('setting/member/write_v', $data);
	}

	/* 회원 리스트 */
	public function lists(){

		//회원레벨리스트
		$option['level_list'] = $this->member_m->get_level_list(TRUE);
		
		//총회원 수
		$option['count_total_member'] = $this->member_m->member_list('count', '', '');
		
		//탈퇴회원수
		$option['count_out_member'] = $this->member_m->member_list('count', '', '','0','mb_state');

		$total_rows = $this -> member_m -> member_list('count', '', '', $this->stx, $this->sfl, $this->sst, $this->sod, $this->mb_level );
		$option['total'] = $total_rows;

		//쿼리스트링
		$pagenation_query = "?stx=".$this -> stx."&sfl=".$this -> sfl."&sst=".$this->sst."&sod=".$this->sod;

		//페이징
		$option['pagination'] = set_pagenation(
			array(
				"base_url"   => "/setting/member/{$this->midx}".$pagenation_query,
				"total_rows" => $total_rows,
				"per_page"   => $this->set_per_page //한페이지에 보여질 아이템(열)수
			)
		);

		$option['q'] = $this->query;
		$option['list'] = $this->member_m->member_list( '', get_list_start($this->set_per_page), $this->set_per_page, $this->stx, $this->sfl, $this->sst, $this->sod , $this->mb_level );

		for( $i = 0; $i < count($option['list']); $i++){
			//번호매기기 ( 총갯수 - (페이지번호-1 * 페이지당 데이터갯수)- 순차)
			$option['list'][$i]->num = get_list_num($total_rows, $this->set_per_page, $i);
			
			//검색시 마크설정
			if( $this -> stx && $this -> sfl == 'mb_id' ){
			$option['list'][$i]->mb_id = str_replace( $this -> stx, "<mark>".$this -> stx."</mark>", $option['list'][$i]->mb_id );
			}
			$option['list'][$i]->link = "/setting/member/write/{$this->midx}?mb_idx={$option['list'][$i]->mb_idx}{$this->query}";

			if( $this -> stx && $this -> sfl == 'mb_name' ){
			$option['list'][$i]->mb_name = str_replace( $this -> stx, "<mark>".$this -> stx."</mark>", $option['list'][$i]->mb_name );
			}
		}

		$option['title'] = "회원관리";
		
		$this -> _view("/setting/member/list_v",$option);
	}

	/* 회원 삭제 */
	public function delete(){
		if( $_POST ){
			$mb_idx = $this -> input -> post( 'mb_idx', TRUE );
			$mb_id = $this -> input -> post('mb_id', TRUE);
			
			//회원정보삭제
			$this -> member_m -> member_delete($mb_idx);
			
			//회원권한삭제
			$this -> authset_m -> auth_delete($mb_id);
			
			alert("삭제하였습니다.", $this->list_href."?".$this->query);
		}
	}

	/* 회원 탈퇴처리 */
	public function state(){
		if( $_POST ){
		    $mb_idx = $this -> input -> post('mb_idx', TRUE);
		    $mb_state = $this -> input -> post('mb_state', TRUE);
			$upate_data = array(
			    'mb_idx' => $mb_idx,
			    'mb_state' => $mb_state
			);
			$result = $this -> member_m -> member_state($upate_data);
			if( $result ){
			    if( $mb_state == 0 ){
			        alert_back("탈퇴처리되었습니다.");
			    }else{
			        alert_back("재가입 처리되었습니다.");
			    }
			}else{
			    alert_back("실패하였습니다.");
			}
		}
	}

	/* 회원 권한 출력 */
	function level(){
		if($_POST){
			$this -> load -> library('form_validation');
			if( $_POST ){
				$data = array(
					'ml_idx' => $this->input->post('ml_idx', TRUE),
					'ml_name' => $this->input->post('ml_name', TRUE)
				);

				for($i=0;$i<count($data['ml_idx']);$i++){
					$this->member_m->set_level(array(
						"ml_idx" => $data['ml_idx'][$i],
						"ml_name" => $data['ml_name'][$i],
					));
				}
				$json_data = array(
					"msg" => "수정 하였습니다.",
					"data" => $data,
				);
				$this->_json_view($json_data);
			}
		}else{
			$data = array(
				"title"      => "회원권한",
				"level_list" => $this -> member_m -> get_level_list()
			);
			$this->_modal_view("setting/member/level_v", $data);
		}
	}
}
?>