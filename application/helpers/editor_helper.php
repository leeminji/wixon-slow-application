<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /*
     *  $name : textarea name, id
     *  $content : 값
     * */
	function ed_create_editor($name, $content=''){
		$CI = &get_instance();
		$html = "";
		$html .= "<textarea name='".$name."' id='".$name."' rows='10' cols='80'>".$content."</textarea>".PHP_EOL;
		$html .= "<script type='text/javascript'>".PHP_EOL;
		$html .= "$(document).ready(function(){".PHP_EOL;
		$html .= "var editor = null;".PHP_EOL;
		$html .= "editor = CKEDITOR.replace( '".$name."' , {".PHP_EOL;
		$html .= "		height:500, ";
		$html .= "		filebrowserBrowseUrl: '/uploader/browse', filebrowserUploadUrl: '/uploader/upload'".PHP_EOL;
		$html .= "});".PHP_EOL;
		$html .= "editor.on('instanceReady', function(e){
		});".PHP_EOL;
		$html .= "});".PHP_EOL;
		$html .= "</script>".PHP_EOL;

		return $html;
	}
	
    /* 폼을 넘길때 꼭 필요. */
	function ed_update_editor($name){
		return "CKEDITOR.instances.{$name}.updateElement();".PHP_EOL;
	}

	/* 체크 */
	function edit_radio($name, $value, $input=""){
		$is_checked = "";
		if($input != "" && $value == $input ){
			$is_checked = "checked";
		}
		$result = "<label>";
		$result .= "<input type='radio' name='".$name."' value='".$value."' ".$is_checked." />";
		$result .= "<span class='".$value."'></span>";
		$result .= "</label>";

		return $result;
	}
	
	/* 에디터 이미지 얻기 */
	function ed_get_editor_image($content){
	    if( !$content ) return false;
	    $pattern = "/<img[^>]*src=[\'\"]?([^>\'\"]+[^>\'\"]+)[\'\"]?[^>]*>/i";
	    preg_match_all($pattern, $content, $matchs);
	    return $matchs;
	}
	
	/* 에디터 이미지 삭제 */
	function ed_delete_editor_image($content){
	    if( !$content ) return false;
	    $matchs = get_editor_image($content);
	    for( $i=0;$i<count($matchs[1]); $i++ ){
	        $imgurl = @parse_url($matchs[1][$i]);
	        $srcfile = $_SERVER['DOCUMENT_ROOT'].$imgurl['path'];
	        if( is_file($srcfile) ){
	           unlink($srcfile);
	        }
	    }
	}
	
?>
