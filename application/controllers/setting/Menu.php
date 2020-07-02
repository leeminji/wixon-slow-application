<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends SL_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("setting/menu_m");
		$this->load->helper("tree");
	}

	public function index()
	{
		$this->main();
	}

	public function main(){
		$option = array(
			"title" => "MenuSetting"
		);
		$this->_view("/setting/menu/main_v", $option);
	}

	public function list(){
		$list = $this->menu_m->get_all_items();

		$menulist = get_to_tree($list);
		if( $menulist != "" ){
			$json = array(
				'status' => 1, 
				'msg' => "success", 
				'data' => $menulist,
				'list' => $list
			);
		}else{
			$json = array('status' => 0, 'msg' => "failed");
		}
		echo json_encode($json);
		exit;
	}

	public function sub_list(){
		$idx = $this->uri->segment(4);
		$list = $this->menu_m->get_sub_items($idx);

		$menulist = get_to_tree_sub_list($list);
		$json = array(
			'status' => 1, 
			'msg' => "success",
			'data' => $menulist
		);
		echo json_encode($json);
		exit;
	}

	public function move(){
		if($_POST){
			$this->menu_m->set_items_rank($this->input->post("idx[]"));
			$json = array(
				'status' => 1, 
				'msg' => "success"
			);
			echo json_encode($json);
			exit;			
		}else{
			$json = array(
				'status' => 0, 
				'msg' => "fail",
			);
			echo json_encode($json);
			exit;	
		}
	}

	public function create(){
		if($_POST){
			$data = array(
				"m_name" => $this->input->post("m_name"),
				"m_dep" => !$this->input->post("m_dep") ? 0 : $this->input->post("m_dep"),
				"m_link" => $this->input->post("m_link"),
				"m_pidx" => !$this->input->post("m_pidx") ? 0 : $this->input->post("m_pidx"),
			);
			if($this->menu_m->insert_item($data)){
				$json = array(
					'status' => 1, 
					'msg' => "success"
				);
				echo json_encode($json);
				exit;
			}else{
				$json = array(
					'status' => 0, 
					'msg' => "fail",
				);
				echo json_encode($json);
				exit;
			}
		}
	}

	public function update(){
		if($_POST){ 
			$idx = $this->uri->segment(4);
			$data = array(
				"m_name" => $this->input->post("m_name"),
				"m_link" => $this->input->post("m_link")
			);
			$this->menu_m->update_item($idx, $data);
			$json = array(
				'status' => 1, 
				'msg' => "success"
			);
			echo json_encode($json);
			exit;
		}
	}

	public function delete(){		
		$idx = $this->uri->segment(4);
		$delete_result = $this->menu_m->delete_item($idx);
		if( $delete_result['result'] ){
			$json = array(
				'status' => 1, 
				'msg' => "success"
			);
			echo json_encode($json);
			exit;	
		}else{
			$json = array(
				'status' => 0, 
				'msg' => $delete_result['msg']
			);
			echo json_encode($json);
			exit;
		}
	}
}
