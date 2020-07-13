<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('bt_dropdown_box'))
{
	function ft_dropdown_box($name, $options, $items=array(), $size="10"){
		$html = "<div class=\"SelectBox\" style=\"width:{$size}em\">";
		$html .= "<select name=\"{$name}\">";
		if ( is_array($options))
		{
			foreach($options as $key => $val)
			{
				if(!$val) continue;
				$html .= "<option value='" . $key ."'";
				if(is_array($items) && in_array($key, $items)) $html .=" selected=\"selected\"";
				else $html .="";
				$html .=">" . $val . "</option>\n";
			}
		}
		$html .="</select>";
		$html .="</div>";
		return $html;
	}
}

if ( ! function_exists('ft_checkbox')){
	function ft_checkbox($name, $options, $items=array()){
		$html ="";
		if ( is_array($options))
		{
			foreach($options as $key => $val)
			{
				if(!$val) continue;
				$html .="<div class='Checkbox'>";
				$html .= "<label class='Checkbox__label'>";				
				$html .= "<input type='checkbox' name='{$name}'' value='{$key}'";
				if(is_array($items) && in_array($key, $items)){
					$html .=" checked=\"checked\"";
				} else { 
					$html .=""; 
				};
				$html .=" /><span class='Checkbox__text'>{$val}</span>";
				$html .="</label></div>";
			}
		}
		
		return $html;	
	}
}