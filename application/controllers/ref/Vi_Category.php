<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vi_Category extends SL_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("ref/vi_category_m");
	}

	public function index()
	{
		//$this->main();
	}

	//ajax로 요청하는경우
	public function detail_list(){
		//카테고리 idx값
		$this->vc_idx = $this->input->get("vc_idx") == null ? 1 :  $this->input->get("vc_idx");

		//하위목록
		$detail_list = $this->vi_category_m->get_detail_items($this->vc_idx);

		$result = array(
			'title'=>"체외진단제 품목",
			'detail_list' => $detail_list
		);
		$this->_modal_view("/ref/vi_detail_list_v",$result);
	}
}

/* End of file Vi_Category.php */
/* Location: ./application/ref/Vi_Category.php */
?>
