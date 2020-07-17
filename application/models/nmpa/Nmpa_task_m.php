<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa_task_m extends CI_Model{
    private $table = "sl_nmpa_task";
    private $table_define = "sl_define";
    private $table_ch = "sl_nmpa_task_ch";
    private $table_rps = "sl_nmpa_task_rps";

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function insert_item($data){
        $data['ta_created_at'] = date("Y-m-d H:i:s", time());      
        $result = $this->db->insert($this->table, $data);
        return $result;
    }

    function get_items($count)
    {
        $query = $this->db->get($this->table, $count);
        return $query->result();
    }

    function get_all_type_items(){
        $sql = "SELECT * FROM {$this->table_define} WHERE de_group='TRADE_NMPA_TYPE' ORDER BY de_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_default_items(){
        $sql = "SELECT * FROM {$this->table_define} WHERE de_group='TRADE_NMPA_DEFAULT' ORDER BY de_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_all_items(){
        $sql = "SELECT 
            task.ta_idx, 
            def.de_name as ta_default,
            ty.de_name as ta_type, 
            task.ta_grade, 
            task.ta_task 
        FROM {$this->table} as task 
        LEFT JOIN {$this->table_define} as ty 
        ON task.ta_type = ty.de_mark  
        LEFT JOIN {$this->table_define} as def
        ON task.ta_default = def.de_mark
        ORDER BY ta_idx DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_item($ta_idx){
        $sql = "SELECT * FROM {$this->table} WHERE ta_idx={$ta_idx}";

        $result = $this->db->query($sql)->row();
        return $result;
    }    
}

/* End of file Nmpa_task_m.php */
/* Location : ./application/models/nmpa/Nmpa_task_m.php */
?>