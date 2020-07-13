<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ra_category_m extends CI_Model{
    private $table = "sl_ra_category";
    
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
        $sql = "SELECT * FROM {$this->table} ORDER BY rc_num DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }
}

/* End of file Ra_category_m.php */
/* Location : ./application/models/ref/Ra_category_m.php */
?>