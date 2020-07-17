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
				<option value="mb_id" <?php if($this->sfl == 'mb_id') echo "selected"; ?>  >아이디</option>
				<option value="mb_name" <?php if($this->sfl == 'mb_name') echo "selected"; ?> >이름</option>
			</select>
			<label for="stx" class="skip">검색어입력</label>
			<input type="text" placeholder="검색어입력" name="stx" id="stx" value="<?php echo $this -> stx;?>">
			<button type="submit" class="Button Button__basic">검색</button>
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
				<a class='<?php echo $this->mb_level == "" ? "Button Button__update" : "Button Button__basic"; ?> ' href="<?php echo $this->list_href?>">전체 (<?php echo $count_total_member ?>명)</a>

				<?php foreach( $level_list as $ls ){ ?>
				<a class='<?php echo $this->mb_level == $ls->ml_idx ? "Button Button__basic" : "Button Button__basic"; ?>' href="<?php echo $this->list_href?>?mb_level=<?php echo $ls->ml_idx ?>"><?php echo $ls->ml_name ?>(<?php echo $ls->ml_count ?>명)</a>
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
					<col style="width:10em" />
					<col style="width:10em" />
				</colgroup>
				<thead>
					<tr>
					<th scope="col">번호</th>
					<th scope="col">아이디</th>
					<th scope="col">이름</th>
					<th scope="col">이메일</th>
					<th scope="col">부서</th>
					<th scope="col">권한</th>
					<th scope="col">접속일</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($list as $lt){ ?>
					<tr <?php echo $lt -> mb_state == 0 ? "class='warning'" : "" ?> >
					<td><?php echo $lt->num; ?></td>
					<td class="left"><a class="link" href="<?php echo $lt -> link; ?>"><?php echo $lt -> mb_id; ?></a></td>
					<td><?php echo $lt -> mb_name; ?></td>
					<td class="left"><?php echo $lt -> mb_email; ?></td>
					<td><?php echo $lt->mg_name; ?></td>
					<td><?php echo $lt->ml_name; ?></td>
					<td><?php echo date("Y-m-d", strtotime($lt -> mb_regdate)); ?></td>
					</tr>
					<?php } ?>
					<?php if( count($list) == 0 ) echo "<tr><td colspan='8' class='empty'>no data</td></tr>"; ?>
				</tbody>
			</table>
		</div>
		<!-- //board-list -->
		<!-- pagination -->
		<nav class="text-center">
			<ul class="Pagination">
			<?php echo $pagination; ?>
			</ul>
		</nav>
		<!-- pagination -->	
	</div>
</main>

<div class="Modal size_xs" id="LevelSetting" tabindex="-1"></div>
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
				thisObj.get_level();
			});			
		},
		//회원권한
		get_level : function(){
			var that = this;
			$.ajax ({
				method : "GET",
				dataType : "html",
				url : that.url+"/level",
				success : function(data){
					uiModal.open("LevelSetting", data);

					//권한이름 수정
					$("#BtnSubmit").on("click", function(e){
						e.preventDefault();
						that.post_level();
					});
				}
			});
		},
		post_level : function(){
			var that = this;
			$.ajax({
				type : "POST",
				data : $("#frmLevel").serialize(),
				url : that.url+"/level",
				dataType : "json"
			}).done(function(data){
				//alert(data.msg);
				uiModal.close("LevelSetting");
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