<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* checkmb=true, len=10
* 한글과 Eng (한글=2*3 + 공백=1*1 + 영문=1*1 => 10)
* checkmb=false, len=10
* 한글과 English (모두 합쳐 10자)
*/
function strcut_utf8($str, $len, $checkmb=false, $tail='..')
{
	preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);

	$m = $match[0];
	$slen = strlen($str); // length of source string
	$tlen = strlen($tail); // length of tail string
	$mlen = count($m); // length of matched characters

	if ($slen <= $len) return $str;
	if (!$checkmb && $mlen <= $len) return $str;

	$ret = array();
	$count = 0;

	for ($i=0; $i < $len; $i++)
	{
		$count += ($checkmb && strlen($m[$i]) > 1)?2:1;

		if ($count + $tlen > $len) break;
		$ret[] = $m[$i];
	}

	return join('', $ret).$tail;
}

function object_to_array($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }
 
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}
/** 
 * array에서 해당하는 key, value를 찾아 배열로 리턴
*/
function make_array($array, $key, $value){
	$return_array = array();
	foreach($array as $ar){
		$return_array[$ar->$key] = $ar->$value;
	}
	return $return_array;
}

function array_to_object($d) {
	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return (object) array_map(__FUNCTION__, $d);
	}
	else {
		// Return object
		return $d;
	}
}

function array_sort($array, $on, $order=SORT_ASC)
{
	$new_array = array();
	$sortable_array = array();

	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k2 => $v2) {
					if ($k2 == $on) {
						$sortable_array[$k] = $v2;
					}
				}
			} else {
				$sortable_array[$k] = $v;
			}
		}

		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
			break;
			case SORT_DESC:
				arsort($sortable_array);
			break;
		}

		foreach ($sortable_array as $k => $v) {
			$new_array[$k] = $array[$k];
		}
	}

	return $new_array;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function get_month($_month){
    $monthString = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");
    return $monthString[$_month];
}

//페이지네이션 라이브러리 로딩 추가
function set_pagenation($config){
	//base_url, per_page, total_rows
	$CI =& get_instance();
	$CI->load->library('pagination');
	//쿼리스트링으로 변환
	$config['page_query_string'] = TRUE;
	$config['num_links'] = 5;
	$CI->pagination->initialize($config);

	return $CI->pagination->create_links();
}

function get_list_page($set_per_page){
	$CI =& get_instance();
	$get_per_page = $CI->input ->get("per_page", TRUE);
	if( $get_per_page != null && $get_per_page > 0 ){
		$page = ($get_per_page/$set_per_page);
	}else{
		$page = 0;
	}
	return $page;	
}

function get_list_num($total_rows, $per_page, $num){
	return $total_rows - (get_list_page($per_page) * $per_page )-$num;
}

function get_list_start($set_per_page){
	$CI =& get_instance();
	$get_per_page = $CI->input ->get("per_page", TRUE);
	if( $get_per_page != null && $get_per_page > 0 ){
		$start = ($get_per_page/$set_per_page)*$set_per_page;
	}else{
		$start = 0;
	}

	return $start;
}

?>