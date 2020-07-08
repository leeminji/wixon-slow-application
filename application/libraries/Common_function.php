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

class Common_function
{

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->library('session');
		$this->ci->load->helper('alert');
	}

	/**
	 * url중 키값을 구분하여 값을 가져오도록.
	 *
	 * @param Array $url : segment_explode 한 url값
	 * @param String $key : 가져오려는 값의 key
	 * @return String $url[$k] : 리턴값
	 */
	function url_explode($url, $key)
	{
		$cnt = count($url);
		for($i=0; $cnt>$i; $i++ )
		{
			if($url[$i] == $key)
			{
				$k = $i+1;
				return $url[$k];
			}
		}
	}

	/**
	 * HTTP의 URL을 "/"를 Delimiter로 사용하여 배열로 바꾸어 리턴한다.
	 *
	 * @param	string	대상이 되는 문자열
	 * @return	string[]
	 */
	function segment_explode($seg)
	{
		//세크먼트 앞뒤 '/' 제거후 uri를 배열로 반환
		$len = strlen($seg);
		if(substr($seg, 0, 1) == '/')
		{
			$seg = substr($seg, 1, $len);
		}
		$len = strlen($seg);
		if(substr($seg, -1) == '/')
		{
			$seg = substr($seg, 0, $len-1);
		}
		$seg_exp = explode("/", $seg);
		return $seg_exp;
	}

	/**
	 * 코드관리의 정보를 불러와서 배열로 바꾸어 리턴한다.
	 *
	 * @param	c_kind string	코드 종류 구분자
	 * @param	c_pidx string	가져올 코드 정보 고유 ID (고유 ID의 하위 자식 코드를 불러옮)
	 * @return	string[]
	 */
	function make_array($c_kind, $c_pidx='')
	{
		// code관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/code_manage_m');

		$get_array = $this->ci->code_manage_m->get_node_list($c_kind, $c_pidx);
		$res_array = array();

		foreach($get_array as $item)
		{
			if($item->c_isuse == "Y")
			{
				$res_array[$item->c_id] = $item->c_name;
			}
		}

		return $res_array;
	}

	function make_array_idx($c_kind, $c_pidx='')
	{
		// code관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/code_manage_m');

		if($c_pidx == '') {
			$get_array = $this->ci->code_manage_m->get_node_list($c_kind, '');
		}
		else {
			$get_array = $this->ci->code_manage_m->get_node_list($c_kind, $c_pidx);
		}

		$res_array = array();

		foreach($get_array as $item)
		{
			if($item->c_isuse == "Y")
			{
				$res_array[$item->idx] = $item->c_name;
			}
		}

		return $res_array;
	}

	function make_array_obs($org_code)
	{
		// obs관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/org_manage_m');

		$get_array = $this->ci->org_manage_m->get_obs_list($org_code);

		$res_array = array();

		foreach($get_array as $item)
		{
			if($item->o_isuse == "Y")
			{
				$res_array[$item->idx] = $item->o_name;
			}
		}

		return $res_array;
	}

	/**
	 * 분류체계관리의 정보를 불러와서 배열로 바꾸어 리턴한다.
	 *
	 * @param	f_kind string	분류체계 종류 구분자
	 * @param	org_code string	조직 코드
	 * @return	array
	 */
	function make_array_fbs($org_code, $f_kind)
	{
		// fbs관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/fbs_manage_m');

		$get_array = $this->ci->fbs_manage_m->get_nochild_list($org_code, $f_kind);
		$res_array = array();

		foreach($get_array as $item)
		{
			if($item->f_isuse == "Y")
			{
				$res_array[$item->idx] = $item->f_name;
			}
		}

		return $res_array;
	}

	/**
	 * 분류체계관리의 정보 배열로 리턴.
	 *
	 * @param	f_kind string	분류체계 종류 구분자
	 * @param	org_code string	조직 코드
	 * @param	f_pidx string	상위 코드
	 * @return	array
	 */
	function make_array_multi_fbs($org_code, $f_kind, $f_pidx)
	{
		// fbs관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/fbs_manage_m');

		$get_array = $this->ci->fbs_manage_m->get_node_list($org_code, $f_kind, $f_pidx);
		$res_array = array();

		foreach($get_array as $item)
		{
			if($item->f_isuse == "Y")
			{
				$res_array[$item->idx] = $item->f_name;
			}
		}

		return $res_array;
	}

	/* 공정관리 공종 정보 */
	function make_array_works($limit='N')
	{
		// works_items관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('progress_manage/progress_status_m');

		$get_array = $this->ci->progress_status_m->get_works_array();

		$res_array = array();

		foreach($get_array as $item)
		{
			if($limit == 'Y' && $item->idx > $this->ci->config->item('progress_view_limit')) continue;
			if($item->c_isuse == "Y")
			{
				$res_array[$item->idx] = $item->c_name;
			}
		}

		return $res_array;
	}

	/* 주요자재 항목 정보 */
	function make_array_resource()
	{
		// works_resource 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/works_resource_m');

		$get_array = $this->ci->works_resource_m->get_node_list('');

		$res_array = array();

		foreach($get_array as $item)
		{
			if($item->c_isuse == "Y")
			{
				$res_array[$item->c_id] = $item->c_name;
			}
		}

		return $res_array;
	}


	/**
	 * 조직별 타조직의 정보 조회여부 정보를 배열로 바꾸어 리턴한다.
	 *
	 * @param	f_kind string	분류체계 종류 구분자
	 * @return	array
	 */
	function make_array_viewallow($c_kind)
	{
		// fbs관리 테이블에서 해당 정보를 가져와서 배열로 반환
		$this->ci->load->model('admin/code_manage_m');

		$row = $this->ci->code_manage_m->get_node_list($c_kind);
		$res_array = array();

		foreach($row as $item)
		{
			if($item->c_isuse == "Y")
			{
				$res_array[$item->c_id] = $item->c_etc;
			}
		}

		return $res_array;
	}

	function get_array_month() {

		for($i=1; $i < 13; $i++) {

			if($i < 10) $key = "0".$i;
			else $key = $i;
			$value = $i."월";
			$_SELECT[$key] = $value;
		}
		return $_SELECT;
	}

	function get_array_year($Name,$start,$end,$class, $Selected, $Default) {

		$Msg = "<select name='" . $Name . "' id='".$Name."' class='".$class."'>\n";
		if($Default) $Msg .= "<option value=''>" . $Default . "</option>\n";
		for($i=$start; $i <= $end; $i++) {
			$key = $i;
			$val = $i;
			$Msg .= "<option value='" . $key ."'";
			if($Selected != "N" && $key == $Selected && $Selected != "") $Msg .=" selected";
			$Msg .=">" . $val . "년 </option>\n";
		}
		$Msg .= "</select>\n";
		return $Msg;
	}

	/**
	 * param1을 param2까지 1씩 증가한 배열 리턴한다.
	 *
	 * @param	n int	시작값
	 * @param	f int	비교값
	 * @param	word string	옵션 값
	 * @return	array
	 */
	function bt_array_increase($n, $f, $word) {

		if($n <= $f)
		{
			for($i=$n; $i <= $f; $i++) {

				$value = $word.$i;
				$_SELECT[$i] = $value;
			}
		}
		else
		{
			$_SELECT = array();
		}
		return $_SELECT;
	}

	/**
	 * param1을 param2까지 1씩 감소한 배열 리턴한다.
	 *
	 * @param	n int	시작값
	 * @param	f int	비교값
	 * @param	word string	옵션 값
	 * @return	array
	 */
	function bt_array_decrease($n, $f, $word) {

		if($n >= $f)
		{
			for($i=$n; $i >= $f; $i--) {

				$value = $word.$i;
				$_SELECT[$i] = $value;
			}
		}
		else
		{
			$_SELECT = array();
		}
		return $_SELECT;
	}


	/**
	* 유일한 값을 구함
	**/
	function get_unique_id(){
		$token = md5(uniqid(rand()));
		return $token;
	}

	function utf8($str)
	{
		return iconv('euc-kr','utf-8', $str) ;
	}

	function euckr($str)
	{

		return iconv('utf-8', 'euc-kr', $str) ;
	}

	// 저장 폴더 생성
	function bt_mkdir($dir,$dirmode=0755){
		if (!empty($dir)){
			if (!file_exists($dir)){
				preg_match_all('/([^\/]*)\/?/i', $dir,$atmp);
				$base="";
				foreach ($atmp[0] as $key=>$val){
					$base=$base.$val;
					if(!file_exists($base))
						if (!mkdir($base,$dirmode)){
							echo "Error: Cannot create ".$base;
							return -1;
						}
				}
			}
			else
				if (!is_dir($dir)){
					 echo "Error: ".$dir." exists and is not a directory";
					 return -2;
				}
		}
		return 0;
	}

	/****************************************************************************************/
	/*                        Date function                                                 */
	/****************************************************************************************/
	// $sdate에서 $day만큼 지난 날짜를 리턴하는 함수
	function nextdate($sdate, $day){

		if($day == 0) {
			return $sdate;
		}
		else {

			$this->ci->load->model('date_function_m');
			$sdate = $this->ci->date_function_m->get_nextday($sdate, $day, "DAY");

			return $sdate;
		}
	}

	// $sdate에서 $day만큼 이전 날짜를 리턴하는 함수
	function predate($sdate,$day){

		if($day == 0) {
			return $sdate;
		}
		else {

			$this->ci->load->model('date_function_m');
			$sdate = $this->ci->date_function_m->get_preday($sdate, $day, "DAY");

			return $sdate;
		}
	}

	function nextmonth($sdate,$month){

		if($month == 0) {
			return $sdate;
		}
		else {

			$this->ci->load->model('date_function_m');
			$sdate = $this->ci->date_function_m->get_nextday($sdate, $month, "MONTH");

			return $sdate;
		}
	}

	function premonth($sdate,$month){

		if($month == 0) {
			return $sdate;
		}
		else {

			$this->ci->load->model('date_function_m');
			$sdate = $this->ci->date_function_m->get_preday($sdate, $month, "MONTH");

			return $sdate;
		}
	}

	function nextyear($sdate,$year){

		if($year == 0) {
			return $sdate;
		}
		else {

			$this->ci->load->model('date_function_m');
			$sdate = $this->ci->date_function_m->get_nextday($sdate, $year, "YEAR");

			return $sdate;
		}
	}

	function preyear($sdate,$year){

		if($year == 0) {
			return $sdate;
		}
		else {

			$this->ci->load->model('date_function_m');
			$sdate = $this->ci->date_function_m->get_preday($sdate, $year, "YEAR");

			return $sdate;
		}
	}

	function lastdayofmonth($sdate) {

		$this->ci->load->model('date_function_m');
		$sdate = $this->ci->date_function_m->get_lastofmonth($sdate);

		return $sdate;
	}

	function get_datediff($sdate1, $sdate2) {

		$this->ci->load->model('date_function_m');
		$diff = $this->ci->date_function_m->get_datediff($sdate1, $sdate2);

		return $diff;
	}

	function get_monthdiff($sdate1, $sdate2) {

		$sdate1 = substr(str_replace("-", "", $sdate1), 0, 6);
		$sdate2 = substr(str_replace("-", "", $sdate2), 0, 6);

		$this->ci->load->model('date_function_m');
		$diff = $this->ci->date_function_m->get_period_diff($sdate1, $sdate2);

		return $diff;
	}

	function whatdayname($sdate) {
		switch ($sdate) {
			case "0" : $aday = "일";	break;
			case "1" : $aday = "월";	break;
			case "2" : $aday = "화";	break;
			case "3" : $aday = "수";	break;
			case "4" : $aday = "목";	break;
			case "5" : $aday = "금";	break;
			case "6" : $aday = "토";	break;
		}

		return $aday;
	}

	function whatweek($sdate, $mode) {

		/*
			mode : 0 Week 1은 일요일을 포함하는 첫 번째 주 0 .. 53
			mode : 2 Week 1은 일요일을 포함하는 첫 번째 주 1 .. 53
			mode : 5 Week 1은 월요일을 포함하는 첫 번째 주 0 .. 53
			mode : 7 Week 1은 월요일을 포함하는 첫 번째 주 1 .. 53
		*/

		$this->ci->load->model('date_function_m');
		$weeks = $this->ci->date_function_m->get_whatweek($sdate, $mode);

		return $weeks;
	}

	function whatday($sdate) {

		/* 1 : 일요일, 2 : 월요일, ~ 7 : 토요일 */

		$this->ci->load->model('date_function_m');
		$day = $this->ci->date_function_m->get_whatday($sdate);

		return $day;
	}

	function whatquarter($sdate) {

		$this->ci->load->model('date_function_m');
		$quarter = $this->ci->date_function_m->get_quarter($sdate);

		return $quarter;
	}

	/* 두 날짜 사이의 차이를 초로 환산함 */
	/* 형식은 yyyy-mm-dd H:i:s */
	function get_timediff($time1, $time2)
	{
		$this->ci->load->model('date_function_m');
		$second = $this->ci->date_function_m->get_diff_second($time1, $time2);

		return $second;
	}



}
/* End of file */