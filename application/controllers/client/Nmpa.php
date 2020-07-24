<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa extends SL_Controller {
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
		$this->load->model("ref/vi_category_m");
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
		$this->list();
	}

	//문서등록
	public function list(){
		$start = get_list_start($this->set_per_page);
		$limit = $this->set_per_page;

		//총갯수
		$total_rows = $this->nmpa_report_m->get_items_by_clinet('count', $start, $limit, $this->user_info->mb_idx, $this->stx, $this->sfl); 
	
		//페이징 링크를 생성하여 view 에서 사용할 변수에 할당.
		$data['pagination'] = set_pagenation(array(
			"base_url"   => $this->list_href,
			"per_page"   => $this->set_per_page,
			"total_rows" => $total_rows
		));

		$report_list = $this->nmpa_report_m->get_items_by_clinet('', $start, $limit, $this->user_info->mb_idx, $this->stx, $this->sfl);

		$data['list'] = array();
		for( $i = 0; $i<count($report_list); $i++ ){
			$item = $report_list[$i];
			$data['list'][$i] = $item;
			
			$data['list'][$i]->num = get_list_num($total_rows, $this->set_per_page, $i); 
			
			//검색시 마크설정
			if( $this -> stx && $this -> sfl == 're_pr_name' ){
				$data['list'][$i]->re_pr_name = str_replace( $this -> stx, "<mark>".$this -> stx."</mark>", $item->re_pr_name );
			}
			$data['list'][$i]->link = "/client/nmpa/detail/{$this->midx}?re_idx={$item->re_idx}";

			//품목유형
			if($item->ta_default == 'TND01'){
				$ra = $this->ra_category_m->get_item($item->rc_idx);
				$data['list'][$i]->re_rank_1 = $ra->rc_name;
			}
			//체외진단제
			if($item->ta_default == 'TND02'){
				$vi = $this->vi_category_m->get_item($item->vc_idx);
				$data['list'][$i]->re_rank_1 = $vi->vc_name;
			}
		}

		$data['description'] = "{$this->user_info->mb_name}님의 NMPA 인허가 진행 상황을 볼 수 있습니다.";
		$data['midx'] = $this->midx;

		$this->_view("/client/nmpa_list_v", $data);
	}

	public function detail(){
		$re_idx = $this->input->get("re_idx");
		
		$view = $this->nmpa_report_m->get_item($re_idx);
		$data = array(
			"view" => $view
		);
		$this->_view("/client/nmpa_detail_v", $data);
	}
}

/* End of file Nmpa.php */
/* Location: ./application/client/Nmpa.php */
?>
