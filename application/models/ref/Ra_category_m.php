<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ra_category_m extends CI_Model{
    private $table = "sl_ra_category";
    private $table_grade1 = "sl_ra_grade_1";
    private $table_grade2 = "sl_ra_grade_2";
    
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
        $sql = "SELECT *,concat(rc_num,'-',rc_name) as rc_num_name FROM {$this->table} ORDER BY rc_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_item($rc_idx){
        $sql = "SELECT * FROM {$this->table} WHERE rc_idx={$rc_idx}";
        $result = $this->db->query($sql)->row();
        return $result;
    }


    function get_grade_1($rc_idx){
        $sql = "SELECT * FROM {$this->table_grade1} WHERE rc_idx={$rc_idx} ORDER BY rg_num DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_grade_item($rg_idx){
        $sql = "SELECT * FROM {$this->table_grade1} WHERE rg_idx={$rg_idx}";
        $result = $this->db->query($sql)->row();
        return $result;
    } 
}

/* End of file Ra_category_m.php */
/* Location : ./application/models/ref/Ra_category_m.php */
?>