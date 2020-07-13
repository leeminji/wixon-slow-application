<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa_report_m extends CI_Model{
    private $table = "sl_nmpa_report";
    private $task_table = "sl_nmpa_task";
    private $type_table = "sl_nmpa_type";
    private $ra_grade1_table = "sl_ra_grade_1";
    private $ra_cate_table = "sl_ra_category";
    private $detail_table = "sl_nmpa_report_detail";
    private $step_table = "sl_nmpa_report_step";
    
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function get_total_count(){
        $sql = "SELECT count(re_idx) FROM {$this->table}";
        $result = $this->db->query($sql)->num_rows();
        return $result;
    }

    function get_items($start, $limit, $stx=''){
        $sql = "
        SELECT report.*, task.*, ra_cate.rc_name, ra_grade1.rg_title
        FROM {$this->table} report 
        LEFT JOIN (
            SELECT type.ty_name, task.*
            FROM {$this->task_table} task LEFT JOIN {$this->type_table} 
            type ON task.ty_idx = type.ty_idx ) task 
        ON report.ta_idx = task.ta_idx
        LEFT JOIN {$this->ra_cate_table} ra_cate 
        ON ra_cate.rc_idx = report.rc_idx
        LEFT JOIN {$this->ra_grade1_table} ra_grade1
        ON ra_grade1.rg_idx = report.rg_idx        
        ORDER BY report.re_num ASC 
        LIMIT {$start}, {$limit}
        ";
        $result = $this->db->query($sql)->result();
        return $result;
    }
    
    //뷰
    function get_item($idx){
        $sql = "
        SELECT report.*, task.*, ra_cate.rc_name, ra_grade1.rg_title
        FROM {$this->table} report 
        LEFT JOIN (
            SELECT type.ty_name, task.*
            FROM {$this->task_table} task LEFT JOIN {$this->type_table} 
            type ON task.ty_idx = type.ty_idx ) task 
        ON report.ta_idx = task.ta_idx
        LEFT JOIN {$this->ra_cate_table} ra_cate 
        ON ra_cate.rc_idx = report.rc_idx
        LEFT JOIN {$this->ra_grade1_table} ra_grade1
        ON ra_grade1.rg_idx = report.rg_idx 
        WHERE report.re_idx = {$idx} 
        ";
        $result = $this->db->query($sql)->row();
        return $result;
    }

    function get_detail($re_idx){
        $sql = "
        SELECT detail.*, step.rs_name FROM {$this->detail_table} detail 
        LEFT JOIN {$this->table} report ON detail.re_idx = report.re_idx
        LEFT JOIN {$this->step_table} step ON detail.rs_idx = step.rs_idx
        WHERE detail.re_idx = {$re_idx} 
        ";
        $result = $this->db->query($sql)->result();
        return $result;       
    }

    function get_step_items(){
        $sql = "SELECT * FROM {$this->step_table}";
        $result = $this->db->query($sql)->result();
        return $result;  
    }
}

/* End of file Nmpa_report_m.php */
/* Location : ./application/models/nmpa/Nmpa_report_m.php */
?>