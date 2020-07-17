<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//메세지 출력 후 이동
function alert($msg='이동합니다', $url='') 
{
	echo "
		<script type='text/javascript'>
			alert('".$msg."');
			location.replace('".$url."');
		</script>
	";
	exit;
}

// 창닫기
function alert_close($msg) 
{
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); window.close(); </script>";
	exit;
}

// 경고창 만
function alert_only($msg, $exit=TRUE) 
{
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	if ($exit) exit;
}

// 경고 후 이전페이지로 이동
function alert_back($msg, $exit=TRUE) 
{
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); history.go(-1); </script>";

	if ($exit) exit;
}

function replace($url='/') {
	echo "<script type='text/javascript'>";
    if ($url)
        echo "window.location.replace('".$url."');";
	echo "</script>";
	exit;
}

function alert_error($errors){
	$html = '<div id="AlertArea" class="AlertArea">';
	foreach($errors as $err){
		$html .= "<div class=\"AlertArea__item AlertArea__danger\" role=\"alert\"><span>{$err}</span></div>";
	}
	$html .="</div>";
	return $html;
}

function alert_layer($msg, $url=''){
	$html = "";
	$html .= "<div class=\"Dialog\">";
	$html .= "<div class=\"Dialog__msg\">저장되었습니다.</div>";
	$html .= "</div>";
	echo $html;
	echo "
		<script type='text/javascript'>
			setTimeout(function(){
				location.replace('".$url."');
			},1000);
		</script>
	";
}

/* End of file */