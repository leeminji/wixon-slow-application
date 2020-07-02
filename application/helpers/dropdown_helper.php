<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * dropdown
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @return	html	depends on what the array contains
 */

if ( ! function_exists('bt_dropdown_box'))
{
	function bt_dropdown_box($name, $id, $class, $array, $item, $default)
	{

		if($class == '') $class_msg = "";
		else $class_msg = "class='".$class."'";

		$html = "<select name='". $name ."' id='".$id."' ".$class_msg.">\n";
		if($default) $html .= "<option value=''>" . $default . "</option>\n";

		if ( is_array($array))
		{
			foreach($array as $key => $val)
			{
				if(!$val) continue;
				$html .= "<option value='" . $key ."'";
				if($item != "" && $key == $item) $html .=" selected";
				$html .=">" . $val . "</option>\n";
			}
		}
		$html .= "</select>\n";
		return $html;
	}
}
if ( ! function_exists('bt_dropdown_box2'))
{
	function bt_dropdown_box2($name, $id, $class, $array, $item, $default)
	{

		if($class == '') $class_msg = "";
		else $class_msg = "class='".$class."'";

		$html = "<select name='". $name ."' id='".$id."' ".$class_msg.">\n";
		if($default) $html .= "<option value=''>" . $default . "</option>\n";

		if ( is_array($array))
		{
			foreach($array as $key => $val)
			{
				if(!$val){
                                    continue;
                                }
				
				if($item != "" && $key == $item) {
                                    $html .= "<option value='" . $key ."'";
                                    $html .=" selected";
                                    break;
                                }
				
                                
			}
                        $html .=">" . $val . "</option>\n";
		}
		$html .= "</select>\n";
		return $html;
	}
}

if ( ! function_exists('bt_dropdown_box_option'))
{
	function bt_dropdown_box_option($array, $item, $default)
	{
		$html = "";
		if($default) $html .= "<option value=''>" . $default . "</option>\n";

		if ( is_array($array))
		{
			foreach($array as $key => $val)
			{
				if ( is_array($val) )
				{
					foreach($val as $skey => $sval)
					{
						if(!$sval) continue;
						$html .= "<option value='" . $skey ."'";
						if($item != "" && $skey == $item) $html .=" selected";
						$html .=">" . $sval . "</option>\n";
					}
				}
				else
				{
					if(!$val) continue;
					$html .= "<option value='" . $key ."'";
					if($item != "" && $key == $item) $html .=" selected";
					$html .=">" . $val . "</option>\n";
				}
			}
		}
		return $html;
	}
}

/**
 * dropdown
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @param	javascript function (object)
 * @return	html	depends on what the array contains
 */

if ( ! function_exists('bt_dropdown_box_auto'))
{
	function bt_dropdown_box_auto($name, $id, $class, $array, $item, $default, $javascript)
	{
		if(isset($javascript) && $javascript != '') $onchange = "onchange='javascript:".$javascript."'";
		else $onchange = '';

		if($class == '') $class_msg = "";
		else $class_msg = "class='".$class."'";

		$html = "<select name='" . $name . "' id='" . $id . "' class='".$class."' ".$onchange.">\n";
		if($default) $html .= "<option value='ALL'>" . $default . "</option>\n";

		if ( is_array($array))
		{
			foreach($array as $key => $val)
			{
				if(!$val) continue;
				$html .= "<option value='" . $key ."'";
				if($item != "" && $key == $item) $html .=" selected";
				$html .=">" . $val . "</option>\n";
			}
		}

		$html .= "</select>\n";
		return $html;
	}
}

/**
 * dropdown to use bootstrap
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	array
 * @return	html	depends on what the array contains
 */

if ( ! function_exists('bt_dropdown_box_bootstrap'))
{
	function bt_dropdown_box_bootstrap($id, $options, $items)
	{

		$html = '';

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

		return $html;
	}
}

/**
 * dropdown to use bootstrap
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	array
 * @return	html	depends on what the array contains
 */

if ( ! function_exists('bt_dropdown_box_bootstrap1'))
{
	function bt_dropdown_box_bootstrap1($id, $options, $items)
	{

		$html = "<select id=\"".$id."\" name=\"".$id."[]\" multiple=\"multiple\">";

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

		$html .= "</select>";

		return $html;
	}
}