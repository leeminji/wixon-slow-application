<?php
class Menu_m extends CI_Model {
    private $table = "sl_menu_manage";
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
        if($menu->m_cnode > 0){
            return array(
                "result"=>false,
                "msg"=>'하위 메뉴가 있으므로 삭제 할 수 없습니다.'
            );
        }else{
            if($menu->m_pidx != 0){
                $this->update_cnode($menu->m_pidx, "DOWN");
            }
            $this->db->delete($this->table, array('idx'=>$idx));
            return array(
                "result"=>true
            );
        }
    }

    function update_item($idx, $data){
        $this->db->update($this->table, $data, array('idx'=>$idx));
    }

    function insert_item($data)
    {
        $data['m_rank'] = $this->get_rank_count($data['m_dep'])->dep_count;
        $data['m_id'] = $this->make_menu_id($data);
        if($data['m_pidx'] != 0){
            $this->update_cnode($data['m_pidx'], "UP");
        }
        if($this->db->insert($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }

    function make_menu_id($data){
        $str_id = "MENU_";
        if( $data['m_pidx'] != 0 ){
            $p_id = $this->get_item($data['m_pidx'])->m_id;
            $p_id_num = substr($p_id, strlen($str_id), 2*$data['m_dep']);
            $rank = str_pad($data['m_rank']+1,2*($this->menu_depth-(int)$data['m_dep']),"0",STR_PAD_RIGHT);
            $str_id .= "{$p_id_num}{$rank}";
        }else{
            $str = str_pad(0,2*($this->menu_depth-1),"0",STR_PAD_RIGHT);
            $rank = str_pad($data['m_rank']+1,"2","0",STR_PAD_RIGHT);
            $str_id .= "{$rank}{$str}";
        }
        return $str_id;
    }

    function get_rank_count($dep){
        $sql = "SELECT count(idx) as dep_count FROM {$this->table} WHERE m_dep={$dep}";
        return $this->db->query($sql)->row();
    }

    function get_all_items(){
        $sql = "SELECT * FROM {$this->table} ORDER BY m_dep ASC, m_rank ASC";
        $data = $this->db->query($sql)->result();
        return $data;
    }

    function set_items_rank($idxs){
        for($i=0;$i<count($idxs);$i++){
            $sql = "UPDATE {$this->table} SET m_rank = {$i} WHERE idx = {$idxs[$i]}";            
            $this->db->query($sql);
        }
    }

    function get_sub_items($pidx){
        $sql = "SELECT * FROM {$this->table} 
            WHERE m_pidx={$pidx}
            ORDER BY m_rank ASC";
        $data = $this->db->query($sql)->result();
        return $data;
    }

    function get_item($idx){
        return $this->db->get_where($this->table, ['idx' => $idx])->row();
    }

    function update_cnode($idx, $STATE='UP'){
        if($STATE == 'UP'){
            $sql = "UPDATE {$this->table} SET m_cnode = m_cnode+1 WHERE idx = {$idx}";
        }else if($STATE == 'DOWN'){
            $sql = "UPDATE {$this->table} SET m_cnode = m_cnode-1 WHERE idx = {$idx}";
        }
        $this->db->query($sql);
    }
}
?>