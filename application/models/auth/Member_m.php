<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
	회원게시판 모델
*/
class Member_m extends CI_Model{
	private $table = "sl_member";
	private $table_define = "sl_define";

	function __construct(){
		parent::__construct();
	}
	
	/* 회원 조회 */
	function get_member($mb_idx= ''){
		$sql = "
			SELECT member.*, m_level.de_name as ml_name, m_group.de_name as mg_name FROM {$this->table} member 
			LEFT JOIN {$this->table_define} m_level ON member.mb_level = m_level.de_mark 
			LEFT JOIN {$this->table_define} m_group ON member.mb_group = m_group.de_mark
			WHERE member.mb_idx={$mb_idx}";
		$query = $this->db->query($sql);
		$result = $query -> row();
		
		return $result;
	}

	/* 그룹조회 */
	function get_group_list($is_count=FALSE){
		if( $is_count ){
			$sql = "SELECT m_group.de_name AS mg_name, m_group.de_mark AS mg_idx, COUNT(mb_idx) AS mg_count FROM {$this->table} member 
			LEFT JOIN {$this->table_define} m_group ON member.mb_group = m_group.de_mark 
			WHERE m_group.de_group = 'MGROUP' 
			GROUP BY member.mb_group";
		}else{
			$sql = "
				SELECT de_name AS mg_name, de_mark AS mg_idx
				FROM {$this->table_define} 
				WHERE de_group = 'MGROUP' 
				ORDER BY de_num ASC
			";
		}
		$query = $this->db->query($sql);
		$result = $query -> result();

		return $result;
	}

	/* 레벨조회 */
	function get_level_list($is_count=FALSE){
		if( $is_count ){
			$sql = "SELECT m_level.de_name AS ml_name, m_level.de_mark AS ml_idx, COUNT(mb_idx) AS ml_count FROM {$this->table} member 
			LEFT JOIN {$this->table_define} m_level ON member.mb_level = m_level.de_mark 
			WHERE m_level.de_group = 'MLEVEL' 
			GROUP BY member.mb_level";
		}else{
			$sql = "
				SELECT de_name AS ml_name, de_mark AS ml_idx
				FROM {$this->table_define} 
				WHERE de_group = 'MLEVEL' 
				ORDER BY de_num ASC
			";
		}
		$query = $this->db->query($sql);
		$result = $query -> result();
		
		return $result;
	}
    
	//회원권한 업데이트
	function set_level($data){
		$update_data = array(
			"de_name" => $data['ml_name'],
		);
		$where = array(
			"de_mark" => "{$data['ml_idx']}",
			"de_group" => "MLEVEL",
		);
		$result = $this->db->update($this->table_define, $update_data, $where);
        return $result;
	}

	/* 조건에 맞는 멤버 불러오기 */
	function get_member_by($mb_level=false, $mg_idx=false){
		$sql_where = "";
		if($mb_level){
			$sql_where .= " AND mb_level = '{$mb_level}'";
		}
		if($mg_idx){
			$sql_where .= " AND mb_group = '{$mg_idx}'";
		}
		$sql = "SELECT * FROM {$this->table} WHERE 1 {$sql_where}";
		$query = $this -> db -> query($sql);
		$result = $query -> result();

		return $result;
	}

	/* 회원 리스트 */
	function member_list( $type='' , $offset='', $limit='' , $stx='', $sfl='', $sst='', $sod='DESC', $mb_level='' ){
		
		$search_query = "";
		if( $stx != "" && $sfl != "" ){
			$search_query = " WHERE member.{$sfl} LIKE '%{$stx}%' ";
		}else if( $mb_level != "" ){
			$search_query = " WHERE member.mb_level = '{$mb_level}'";
		}
		
		$order_query = " ORDER BY member.mb_idx DESC ";
		if( $sst != ""){
			$order_query = " ORDER BY member.{$sst} {$sod} ";
		}

		$limit_query = '';
		if( $limit != '' OR $offset != ''){
			$limit_query = " LIMIT {$offset}, {$limit}";
		}

		$sql = "
		SELECT member.*, m_level.de_name as ml_name, m_group.de_name as mg_name FROM {$this->table} member 
		LEFT JOIN {$this->table_define} m_level ON m_level.de_mark = member.mb_level 
		LEFT JOIN {$this->table_define} m_group ON m_group.de_mark = member.mb_group  
		{$search_query}{$order_query}{$limit_query}";

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
	
	/* 회원 아이디 중복 체크 */
	function member_id_chk($mb_id){
		$sql = "SELECT COUNT(mb_idx) as cnt FROM {$this->table} WHERE mb_id='{$mb_id}'";
		$query = $this -> db -> query($sql);
		return $query -> row();
	}


	/* 회원비밀번호 수정 */
	function member_passwd_update($data){
		$update_data['mb_passwd'] = $data['mb_passwd'];
		$update_data['mb_passwddate'] = date("Y-m-d H:i:s", time());
		$where = array(
			'mb_idx' => $data['mb_idx']
		);
		$result = $this->db->update($this->table, $update_data, $where);
		return $result;
	}

	/* 회원 탈퇴처리 */
	function member_state($data){
		$update_data = array(
			'mb_state' => $data['mb_state']
		);
		if( $data['mb_state'] == 0 ){
		    $update_data['mb_leavedate'] = date("Y-m-d H:i:s", time());
		}else{
		    $update_data['mb_leavedate'] = "";
		}
		$where = array(
			'mb_idx' => $data['mb_idx']
		);
		$result = $this->db->update($this->table, $update_data, $where);
		return $result;
	}

	/* 회원 입력 */
	function member_insert($data){
		$data['mb_state'] = 1;
		$data['mb_regdate'] = date("Y-m-d H:i:s", time());
		$data['mb_passwddate'] = date("Y-m-d H:i:s", time());

		$result = $this->db->insert($this->table, $data);
		return $result;
	}

	/* 회원 수정 */
	function member_update($data){
		//비밀번호재등록
		if( isset($data['mb_passwd']) ){
		    $data['mb_passwddate'] = date("Y-m-d H:i:s", time());
		}
		$where = array(
			'mb_idx' => $data['mb_idx']
		);

		$result = $this->db->update($this->table, $data, $where);
		return $result;
	}

	/* 멤버레벨 멤버 리스트 */
	function get_member_level($mb_level, $gt=false){
		$sql = "SELECT mb_idx, mb_id FROM {$this->table} WHERE 1 ";
		if( $gt ){
		    $sql .= " and mb_level >= {$mb_level} ";
		}else{
		    $sql .= " and mb_level = {$mb_level} ";
		}
		$query = $this -> db -> query($sql);
		if( $query -> num_rows() > 0 ){
			return $query -> result();
		}else{
			return false;
		}
	}
	
	/* 회원 삭제 */
	function member_delete($mb_idxs){
		for( $i = 0; $i < count($mb_idxs); $i++ ){
			$result =  $this->db->delete( $this ->table, array('mb_idx' => $mb_idxs[$i] ));
			if( !$result ){
				return false;
			}
		}
	}

	/* End of file Member_m.php */
	/* Location : ./application/models/Member_m.php */
}
?>