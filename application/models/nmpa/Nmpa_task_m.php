<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa_task_m extends CI_Model{
    private $table = "sl_nmpa_task";
    private $table_type = "sl_nmpa_type";
    private $table_ch = "sl_nmpa_task_ch";
    private $table_rps = "sl_nmpa_task_rps";

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_items($count)
    {
        $query = $this->db->get($this->table, $count);
        return $query->result();
    }

    function get_all_type_items(){
        $sql = "SELECT * FROM {$this->table_type} ORDER BY ty_name ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_all_items(){
        $sql = "SELECT task.*, type.ty_name FROM {$this->table} as task 
        LEFT JOIN {$this->table_type} as type 
        ON task.ty_idx = type.ty_idx 
        ORDER BY ta_idx DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }
}

/* End of file Nmpa_type_m.php */
/* Location : ./application/models/nmpa/Nmpa_type_m.php */
?>