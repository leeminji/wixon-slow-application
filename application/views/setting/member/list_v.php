<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $title?></h1>
			<p class="Location__text">회원에 대한 설정을 적용할 수 있습니다</p>
		</div>
		<div class="pt10"></div>
		<div>
			<form class="form-inline" action="<?php echo $this->list_href; ?>" method="get" onsubmit="return boardSearch(this)">
			<select name="sfl" id="sfl" >
				<option value="mb_id" <?php if($this -> sfl == 'mb_id') echo "selected"; ?>  >아이디</option>
				<option value="mb_name" <?php if($this -> sfl == 'mb_name') echo "selected"; ?> >이름</option>
			</select>
			<label for="stx" class="skip">검색어입력</label>
			<input type="text" class="form-control" placeholder="검색어입력" name="stx" id="stx" value="<?php echo $this -> stx;?>">
			<button type="submit" class="col-xs-12 btn btn-primary">검색</button>
			</form>
		</div>
		<div class="pt10"></div>
		<!-- button_area -->
		<div class="clearfix">
			<div class="float_left">
				<span class="RadiusBox RadiusBox__baisc">
					총 회원수 <strong><?php echo $count_total_member ?>명</strong>, 
					탈퇴 <strong><?php echo $count_out_member ?>명</strong>
				</span>
				<a class='<?php echo $mb_level == "" ? "Button Button__basic" : "Button Button__basic"; ?> ' href="<?php echo $this->list_href?>"  >전체 (<?php echo $count_total_member ?>명)</a>
				<a class='Button Button__basic' href="<?php echo $this->list_href?>?stx=0&sfl=mb_state"  >탈퇴회원 (<?php echo $count_out_member ?>명)</a>
				<?php foreach( $level as $le ){ ?>
				<a class='<?php echo $mb_level == $le->ml_idx ? "Button Button__basic" : "Button Button__basic"; ?>' href="<?php echo $this->list_href?>?mb_level=<?php echo $le->ml_idx ?>" ><?php echo $le->ml_name ?>(<?php echo $le->cnt ?>명)</a>
				<?php } ?>				
			</div>
			<div class="float_right">
				<a class="Button <?php echo $this->sst=='mb_regdate' ? "Button__update" : "Button__basic"; ?>"  href="<?php echo $this->list_href?><?=$q?>&sst=mb_regdate&sod=desc">최신순</a>
				<a class="Button <?php echo $this->sst=='mb_name' ? "Button__update" : "Button__basic"; ?>" href="<?php echo $this->list_href?><?=$q?>&sst=mb_name&sod=desc">이름순</a>
				<button type="button" id="BtnLevel" class="Button Button__update">회원권한설정</button>
				<a href="<?php echo $this->write_href; ?>" class="Button Button__basic">등록</a>				
			</div>
		</div>
		<div class="pt10"></div>		
		<!-- board-list -->
		<div class="TableStyle__1">
			<table class="">
				<colgroup>
					<col style="width:5em" />
					<col style="width:10em" />
					<col style="width:10em" />
					<col />
					<col style="width:10em" />
					<col style="width:8em" />
				</colgroup>
				<thead>
					<tr>
					<th scope="col">번호</th>
					<th scope="col">아이디</th>
					<th scope="col">이름</th>
					<th scope="col">이메일</th>
					<th scope="col">접속일</th>
					<th scope="col">권한</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($list as $lt){ ?>
					<tr <?php echo $lt -> mb_state == 0 ? "class='warning'" : "" ?> >
					<td><?php echo $lt->num; ?></td>
					<td class="text-left"><a class="link" href="<?php echo $lt -> link; ?>"><?php echo $lt -> mb_id; ?></a></td>
					<td><?php echo $lt -> mb_name; ?></td>
					<td class="text-left"><?php echo $lt -> mb_email; ?></td>
					<td><?php echo date("Y-m-d", strtotime($lt -> mb_regdate)); ?></td>
					<td><?php echo $this-> level_m -> get_level_name ($lt -> mb_level) ?></td>
					</tr>
					<?php } ?>
					<?php if( count($list) == 0 ) echo "<tr><td colspan='7'>no data</td></tr>"; ?>
				</tbody>
			</table>
		</div>
		<!-- //board-list -->
		<!-- pagination -->
		<nav class="text-center">
			<ul class="pagination">
			<?php echo $pagination; ?>
			</ul>
		</nav>
		<!-- pagination -->	
	</div>
</main>

<div class="Modal" id="modal-content" tabindex="-1"></div>
<script type="text/javascript">
	$(document).ready(function(){
		Member.init();
	});
	var Member = {
		url : "/setting/member",
		init : function(){
			var thisObj = this;
			//회원권한
			$("#BtnLevel").on("click", function(e){
				e.preventDefault();
				thisObj.levelGET();
			});			
		},
		//회원권한
		levelGET : function(){
			var thisObj = this;
			$.ajax ({
				method : "GET",
				dataType : "html",
				url : thisObj.url+"/json_level",
				success : function(data){
					$("#modal-content").empty().append(data);
					$("#modal-content").addClass('active');

					//권한이름 수정
					$("#BtnSubmit").on("click", function(e){
						e.preventDefault();
						thisObj.levelPOST();
					});
				}
			});
		},
		levelPOST : function(){
			var thisObj = this;
			$.ajax({
				type : "POST",
				data : $("#frmLevel").serialize(),
				url : thisObj.url+"/json_level",
				dataType : "json"
			}).done(function(data){
				$("#modal-content").removeClass('active');
				alert(data.data);
				
				//권한이름 변경때문에 다시 리로드 필요.
				window.location.reload();
			});
		}
	}
	
	//검색
	function boardSearch(f){
		var action = f.action;
		if( f.stx.value == '' ){
			alert("검색어를 입력해주세요");
			f.stx.focus();
			return false;
		}
		f.action = action;
		return true;
	}
	
</script>