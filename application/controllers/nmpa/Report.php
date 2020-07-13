<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends SL_Controller {
	
	public $col_per_page = 10;
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
		$this->load->helpers(array("formtag"));

		$this->load->model("nmpa/nmpa_report_m");
		$this->load->model("nmpa/nmpa_task_m");
		$this->load->model("ref/ra_category_m");

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
		//페이지네이션 라이브러리 로딩 추가
		$this -> load -> library('pagination');

		//페이지네이션 설정
		$config['base_url'] = $this->list_href."?stx=".$this -> stx."&sfl=".$this -> sfl."&sst=".$this->sst."&sod=".$this->sod;

		//페이지당 보여줄 갯수
		$config['per_page'] = $this->col_per_page ;
		$config['page_query_string'] = TRUE;
		
		//페이지네이션 초기화
		$this -> pagination -> initialize($config);

		//페이징 링크를 생성하여 view 에서 사용할 변수에 할당.
		$data['pagination'] = $this -> pagination -> create_links();

		//게시물 목록을 불러오기 위한 offset, limit 값 가져오기
		$page_num = $this -> input ->get("page_num", TRUE) == "" ? 1 : $this -> input ->get("page_num", TRUE);

		$start = ($page_num-1) * $this->col_per_page;
		$limit = $this->col_per_page;

		$report_list = $this->nmpa_report_m->get_items($start, $limit, $this->stx, $this->sfl, $this ->sst, $this->sod);
		$total_count = $this->nmpa_report_m->get_total_count(); //총갯수

		$data['list'] = array();
		for( $i = 0; $i<count($report_list); $i++ ){
			$item = $report_list[$i];
			$data['list'][$i] = $item;
			
			//번호매기기 ( 총갯수 - (페이지번호-1 * 페이지당 데이터갯수)- 순차)
			$data['list'][$i]->num = $total_count-(($page_num-1)*$this->col_per_page)-$i;
			
			//검색시 마크설정
			if( $this -> stx && $this -> sfl == 're_pr_name' ){
				$data['list'][$i]->re_pr_name = str_replace( $this -> stx, "<mark>".$this -> stx."</mark>", $item->re_pr_name );
			}
			$data['list'][$i]->link = "/nmpa/report/update/{$item->re_idx}/{$this->midx}";
		}

		$data['description'] = "진행상황";
		$data['midx'] = $this->midx;

		$this->_view("/nmpa/report_list_v", $data);
	}

	//보기
	public function update(){
		$re_idx = $this->uri->segment(4);

		$view = $this->nmpa_report_m->get_item($re_idx);
		$task_list = $this->nmpa_task_m->get_all_items();
		
		$ra_list = $this->ra_category_m->get_items();
		$ra_array = make_array($ra_list, 'rc_idx', 'rc_name');
		$task_array = make_array($task_list, 'ta_idx', 'ta_task');
		$grade_array = array("1"=>"1등급", "2"=>"2등급", "3"=>"3등급");

		$data = array(
			"description" => "진행상황",
			"view"        => $view,
			"grade_array" => $grade_array,
			"task_array"  => $task_array,
			"ra_array"    => $ra_array
		);
		$this->_view("/nmpa/report_write_v", $data);
	}

	//작성
	public function write(){
		$task_list = $this->nmpa_task_m->get_all_items();

		$grade_array = array("1"=>"1등급", "2"=>"2등급", "3"=>"3등급");
		$task_array = make_array($task_list, 'ta_idx', 'ta_task');
		$ra_list = $this->ra_category_m->get_items();
		$ra_array = make_array($ra_list, 'rc_idx', 'rc_name');

		$data = array(
			"view"=>null,
			"description" => "진행상황",
			"grade_array" => $grade_array,
			"task_array"  => $task_array,
			"ra_array"    => $ra_array
		);
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
		$re_idx = $this->input->get('re_idx');
		$report_view = $this->nmpa_report_m->get_item($re_idx);

		$report_detail_list = $this->nmpa_report_m->get_detail($re_idx);
		$step_list = $this->nmpa_report_m->get_step_items();
		$step_array = make_array($step_list, "rs_idx", "rs_name");
		$data = array(
			"view"=>$report_view,
			"step_array" => $step_array,
			"title"=>$report_view->re_pr_name." 진행상황",
			"description" => "진행상황",
			"report_detail_list" => $report_detail_list
		);
		$this->_view("/nmpa/report_status_write_v", $data);
	}
}

/* End of file Report.php */
/* Location: ./application/nmpa/Report.php */
?>
