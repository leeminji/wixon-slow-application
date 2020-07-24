<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_to_menu'))
{
	function get_to_menu($list, $midx)
	{
		$CI =& get_instance();
		$user = $CI->user_info;
		return get_to_menulist($list, 0, 0, $midx, $user);
	}
}


if ( ! function_exists('get_to_menulist'))
{
	function get_to_menulist($list, $dep=0, $pidx=0, $midx, $user)
	{
		$CI =& get_instance();
		$html = "";
		$thml_dep = $dep > 0 ? "data-rank=\"{$dep}\"": "";
		$html.="<ul class=\"MenuList\" {$thml_dep}>";
		foreach($list as $item){
			$is_level = $item->mm_level == null ? true : in_array($user->mb_level, explode(",",$item->mm_level));
			$is_group = $item->mm_group == null ? true : in_array($user->mb_group, explode(",",$item->mm_group));
			$is_super = $user->mb_level == "M01" && $user->mb_group == "G01"; 
			
			$is_client = in_array($user->mb_level, array("M03","M04"));
			
			if( ($is_level == true && $is_group == true) || $is_super){
				if($is_super){
					//총관리자의경우 사용자 전용메뉴는 보이지 않게처리.
					if( $item->mm_dep == $dep && $item->mm_pidx == $pidx && $item->mm_type != 'C'){					
						$html .= get_to_menuitem($list, $item, $midx, $user);
					}
				}else{
					//레벨, 그룹 통과할시에 수행
					if( $item->mm_dep == $dep && $item->mm_pidx == $pidx){					
						$html .= get_to_menuitem($list, $item, $midx, $user);
					}
				}
			}
		}
		$html.="</ul>";
		return $html;
	}
}

if ( ! function_exists('get_to_menuitem'))
{
	function get_to_menuitem($list, $item, $midx, $user){
		$html = "";
		$is_sub = $item->mm_cnode > 0 ? " isSub" : "";
		$is_active = $midx == $item->mm_idx ? " active" : "";
		$html .= "";
		$html .= "<li class=\"MenuList__item{$is_sub}{$is_active}\" data-idx=\"{$item->mm_idx}\">";
		$html .= 	"<a href='{$item->mm_link}/{$item->mm_idx}'>";
		$html .= 	"<span class=\"icon\"></span>";
		$html .= 	"<span class=\"name\">{$item->mm_name}</span>";
		$html .=    '</a>';
		if( $item->mm_cnode > 0 ){
			$html .= get_to_menulist($list, $item->mm_dep+1, $item->mm_idx, $midx, $user);
		}
		$html .= "</li>";

		return $html;
	}
}