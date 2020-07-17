<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ra_Category extends SL_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("ref/ra_category_m");
	}

	public function index()
	{
		//$this->main();
	}

	//ajax로 요청하는경우
	public function grade_list(){
		//카테고리 idx값
		$this->rc_idx = $this->input->get("rc_idx") == null ? 1 :  $this->input->get("rc_idx");

		//챕터 목록
		$grade1_list = $this->ra_category_m->get_grade_1($this->rc_idx);

		$result = array(
			'title'=>"의료기기 품목",
			'grade1_list' => $grade1_list
		);
		$this->_modal_view("/ref/ra_grade_list_v",$result);
	}
}

/* End of file Ra_Category.php */
/* Location: ./application/ref/Ra_Category.php */
?>
