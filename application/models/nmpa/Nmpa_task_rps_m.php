<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nmpa_task_rps_m extends CI_Model{
    private $table = "sl_nmpa_task_rps";
    private $table_ch = "sl_nmpa_task_ch";

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_item($idx){
        $sql = "SELECT rps.*, LPAD(rps.nr_num+1,2,0) as nr_num, chapter.nc_title FROM {$this->table} rps LEFT JOIN {$this->table_ch} chapter
        ON rps.nc_idx = chapter.nc_idx
        WHERE rps.nr_idx={$idx}";
        $result = $this->db->query($sql)->row();
        return $result;
    }

    function get_items($ta_idx, $nc_idx){
        $sql = "SELECT rps.*, LPAD(rps.nr_num+1,2,0) as nr_num, chapter.nc_title FROM {$this->table} rps LEFT JOIN {$this->table_ch} chapter
        ON rps.nc_idx = chapter.nc_idx
        WHERE rps.ta_idx={$ta_idx} AND rps.nc_idx={$nc_idx} AND rps.nr_dep=0
        ORDER BY rps.nr_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    function get_sub_items($pidx){
        $sql = "
        SELECT rps.*, LPAD(rps.nr_num+1, 2, 0) as nr_num, chapter.nc_title, LPAD(p_rps.nr_num+1, 2, 0) AS pidx_num 
        FROM {$this->table} rps 
        LEFT JOIN {$this->table_ch} chapter
        ON rps.nc_idx = chapter.nc_idx
        LEFT JOIN {$this->table} p_rps
        ON rps.nr_pidx = p_rps.nr_idx 
        WHERE rps.nr_pidx={$pidx} 
        ORDER BY rps.nr_num ASC";
        $result = $this->db->query($sql)->result();
        return $result;
    }
    
}

/* End of file Nmpa_task_rps_m.php */
/* Location : ./application/models/nmpa/Nmpa_task_rps_m.php */
?>