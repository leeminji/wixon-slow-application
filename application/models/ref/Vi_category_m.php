<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vi_category_m extends CI_Model{
    private $table = "sl_vi_category";
    private $table_detail = "sl_vi_detail";
    
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function get_total_count(){
        $sql = "SELECT count(*) FROM {$this->table}";
        $result = $this->db->query($sql)->num_rows();
        return $result;
    }

    function get_items(){
        $sql = "SELECT *, concat(vc_num,'-',vc_name) as vc_num_name FROM {$this->table} ORDER BY vc_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_item($vc_idx){
        $sql = "SELECT * FROM {$this->table} WHERE vc_idx={$vc_idx}";
        $result = $this->db->query($sql)->row();
        return $result;
    }

    function get_items_by_grade($vc_grade){
        $sql = "SELECT *, concat(vc_num,'-',vc_name) as vc_num_name FROM {$this->table}
                WHERE vc_grade = {$vc_grade}
                ORDER BY vc_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_detail_items($vc_idx){
        $sql = "SELECT * FROM {$this->table_detail} WHERE vc_idx={$vc_idx} ORDER BY vd_num DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_detail_item($vd_idx){
        $sql = "SELECT * FROM {$this->table_detail} WHERE vd_idx={$vd_idx}";
        $result = $this->db->query($sql)->row();
        return $result;
    }    
}

/* End of file Vi_category_m.php */
/* Location : ./application/models/ref/Vi_category_m.php */
?>