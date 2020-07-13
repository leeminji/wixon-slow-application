<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_to_menu'))
{
	function get_to_menu($list, $midx)
	{
		return get_to_menulist($list, 0, 0, $midx);
	}
}

if ( ! function_exists('get_to_menu_sub_list'))
{
	function get_to_menu_sub_list($list)
	{
		$html = "";
		$html.="<ul class=\"MenuList\">";
		foreach($list as $item){
			$item->mm_cnode = 0;
			$html .= get_to_menuitem($list, $item);
		}
		$html.="</ul>";
		return $html;
	}
}

if ( ! function_exists('get_to_menulist'))
{
	function get_to_menulist($list, $dep=0, $pidx=0, $midx)
	{
		$html = "";
		$thml_dep = $dep > 0 ? "data-rank=\"{$dep}\"": "";
		$html.="<ul class=\"MenuList\" {$thml_dep}>";
		foreach($list as $item){
			if( $item->mm_dep == $dep && $item->mm_pidx == $pidx){
				$html .= get_to_menuitem($list, $item, $midx);
			}
		}
		$html.="</ul>";
		return $html;
	}
}

if ( ! function_exists('get_to_menuitem'))
{
	function get_to_menuitem($list, $item, $midx){
		$html = "";
		$is_sub = $item->mm_cnode > 0 ? " isSub" : "";
		$is_active = $midx == $item->mm_idx ? " active" : "";
		$html .= "<li class=\"MenuList__item{$is_sub}{$is_active}\" data-idx=\"{$item->mm_idx}\">";
		$html .= 	"<a href='{$item->mm_link}/{$item->mm_idx}'>";
		$html .= 	"<span class=\"icon\"></span>";
		$html .= 	"<span class=\"name\">{$item->mm_name}</span>";
		$html .=    '</a>';
		if( $item->mm_cnode > 0 ){
			$html .= get_to_menulist($list, $item->mm_dep+1, $item->mm_idx, $midx);
		}
		$html .= "</li>";

		return $html;
	}
}