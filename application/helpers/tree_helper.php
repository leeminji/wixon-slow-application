<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_to_tree'))
{
	function get_to_tree($list)
	{
		return get_to_treelist($list, 0);
	}
}

if ( ! function_exists('get_to_treelist'))
{
	function get_to_tree_sub_list($list)
	{
		$html = "";
		$html.="<ul class=\"MenuTree__list\">";
		foreach($list as $item){
			$item->m_cnode = 0;
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
			if( $item->m_dep == $dep && $item->m_pidx == $pidx){
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
		$is_sub = $item->m_cnode > 0 ? "isSub" : "";
		$html .= "<li class=\"MenuTree__item {$is_sub}\" data-idx=\"{$item->idx}\">";
		$html .= "	<input type=\"hidden\" name=\"idx[]\" value=\"{$item->idx}\" />";
		$html .= 	"<div class=\"info\">";
		$html .= 	"<span class=\"toggle\">▶</span>";
		$html .= 	"<span class=\"icon\"></span>";
		$html .= 	"<span class=\"name\">{$item->m_name} <i>[{$item->m_id}]</i></span>";
		$html .= 	"</div>";
		if( $item->m_cnode > 0 ){
			$html .= get_to_treelist($list, $item->m_dep+1, $item->idx);
		}
		$html .= "</li>";

		return $html;
	}
}