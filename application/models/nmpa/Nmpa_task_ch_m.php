<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa_task_ch_m extends CI_Model{
    private $table = "sl_nmpa_task_ch";

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_items($ta_idx){
        $sql = "SELECT * FROM {$this->table} 
        WHERE ta_idx={$ta_idx}
        ORDER BY nc_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }
}

/* End of file Nmpa_task_ch_m.php */
/* Location : ./application/models/nmpa/Nmpa_task_ch_m.php */
?>