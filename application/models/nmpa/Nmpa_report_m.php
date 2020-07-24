<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa_report_m extends CI_Model{
    private $table = "sl_nmpa_report";
    private $task_table = "sl_nmpa_task";
    private $type_table = "sl_nmpa_type";
    private $ra_grade1_table = "sl_ra_grade_1";
    private $ra_cate_table = "sl_ra_category";
    private $vi_detail_table = "vi_detail_table";
    private $vi_cate_table = "vi_cate_table";
    private $detail_table = "sl_nmpa_report_detail";
    private $step_table = "sl_nmpa_report_step";
    private $status_table = "sl_nmpa_report_status";
    private $define_table = "sl_define";
    private $member_table = "sl_member";
    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->model("ref/ra_category_m");
		$this->load->model("ref/vi_category_m");       
    }

    function insert_status_item($re_idx){
        $data['st_created_at'] = date("Y-m-d H:i:s", time());
        $data['re_idx'] = $re_idx;
        $data['st_idx'] = $re_idx;
		$result = $this->db->insert($this->status_table, $data);
        
        return $result;
    }

    function get_next_num(){
        $sql = "SELECT MAX(re_num)+1 as max FROM {$this->table}";
        $result = $this->db->query($sql)->row();
        
        return $result;
    }

    //리포트생성
    function insert_item($data){
        $data['re_num'] = $this->get_next_num()->max;
        $data['re_created_at'] = date("Y-m-d H:i:s", time());
		$result = $this->db->insert($this->table, $data);
        
        //id값
        $re_idx = $this->db->insert_id();

        //진행상황 추가
        $result = $this->insert_status_item($re_idx);

        return $re_idx;
    }

    function update_item($data, $re_idx){
        $where = array(
            "re_idx" => $re_idx
        );
		$result = $this->db->update($this->table, $data, $where);
        
        return $result;
    }

    function delete_item($re_idx){
        $where = array(
            "re_idx" => $re_idx
        );
		$result = $this->db->delete($this->table, $where);
        return $result;
    }

    function get_total_count(){
        $sql = "SELECT re_idx FROM {$this->table}";
        $result = $this->db->query($sql)->num_rows();
        return $result;
    }

    function get_items($type='', $start, $limit, $stx='', $sfl='',$sst='',$sod=''){
		$search_query = "";
		if( $stx != "" && $sfl != "" ){
			$search_query = " WHERE report.{$sfl} LIKE '%{$stx}%' ";
		}

		$order_query = " ORDER BY report.re_num ASC ";
		if( $sst != ""){
			$order_query = " ORDER BY report.{$sst} {$sod} ";
		}

		$limit_query = '';
		if( $limit != '' OR $start != ''){
			$limit_query = " LIMIT {$start}, {$limit}";
        }
                
        $sql = "
            SELECT report.*, task.*, member.*  
            FROM {$this->table} report 
            LEFT JOIN (
                SELECT type.de_name as ty_name, task.*, def.de_name 
                FROM {$this->task_table} task 
                LEFT JOIN {$this->define_table} type ON task.ta_type = type.de_mark 
                LEFT JOIN {$this->define_table} def ON task.ta_default = def.de_mark
             ) task 
            ON report.ta_idx = task.ta_idx  
            LEFT JOIN {$this->member_table} member ON member.mb_idx = report.mb_idx   
            {$search_query}{$order_query}{$limit_query}
        ";

		$query = $this -> db -> query($sql);
		$result = null;
		if( $type == 'count' ){
			//전체 게시물 갯수반환
			$result = $query -> num_rows();
		}else{
			//게시물 리스트 변환
			$result = $query -> result();
		}
		return $result;
    }
    


    function get_items_by_clinet($type='', $start, $limit, $mb_idx, $stx='', $sfl='',$sst='',$sod=''){
        $where_query = "";
        if($mb_idx != ""){
            $where_query = "AND report.mb_idx={$mb_idx} "; 
        }
        
        $search_query = "";
		if( $stx != "" && $sfl != "" ){
			$search_query = " AND report.{$sfl} LIKE '%{$stx}%' ";
		}

		$order_query = " ORDER BY report.re_num ASC ";
		if( $sst != ""){
			$order_query = " ORDER BY report.{$sst} {$sod} ";
		}

		$limit_query = '';
		if( $limit != '' OR $start != ''){
			$limit_query = " LIMIT {$start}, {$limit}";
        }
        $sql = "
            SELECT report.*, task.*, member.*  
            FROM {$this->table} report 
            LEFT JOIN (
                SELECT type.de_name as ty_name, task.*, def.de_name 
                FROM {$this->task_table} task 
                LEFT JOIN {$this->define_table} type ON task.ta_type = type.de_mark 
                LEFT JOIN {$this->define_table} def ON task.ta_default = def.de_mark
             ) task 
            ON report.ta_idx = task.ta_idx  
            LEFT JOIN {$this->member_table} member ON member.mb_idx = report.mb_idx   
            WHERE 1 {$where_query} {$search_query} {$order_query} {$limit_query}
        ";

		$query = $this -> db -> query($sql);
		$result = null;
		if( $type == 'count' ){
			//전체 게시물 갯수반환
			$result = $query -> num_rows();
		}else{
			//게시물 리스트 변환
			$result = $query -> result();
		}
		return $result;
    }
    
    
    //뷰
    function get_item($idx){
        $sql = "
        SELECT report.*, task.* , member.*
        FROM {$this->table} report 
        LEFT JOIN (
            SELECT type.de_name as ty_name, task.*, def.de_name 
            FROM {$this->task_table} task 
            LEFT JOIN {$this->define_table} type ON task.ta_type = type.de_mark 
            LEFT JOIN {$this->define_table} def ON task.ta_default = def.de_mark
         ) task 
        ON report.ta_idx = task.ta_idx 
        LEFT JOIN {$this->member_table} member ON member.mb_idx = report.mb_idx 
        WHERE report.re_idx = {$idx} 
        ";

        $result = $this->db->query($sql)->row();

        //품목유형
        if( $result->ta_default == 'TND01' ){
            $ra = $this->ra_category_m->get_item($result->rc_idx);
            $result->re_rank_1 = $ra->rc_name;
            $ra_g= $this->ra_category_m->get_grade_item($result->rg_idx);
            $result->re_rank_2 = $ra_g->rg_title;
        }

        //체외진단제
        if( $result->ta_default == 'TND02'){
            $vi_cate = $this->vi_category_m->get_item($result->vc_idx);
            $result->re_rank_1 = $vi_cate->vc_name;
            $vi_detail= $this->vi_category_m->get_detail_item($result->vd_idx);
            $result->re_rank_2 = $vi_detail->vd_name;
        }

        return $result;
    }

    //진행상황보고서
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

    //진행절차 리스트
    function get_step_items(){
        $sql = "SELECT * FROM {$this->step_table}";
        $result = $this->db->query($sql)->result();
        return $result;  
    }

    //진행상황 업데이트
    function update_status_item($data, $idx){
        $this->db->update($this->status_table, $data, array('re_idx'=>$idx)); 
    }

    //진행상황 
    function get_status_item($idx){
        $sql = "SELECT * FROM {$this->status_table} WHERE re_idx={$idx}";
        $result = $this->db->query($sql)->row();
        return $result;
    }
}

/* End of file Nmpa_report_m.php */
/* Location : ./application/models/nmpa/Nmpa_report_m.php */
?>