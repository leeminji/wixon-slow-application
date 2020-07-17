<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends SL_Controller {
	
	public $set_per_page = 10;
	public $query = ""; //쿼리스트링
	public $stx = ""; //검색어
	public $sfl = ""; // 검색필드
	public $sst = ""; //정렬필드
	public $sod = ""; //정렬순
	public $page_num = ""; //페이지
	public $mb_level = ""; //레벨별
	public $total = ""; //전체 리스트
	
	public $list_href = ""; //목록
	public $write_href = ""; //글쓰기

	function __construct(){
		parent::__construct();

		$this->load->model("nmpa/nmpa_report_m");
		$this->load->model("nmpa/nmpa_task_m");
		$this->load->model("ref/ra_category_m");
		$this->load->model("auth/member_m");

		$this-> sfl = $this->input->get("sfl", FALSE);
		$this-> stx = $this->input->get("stx", FALSE);
		$this-> sst = $this->input->get("sst", FALSE);
		$this-> sod = $this->input->get("sod", FALSE);
		$this-> page_num = $this -> input-> get("page_num", FALSE);

		$this-> query = "?page_num=".$this->page_num."&stx=".$this -> stx."&sfl=".$this -> sfl."&sst=".$this->sst."&sod=".$this->sod;

		$this-> list_href = "/nmpa/report/lists/{$this->midx}";
		$this-> write_href = "/nmpa/report/write/{$this->midx}";		
		$this-> new_href = "/nmpa/report/new/{$this->midx}";	
	}

	public function index()
	{
		$this->lists();
	}

	//진행상황 리스트
	public function lists(){

		$start = get_list_start($this->set_per_page);
		$limit = $this->set_per_page;

		//총갯수
		$total_rows = $this->nmpa_report_m->get_items('count', $start, $limit, $this->stx, $this->sfl); 
	
		//페이징 링크를 생성하여 view 에서 사용할 변수에 할당.
		$data['pagination'] = set_pagenation(array(
			"base_url"   => $this->list_href,
			"per_page"   => $this->set_per_page,
			"total_rows" => $total_rows
		));

		$report_list = $this->nmpa_report_m->get_items('', $start, $limit, $this->stx, $this->sfl);

		$data['list'] = array();
		for( $i = 0; $i<count($report_list); $i++ ){
			$item = $report_list[$i];
			$data['list'][$i] = $item;
			
			$data['list'][$i]->num = get_list_num($total_rows, $this->set_per_page, $i); 
			
			//검색시 마크설정
			if( $this -> stx && $this -> sfl == 're_pr_name' ){
				$data['list'][$i]->re_pr_name = str_replace( $this -> stx, "<mark>".$this -> stx."</mark>", $item->re_pr_name );
			}
			$data['list'][$i]->link = "/nmpa/report/write/{$this->midx}?re_idx={$item->re_idx}";
		}

		$data['description'] = "진행상황";
		$data['midx'] = $this->midx;

		$this->_view("/nmpa/report_list_v", $data);
	}

	
	//수정 & 작성
	public function write(){
		$errors = array();
		//리포트 idx
		$re_idx = $this->input->get_post('re_idx');
		$this->state = $re_idx != null ? "update" : "write";

		$this->load->library('form_validation');
		
		if($_POST){
			//폼 검증할 필드와 규칙 사전 정의
			if( $this->state == 'write'){
				$this->form_validation -> set_rules('re_id', '관리번호_앞자리', 'required');
				$this->form_validation -> set_rules('re_id_add', '관리번호_뒷자리', 'required');
			}
			$this->form_validation -> set_rules('mb_idx', '업체선택', 'required|numeric');
			$this->form_validation -> set_rules('re_mf', '제조사', 'required');
			$this->form_validation -> set_rules('re_pr_name', '제품명', 'required');
			$this->form_validation -> set_rules('ta_idx', '위탁업무', 'required|numeric');
			$this->form_validation -> set_rules('rc_idx', '품목분류', 'required|numeric');
			$this->form_validation -> set_rules('rg_idx', '품목명', 'required|numeric');
			$this->form_validation -> set_rules('re_grade', '등급', 'required|numeric');
			$this->form_validation -> set_rules('re_contracted_at', '위탁일', 'required');
			$this->form_validation -> set_rules('re_ended_at', '종료일', 'required');
			if( $this->form_validation -> run() == TRUE ){
				$db_data = array(
					're_mf' => $this -> input -> post('re_mf', TRUE),
					're_pr_name' => $this -> input -> post('re_pr_name', TRUE),
					'ta_idx' => $this -> input -> post('ta_idx', TRUE),
					'rc_idx' => $this -> input -> post('rc_idx', TRUE),
					'rg_idx' => $this -> input -> post('rg_idx', TRUE),
					're_grade' => $this -> input -> post('re_grade', TRUE),
					're_contracted_at' => $this -> input -> post('re_contracted_at', TRUE),
					're_ended_at' => $this -> input -> post('re_ended_at', TRUE),
				);
				$result = false;
				if( $this->state == 'write'){
					$db_data['mb_idx'] = $this -> input -> post('mb_idx', TRUE);
					$db_data['re_id'] = $this -> input -> post('re_id', TRUE)."-".$this -> input -> post('re_id_add', TRUE);
					
					$result = $this->nmpa_report_m->insert_item($db_data);
					if( $result ){
						replace($this->list_href);
					}else{
						alert_back("실패하였습니다.");
					}
				}
				if( $this->state == 'update'){
					$re_idx = $this -> input -> post('re_idx', TRUE);		
					$result = $this->nmpa_report_m->update_item($db_data, $re_idx);
					if( $result ){
						replace($this->write_href."?re_idx={$re_idx}");
					}else{
						alert_back("실패하였습니다.");
					}
				}
			}else{
				$this->form_validation->set_error_delimiters();
				$errors = $this->form_validation->error_array();			
			}
		}

		$task_list = $this->nmpa_task_m->get_all_items();
		$member_list = $this->member_m->get_member_by('M03', 'G03');
		
		$member_array = make_array($member_list, "mb_idx", "mb_name");
		
		$grade_array = array("1"=>"1등급", "2"=>"2등급", "3"=>"3등급");
		$task_array = make_array($task_list, 'ta_idx', 'ta_task');
		$ra_list = $this->ra_category_m->get_items();
		$ra_array = make_array($ra_list, 'rc_idx', 'rc_num_name');

		$data = array(
			"errors" => $errors,
			"view" => null,
			"description" => "진행상황",
			"grade_array" => $grade_array,
			"task_array"  => $task_array,
			"ra_array"    => $ra_array,
			"member_array" => $member_array
		);
		if($this->state == 'update'){
			$data['view'] = $this->nmpa_report_m->get_item($re_idx);
		}
		$this->_view("/nmpa/report_write_v", $data);
	}

	//보고서
	public function detail(){
		$re_idx = $this->input->get('re_idx');
		$report_view = $this->nmpa_report_m->get_item($re_idx);

		$report_detail_list = $this->nmpa_report_m->get_detail($re_idx);
		$step_list = $this->nmpa_report_m->get_step_items();
		$step_array = make_array($step_list, "rs_idx", "rs_name");
		$data = array(
			"view"=>$report_view,
			"step_array" => $step_array,
			"title"=>$report_view->re_pr_name." 진행상황 보고서 등록",
			"description" => "진행상황 보고서",
			"report_detail_list" => $report_detail_list
		);
		$this->_view("/nmpa/report_detail_write_v", $data);
	}

	//진행상황
	public function status(){
		if($_POST){ 
			$re_idx = $this->input->post('re_idx');
			$data = array(
				"nr_idx_array" => $this->input->post('nr_idx_array')
			);
			$this->nmpa_report_m->update_status_item($data, $re_idx);
			
			alert("저장하였습니다.", current_url()."?re_idx={$re_idx}");
			exit;
		}

		$this->re_idx = $this->input->get('re_idx');
		$report_view = $this->nmpa_report_m->get_item($this->re_idx);
		$status_view = $this->nmpa_report_m->get_status_item($this->re_idx);

		$report_detail_list = $this->nmpa_report_m->get_detail($this->re_idx);
		$step_list = $this->nmpa_report_m->get_step_items();
		$step_array = make_array($step_list, "rs_idx", "rs_name");
		$data = array(
			"report_view"=>$report_view,
			"status_view"=>$status_view,
			"step_array" => $step_array,
			"title"=>$report_view->re_pr_name." 진행상황",
			"description" => "진행상황",
			"report_detail_list" => $report_detail_list
		);
		$this->_view("/nmpa/report_status_write_v", $data);
		
	}

	/* 관리번호만들기 */
	function create_doc_id(){
		$date = Date('ymd');

		$json_data = array(
			"doc_id" => substr($date,0,2)."SS".substr($date, 2, strlen($date))
		);

		$this->_json_view($json_data);
	}

}

/* End of file Report.php */
/* Location: ./application/nmpa/Report.php */
?>
