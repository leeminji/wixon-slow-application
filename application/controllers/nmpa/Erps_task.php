<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erps_task extends SL_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("nmpa/nmpa_task_m");

		$this->list_href = "/nmpa/erps_task/{$this->midx}";
	}

	public function index()
	{
		$this->main();
	}

	public function main(){
		$errors = array();

		//폼 검증 라이브러리 로드
		$this->load->library('form_validation');

		if( $_POST ){
			//폼 검증할 필드와 규칙 사전 정의
			$this -> form_validation -> set_rules('ta_default', '분류', 'required');
			$this -> form_validation -> set_rules('ta_type', '업무종류', 'required');
			$this -> form_validation -> set_rules('ta_task', '업무명', 'required');
			
			if( $this -> form_validation -> run() == TRUE ){
				$grade = $this -> input -> post('ta_grade', TRUE);
				if(count($grade) > 0) $grade = implode(",", $grade);
				$db_data = array(
					'ta_default' => $this -> input -> post('ta_default', TRUE),
					'ta_type' => $this -> input -> post('ta_type', TRUE),
					'ta_grade' => $grade,
					'ta_task' => $this -> input -> post('ta_task', TRUE)
				);
				$result = $this->nmpa_task_m->insert_item($db_data);
				if( $result ){
					replace($this->list_href);
				}else{
					alert_back("실패하였습니다.");
				}				
			}else{
				$this->form_validation->set_error_delimiters();
				$errors = $this->form_validation->error_array();
			}
		}

		$default_result = $this->nmpa_task_m->get_default_items();
		$type_result = $this->nmpa_task_m->get_all_type_items();
		
		$default_array = make_array($default_result, 'de_mark', 'de_name');
		$grade_array = array("1"=>"1등급", "2"=>"2등급", "3"=>"3등급");
		$type_array = make_array($type_result, 'de_mark', 'de_name');
		$task_list = $this->nmpa_task_m->get_all_items();

		$data = array(
            "title" => "업무등록",
			"description" => "업무등록",
			"type_select" => ft_dropdown_box('ta_type', $type_array, array()),
			"default_select" => ft_dropdown_box('ta_default', $default_array, array()), 
			"grade_check" => ft_checkbox('ta_grade[]', $grade_array),
			"task_list" => $task_list,
			"errors" => $errors,
		);
		
		$this->_view("/nmpa/erps_task_v", $data);
	}

	public function ajax_delete(){
		$ta_idx = $this->input->post("ta_idx");

		$result = $this->nmpa_task_m->delete_item($ta_idx);
		if( $result ){
			$json_data = array(
				"msg" => "success",
				"result"=> $result
			);
		}else{
			$json_data = array(
				"msg" => "fail"
			);		
		}
		$this->_json_view($json_data);
	}
}

/* End of file Erps_task.php */
/* Location: ./application/nmpa/Erps_task.php */
?>
