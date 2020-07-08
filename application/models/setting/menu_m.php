<?php
class Menu_m extends CI_Model {
    private $table = "sl_menu_manage";
    private $type_table = "sl_menu_type";
    private $menu_depth = 3; //3차메뉴까지존재

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

    function delete_item($idx){
        $menu = $this->get_item($idx);
        if($menu->mm_cnode > 0){
            return array(
                "result"=>false,
                "msg"=>'하위 메뉴가 있으므로 삭제 할 수 없습니다.'
            );
        }else{
            if($menu->mm_pidx != 0){
                $this->update_cnode($menu->mm_pidx, "DOWN");
            }
            $this->db->delete($this->table, array('mm_idx'=>$idx));
            return array(
                "result"=>true
            );
        }
    }

    function update_item($idx, $data){
        $this->db->update($this->table, $data, array('mm_idx'=>$idx));
    }

    function insert_item($data)
    {
        $data['mm_num'] = $this->get_rank_count($data['mm_dep'])->dep_count;
        $data['mm_id'] = $this->make_menu_id($data);
        if($data['mm_pidx'] != 0){
            $this->update_cnode($data['mm_pidx'], "UP");
        }
        if($this->db->insert($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }

    function make_menu_id($data){
        $str_id = "MENU_";
        if( $data['mm_pidx'] != 0 ){
            $p_id = $this->get_item($data['mm_pidx'])->id;
            $p_id_num = substr($p_id, strlen($str_id), 2*$data['mm_dep']);
            $rank = str_pad($data['mm_num']+1,2*($this->menu_depth-(int)$data['mm_dep']),"0",STR_PAD_RIGHT);
            $str_id .= "{$p_id_num}{$rank}";
        }else{
            $str = str_pad(0,2*($this->menu_depth-1),"0",STR_PAD_RIGHT);
            $rank = str_pad($data['mm_num']+1,"2","0",STR_PAD_RIGHT);
            $str_id .= "{$rank}{$str}";
        }
        return $str_id;
    }

    function get_rank_count($dep){
        $sql = "SELECT count(mm_idx) as dep_count FROM {$this->table} WHERE mm_dep={$dep}";
        return $this->db->query($sql)->row();
    }

    function get_all_types(){
        $sql = "SELECT * FROM {$this->type_table} ORDER BY mt_num ASC";
        $data = $this->db->query($sql)->result();
        return $data;
    }

    function get_all_items($t_idx){
        $sql = "SELECT menu.*, type.mt_name as mt_name
            FROM {$this->table} menu LEFT JOIN {$this->type_table} type 
            ON menu.mt_idx = type.mt_idx 
            WHERE menu.mt_idx = {$t_idx} 
            ORDER BY menu.mm_dep ASC, menu.mm_num ASC";
        $data = $this->db->query($sql)->result();
        return $data;
    }

    function set_items_rank($idxs){
        for($i=0;$i<count($idxs);$i++){
            $sql = "UPDATE {$this->table} SET mm_num = {$i} WHERE mm_idx = {$idxs[$i]}";            
            $this->db->query($sql);
        }
    }

    function get_sub_items($t_idx, $pidx){
        $sql = "SELECT * FROM {$this->table} 
            WHERE mm_pidx={$pidx} AND mt_idx={$t_idx} 
            ORDER BY mm_num ASC";
        $data = $this->db->query($sql)->result();
        return $data;
    }

    function get_item($idx){
        return $this->db->get_where($this->table, ['mm_idx' => $idx])->row();
    }

    function update_cnode($idx, $STATE='UP'){
        if($STATE == 'UP'){
            $sql = "UPDATE {$this->table} SET mm_cnode = mm_cnode+1 WHERE mm_idx = {$idx}";
        }else if($STATE == 'DOWN'){
            $sql = "UPDATE {$this->table} SET mm_cnode = mm_cnode-1 WHERE mm_idx = {$idx}";
        }
        $this->db->query($sql);
    }
}
?>