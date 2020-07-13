<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erps_doc extends SL_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helpers(array("formtag"));
		$this->load->model("nmpa/nmpa_task_m");
		$this->load->model("nmpa/nmpa_task_ch_m");
		$this->load->model("nmpa/Nmpa_task_rps_m");

		$this->doc_array = array("R"=>"R", "NR"=>"NR", "CR"=>"CR");
	}

	public function index()
	{
		$this->main();
	}

	//문서등록
	public function main(){
		$task_list = $this->nmpa_task_m->get_all_items();
		
		//업부 idx값
		$this->ta_idx = $this->input->get("ta_idx") == null ? 1 :  $this->input->get("ta_idx");

		//목록 idx값
		$this->nc_idx = $this->input->get("nc_idx") == null ? 1 :  $this->input->get("nc_idx");

		//rps 목록
		$rps_list = array();

		//챕터 목록
		$chacter_list = $this->nmpa_task_ch_m->get_items($this->ta_idx);
		if( count($chacter_list) > 0 ){
			$rps_list = $this->Nmpa_task_rps_m->get_items($this->ta_idx, $this->nc_idx);	
		}

		$task_array = make_array($task_list, 'ta_idx', 'ta_task');
		$data = array(
			"task_select" => ft_dropdown_box("ta_idx",$task_array, array($this->ta_idx),20),
			"doc_array" => $this->doc_array,
			"chacter_list" => $chacter_list,
			"rps_list" => $rps_list
		);

		$this->_view("/nmpa/erps_doc_v", $data);
	}

	//ajax로 요청하는경우
	public function json_rps(){
		//업부 idx값
		$this->ta_idx = $this->input->get("ta_idx") == null ? 1 :  $this->input->get("ta_idx");

		//목록 idx값
		$this->nc_idx = $this->input->get("nc_idx") == null ? 1 :  $this->input->get("nc_idx");
		
		//rps 목록
		$rps_list = array();

		//챕터 목록
		$chacter_list = $this->nmpa_task_ch_m->get_items($this->ta_idx);
		if( count($chacter_list) > 0 ){
			$rps_list = $this->Nmpa_task_rps_m->get_items($this->ta_idx, $this->nc_idx);	
		}

		$result = array(
			'rps_list' => $rps_list,
			'chapter_list' => $chacter_list
		);

		$this->_json_view($result);
	}

	public function rps_total_list(){
		//업부 idx값
		$this->ta_idx = $this->input->get("ta_idx") == null ? 1 :  $this->input->get("ta_idx");

		//목록 idx값
		$this->nc_idx = $this->input->get("nc_idx") == null ? 1 :  $this->input->get("nc_idx");
		
		//rps 목록
		$rps_list = array();

		//챕터 목록
		$chapter_list = $this->nmpa_task_ch_m->get_items($this->ta_idx);
		if( count($chapter_list) > 0 ){
			$rps_list = $this->Nmpa_task_rps_m->get_items($this->ta_idx, $this->nc_idx);	
		}

		$result = array(
			'title'=>"eRPS 목록",
			'rps_list' => $rps_list,
			'chapter_list' => $chapter_list
		);

		$this->_layer_view("/nmpa/erps_rps_total_list_v", $result);
	}

	public function rps_list(){
		$pidx = $this->uri->segment(4);
		$rps_list = $this->Nmpa_task_rps_m->get_sub_items($pidx);
		
		$data = array(
			"title" => "하위목록",
			"doc_array" => $this->doc_array,
			"rps_list" => $rps_list
		);
		
		$this->_layer_view("/nmpa/erps_rps_list_v", $data);
	}

	public function chapter(){
		$task_list = $this->nmpa_task_m->get_all_items();
		$ta_idx = $this->input->get("ta_idx") == null ? 1 :  $this->input->get("ta_idx");

		$task_array = make_array($task_list, 'ta_idx', 'ta_task');
		$chacter_list = $this->nmpa_task_ch_m->get_items($ta_idx);

		$data = array(
			"task_select" => ft_dropdown_box("ta_idx",$task_array, array($ta_idx),20),
			"chacter_list" => $chacter_list
		);

		$this->_view("/nmpa/erps_doc_chapter_v", $data);
	}
}

/* End of file Erps_doc.php */
/* Location: ./application/nmpa/Erps_doc.php */
?>
