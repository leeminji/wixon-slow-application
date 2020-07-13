<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erps_task extends SL_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helpers(array("formtag"));
		$this->load->model("nmpa/nmpa_task_m");
	}

	public function index()
	{
		$this->main();
	}

	public function main(){
		$type_result = $this->nmpa_task_m->get_all_type_items();
		
		$default_array = array("의료기기"=>"의료기기", "체외진단제"=>"체외진단제");
		$grade_array = array("1"=>"1등급", "2"=>"2등급", "3"=>"3등급");
		$type_array = make_array($type_result, 'ty_idx', 'ty_name');

		$task_list = $this->nmpa_task_m->get_all_items();

		$data = array(
            "title" => "eRPS",
			"description" => "ERPS 등록",
			"type_select" => ft_dropdown_box('ta_default', $type_array, array()),
			"default_select" => ft_dropdown_box('ta_default', $default_array, array()), 
			"grade_check" => ft_checkbox('ta_grade[]', $grade_array),
			"task_list" => $task_list,
		);
		
		$this->_view("/nmpa/erps_task_v", $data);
	}
}

/* End of file Erps_task.php */
/* Location: ./application/nmpa/Erps_task.php */
?>
