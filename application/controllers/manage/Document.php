<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends SL_Controller {
	public function index()
	{
		$this->main();
	}

	public function main(){
        $mid = $this->input->get("mode") == "" ? 48 : $this->input->get("mode");
		$option = array(
			"list" => ['1111','2222'],
            "title" => "Welcome",
            "mid"=> $mid
		);
		$this->_view("/manage/document/main_v", $option);
	}

}

/* End of Document.php */
/* Location: ./application/controllers/manage/Document.php */
?>