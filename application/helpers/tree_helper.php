<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_to_tree'))
{
	function get_to_tree($list)
	{
		return get_to_treelist($list, 0);
	}
}

if ( ! function_exists('get_to_tree_sub_list'))
{
	function get_to_tree_sub_list($list)
	{
		$html = "";
		$html.="<ul class=\"MenuTree__list\">";
		foreach($list as $item){
			$item->mm_cnode = 0;
			$html .= get_to_treeitem($list, $item);
		}
		$html.="</ul>";
		return $html;
	}
}

if ( ! function_exists('get_to_treelist'))
{
	function get_to_treelist($list, $dep=0, $pidx=0)
	{
		$html = "";
		$html.="<ul class=\"MenuTree__list\" data-rank=\"{$dep}\">";
		foreach($list as $item){
			if( $item->mm_dep == $dep && $item->mm_pidx == $pidx){
				$html .= get_to_treeitem($list, $item);
			}
		}
		$html.="</ul>";
		return $html;
	}
}

if ( ! function_exists('get_to_treeitem'))
{
	function get_to_treeitem($list, $item){
		$html = "";
		$is_sub = $item->mm_cnode > 0 ? "isSub" : "";
		$html .= "<li class=\"MenuTree__item {$is_sub}\" data-idx=\"{$item->mm_idx}\">";
		$html .= "	<input type=\"hidden\" name=\"mm_idx[]\" value=\"{$item->mm_idx}\" />";
		$html .= 	"<div class=\"info\">";
		$html .= 	"<span class=\"toggle\">▶</span>";
		$html .= 	"<span class=\"icon\"></span>";
		$html .= 	"<span class=\"name\">{$item->mm_name} <i>[{$item->mm_id}]</i></span>";
		$html .= 	"</div>";
		if( $item->mm_cnode > 0 ){
			$html .= get_to_treelist($list, $item->mm_dep+1, $item->mm_idx);
		}
		$html .= "</li>";

		return $html;
	}
}