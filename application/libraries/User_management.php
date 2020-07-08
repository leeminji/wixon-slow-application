<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User_management
 *
 * User's infomation library for Code Igniter.
 *
 * @package		User_management
 * @author		dhkim
 * @version		1.0.0
 * @license		MIT License Copyright
 * @filesource
 */

// ------------------------------------------------------------------------

class User_management
{

	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->config->load('tablename');
		$this->table = $this->ci->config->item('table');
	}

	/**
	 * 사용자 부서정보 삭제하기
	 * 결과값 bool.
	 *
	 * @param	string
	 * @return	bool
	 */
	function get_obs_delete($uid, $org_code)
	{
		// OBS관리 테이블에서 해당 정보 반환
		$this->ci->load->model('admin/org_manage_m');

		if( is_null($row = $this->ci->org_manage_m->get_node_uinfo($uid, $org_code, "U")))
		{
			return TRUE;
		}
		else
		{
			if($this->ci->org_manage_m->delete_node_info($row->idx))
			{
				/* 삭제 노드의 상위노드의 child 값을 -1 처리함 */
				if($this->ci->org_manage_m->modify_prnnode_child_info($row->o_pidx, ''))
				{
					/* 삭제 노드의 형제노드 중 rank가 높은 노드의 rank 값을 -1 처리함 */
					if($this->ci->org_manage_m->modify_prnnode_rank_info($row->o_pidx, $row->o_rank))
					{
						return TRUE;
					}
				}
			}

			return FALSE;
		}
	}

	/**
	 * 선택 첨부파일 서버에서 삭제하기
	 * 결과값 bool.
	 *
	 * @param	int
	 * @return	bool
	 */
	function get_upfile_delete($fno)
	{
		// 파일관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('upload_manage_m');

		// 선택한 파일 삭제
		$f = $this->ci->upload_manage_m->get_info($fno);

		if($f->server_name)
		{
			$host = $_SERVER['DOCUMENT_ROOT'];
			$thumb_path = $f->file_path.$f->raw_name."_thumb".$f->file_ext;

			@unlink($host.$f->server_name);
			if(is_file($host.$thumb_path)) @unlink($host.$thumb_path);

			return $this->upload_manage_m->delete_info($fno);
		}

		return false;
	}


	/**
	 * 조직별 사용자 배열
	 * 결과값 bool.
	 *
	 * @param	int
	 * @return	bool
	 */
	function get_userlist_array()
	{
		// 회원관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/user_manage_m');

		$rows = $this->ci->user_manage_m->get_list('', '', '', '');

		$res_array = array();

		foreach($rows as $item)
		{
			if( $item->activated ) {
				$res_array[$item->org_code]['name'][$item->idx] = $item->user_name;
				$res_array[$item->org_code]['receptionist'][$item->idx] = $item->doc_manage_yn;
			}
		}

		return $res_array;
	}


	/* 조직분류 체계 Tree  */
	function get_org_tree_array($o_kind)
	{

		$tree = array();

		if( !is_null($row = $this->ci->org_manage_m->get_node_list($o_kind)) )
		{
			foreach($row as $lt) {

				// Create or add child information to the parent node
				if (isset($tree[$lt->o_pidx]))
					// a node for the parent exists
					// add another child id to this parent
					$tree[$lt->o_pidx]["children"][] = $lt->idx;
				else
					// create the first child to this parent
					$tree[$lt->o_pidx] = array("children"=>array($lt->idx));

				// Create or add name information for current node
				if (isset($tree[$lt->idx]))
				{
					// a node for the id exists:
					// set the name of current node
					$tree[$lt->idx]["o_id"] = $lt->o_id;
					$tree[$lt->idx]["o_name"] = $lt->o_name;
					$tree[$lt->idx]["o_dep"] = $lt->o_dep;
					$tree[$lt->idx]["o_pidx"] = $lt->o_pidx;
					$tree[$lt->idx]["o_type"] = $lt->o_type;
					$tree[$lt->idx]["o_isuse"] = $lt->o_isuse;
					$tree[$lt->idx]["o_etc"] = $lt->o_etc;
				}
				else
				{
					// create the current node and give it a name
					$tree[$lt->idx] = array( "o_id"=>$lt->o_id, "o_name"=>$lt->o_name, "o_dep"=>$lt->o_dep, "o_pidx"=>$lt->o_pidx, "o_type"=>$lt->o_type, "o_isuse"=>$lt->o_isuse, "o_etc"=>$lt->o_etc );
				}

			}
		}

		return $tree;

	}

	/**
	 * 조직별 문서접수자 배열
	 * 결과값 bool.
	 *
	 * @param	int
	 * @return	bool
	 */
	function get_receptionist_array()
	{
		// 회원관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/user_manage_m');

		$rows = $this->ci->user_manage_m->get_receptionist_info();

		$res_array = array();

		foreach($rows as $item)
		{
			$res_array[$item->org_code][$item->idx] = $item->user_name;
		}

		return $res_array;
	}


	/**
	 * 사용자 사인 이미지 정보
	 * 결과값 bool.
	 *
	 * @param	$uno int
	 * @return	string or Null
	 */
	function get_user_sign($uno)
	{
		// 회원관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/user_manage_m');
		$this->ci->load->model('upload_manage_m');

		if( !is_null($user = $this->ci->user_manage_m->get_user_info($uno, 'no', '')) )
		{

			$file = $this->ci->upload_manage_m->get_info($user->sign_no);
			$host = $_SERVER['DOCUMENT_ROOT'];
			$thumb_path = $file->file_path.$file->raw_name."_thumb".$file->file_ext;
			if(is_file($host.$thumb_path))
			{
				$file_path = $host.$thumb_path;
			}
			else
			{
				$file_path =  $host.$file->file_path.$file->raw_name.$file->file_ext;
			}

			return $file_path;
		}

		return NULL;
	}

}

/* End of file User_management.php */
/* Location: ./application/libraries/User_management.php */