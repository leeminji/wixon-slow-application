<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa_task_ch_m extends CI_Model{
    private $table = "sl_nmpa_task_ch";

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_items($ta_default){
        $sql = "SELECT * FROM {$this->table} 
        WHERE ta_default='{$ta_default}' 
        ORDER BY nc_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_max_num($ta_default){
        $sql = "SELECT MAX(nc_num)+1 as max FROM {$this->table} WHERE ta_default='{$ta_default}'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    function insert_item($data){
        $data['nc_num'] = $this->get_max_num($data['ta_default'])->max;
        $data['nc_created_at'] = date("Y-m-d H:i:s", time());

		$result = $this->db->insert($this->table, $data);
		return $result; 
    }

    function delete_item($nc_idx){
		$result = $this->db->delete($this->table, array('nc_idx' => $nc_idx));
		return $result; 
    }

    function update_item($data, $nc_idx){
        $where = array("nc_idx"=>$nc_idx);
		$result = $this->db->update($this->table, $data, $where);
		return $result; 
    }
}

/* End of file Nmpa_task_ch_m.php */
/* Location : ./application/models/nmpa/Nmpa_task_ch_m.php */
?>