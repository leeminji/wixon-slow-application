<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erps_doc extends SL_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("nmpa/nmpa_task_m");
		$this->load->model("nmpa/nmpa_task_ch_m");
		$this->load->model("nmpa/nmpa_task_rps_m");

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

		//rps 목록
		$rps_list = array();
		$task_item = $this->nmpa_task_m->get_item($this->ta_idx);

		//챕터 목록
		$chapter_list = $this->nmpa_task_ch_m->get_items($task_item->ta_default);
		
		if( count($chapter_list) > 0 ){
			//목록 idx값
			$this->nc_idx = $this->input->get("nc_idx") == null ? array_sort($chapter_list, "nc_num")[0]->nc_idx :  $this->input->get("nc_idx");

			$rps_list = $this->nmpa_task_rps_m->get_items($this->ta_idx, $this->nc_idx);	
		}

		$task_array = make_array($task_list, 'ta_idx', 'ta_task');
		$data = array(
			"task_select" => ft_dropdown_box("ta_idx",$task_array, array($this->ta_idx),20),
			"doc_array" => $this->doc_array,
			"chapter_list" => $chapter_list,
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
		$task_item = $this->nmpa_task_m->get_item($this->ta_idx);
		
		//챕터 목록
		$chapter_list = $this->nmpa_task_ch_m->get_items($task_item->ta_default);
		if( count($chapter_list) > 0 ){
			$rps_list = $this->nmpa_task_rps_m->get_items($this->ta_idx, $this->nc_idx);	
		}
		$result = array(
			'rps_list' => $rps_list,
			'chapter_list' => $chapter_list
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
		$task_item = $this->nmpa_task_m->get_item($this->ta_idx);
		
		//챕터 목록
		$chapter_list = $this->nmpa_task_ch_m->get_items($task_item->ta_default);

		//var_dump($chapter_list);
		if( count($chapter_list) > 0 ){
			$rps_list = $this->nmpa_task_rps_m->get_items($this->ta_idx, $this->nc_idx);	
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
		$pidx_info = $this->nmpa_task_rps_m->get_item($pidx);

		$title =  $pidx_info->nc_title.".";

		$p_info = $pidx_info;
		for($i=0;$i<$p_info->nr_dep;$i++){
			$p_info = $this->nmpa_task_rps_m->get_item($p_info->nr_pidx);
			$title .= $p_info->nr_num.".";
		}

		$title .= $pidx_info->nr_num." ";
		$title .= $pidx_info->nr_title;

		$rps_list = $this->nmpa_task_rps_m->get_sub_items($pidx);
		
		$data = array(
			"title" => "{$title} 하위목록",
			"doc_array" => $this->doc_array,
			"rps_list" => $rps_list
		);
		
		$this->_modal_view("/nmpa/erps_rps_list_v", $data);
	}

	public function chapter(){
		if($_POST){
			if( $this->uri->segment(4) == 'write' ){
				$db_data = array(
					'nc_title' => $this->input->post('nc_title_new', TRUE),
					'nc_name' => $this->input->post('nc_name_new', TRUE),
					'ta_default' => $this->input->post('ta_default', TRUE),
				);
				$result = $this->nmpa_task_ch_m->insert_item($db_data);
				if( $result ){
					$this->_json_view(array("msg"=>"저장", "result"=>1));
				}else{
					$this->_json_view(array("msg"=>"저장 실패 하였습니다", "result"=>0));
				}
			}
			if( $this->uri->segment(4) == 'update' ){
				$nc_idx = $this->input->post('nc_idx', TRUE);
				$db_data = array(
					'nc_title' => $this->input->post('nc_title', TRUE),
					'nc_name' => $this->input->post('nc_name', TRUE)
				);
				$result = $this->nmpa_task_ch_m->update_item($db_data, $nc_idx);
				if( $result ){
					$this->_json_view(array("msg"=>"수정", "result"=>1));
				}else{
					$this->_json_view(array("msg"=>"수정 실패 하였습니다", "result"=>0));
				}
			}			
			if( $this->uri->segment(4) == 'delete' ){
				$nc_idx = $this->input->post('nc_idx', TRUE);
				$result = $this->nmpa_task_ch_m->delete_item($nc_idx);
				if( $result ){
					$this->_json_view(array("msg"=>"삭제", "result"=>1));
				}else{
					$this->_json_view(array("msg"=>"삭제 실패 하였습니다", "result"=>0));
				}
			}			
			if( $this->uri->segment(4) == 'order' ){
				$nc_idx = $this->input->post('nc_idx', TRUE);

				$result = false;
				for( $i=0;$i<count($nc_idx);$i++){
					$db_data = array(
						'nc_num' => $i
					);
					$result = $this->nmpa_task_ch_m->update_item($db_data, $nc_idx[$i]);
				}

				if( $result ){
					$this->_json_view(array("msg"=>"순서변경", "result"=>1));
				}else{
					$this->_json_view(array("msg"=>"순서변경 실패 하였습니다", "result"=>0));
				}
			}			
		}else{
			$default_list = $this->nmpa_task_m->get_default_items();

			$ta_default = $this->input->get("ta_default") == null ? $default_list[0]->de_mark : $this->input->get("ta_default");
	
			$default_array = make_array($default_list, 'de_mark', 'de_name');
			$chapter_list = $this->nmpa_task_ch_m->get_items($ta_default);
	
			$data = array(
				"task_select" => ft_dropdown_box("ta_default", $default_array, array($ta_default), 20),
				"chapter_list" => $chapter_list,
				"ta_default" => $ta_default
			);
	
			$this->_view("/nmpa/erps_doc_chapter_v", $data);
		}

	}
}

/* End of file Erps_doc.php */
/* Location: ./application/nmpa/Erps_doc.php */
?>
