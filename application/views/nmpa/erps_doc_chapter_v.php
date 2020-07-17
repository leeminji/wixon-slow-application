<main class="Page">
	<div class="Page__inner">
        <!-- <div class="Page__setting">
            <button class="Button Button__icon">Setting</button>
        </div> -->
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text">NMPA 업무등록</p>
		</div>
		<div class="pt10"></div>
		<form action="" class="Form">
			<div class="Form__group">
				<div class="Form__label">
					<label for="ta_idx">분류선택</label>
				</div>
				<div class="Form__data">
					<?php echo $task_select ?>
					<button class="Button Button__basic"><span>검색</span></button>
				</div>
			</div>
		</form>
		<div class="pt10"></div>
		<form class="Form" id="ChapterForm">
			<input type="hidden" name="ta_default" value="<?php echo $ta_default ?>">
			<!-- Draggable -->
			<div class="Draggable" id="tbl_erps_chapter">
				<div class="Draggable__title">
					<div class="Draggable__list">
						<div class="Draggable__item">
							<span class="col col1">NO</span>
							<span class="col col1">CH</span>
							<span class="col col2">제출문서목록</span>
							<span class="col col3">작업</span>
						</div>
					</div>
				</div>
				<div class="Draggable__body bg01">
					<div class="Draggable__list">
						<div class="Draggable__item">
							<span class="col col1">등록</span>
							<span class="col col1"><input type="text" name="nc_title_new" size="100" placeholder="CH" /></span>
							<span class="col col2">
								<input type="text" size="100" placeholder="목록" name="nc_name_new" />
							</span>
							<span class="col col3">
								<a href="javascript:;" class="Button Button__basic" id="BtnSubmit"><span>등록</span></a>
							</span>
						</div>
					</div>
				</div>
				<div class="Draggable__body">
					<div class="Draggable__list" id="ChapterList">
						<?php foreach($chapter_list as $ls){ ?>
						<div class="Draggable__item">
							<input type="hidden" name="nc_idx[]" value="<?php echo $ls->nc_idx ?>">
							<span class="col col1"><?php echo ($ls->nc_num)+1 ?></span>
							<span class="col col1"><input type="text" value="<?php echo $ls->nc_title?>" size="100" name="nc_title[]" /></span>
							<span class="col col2">
								<input class="InputText" type="text" value="<?php echo $ls->nc_name?>" size="100" name="nc_name[]" />
							</span>
							<span class="col col3">
								<a href="javascript:;" class="Button Button__basic BtnUpdate"><span>수정</span></a>
								<a href="javascript:;" class="Button Button__update BtnDelete"><span>삭제</span></a>
							</span>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="Draggable__bottom">
					<a href="javascript:;" class="Button Button__basic" id="BtnOrder"><span>순서수정</span></a>
				</div>
			</div>
			<!-- //Draggable -->
		</form>
	</div>
</main>

<script>
	$(document).ready(function(){
		chatper.init();
	});

	var chatper = {
		url : "/nmpa/erps_doc/chapter",
		init : function(){
			var that = this;
			$("#BtnSubmit").on('click', function(e){
				e.preventDefault();
				that.insert();
			});

			$("#ChapterList").children("div").each(function(){
				var item = $(this);
				item.on('click', ".BtnUpdate", function(e){
					var data = {
						'nc_title' : item.find('[name="nc_title[]"]').val(),
						'nc_name' : item.find('[name="nc_name[]"]').val(),
						'nc_idx' : item.find('[name="nc_idx[]"]').val(),
					};
					that.update(data);
				});
				item.on("click", ".BtnDelete", function(e){
					var data = {
						'nc_idx' : item.find('[name="nc_idx[]"]').val(),
					};
					item.remove();
					that.delete(data);
				});
			});
			$("#ChapterList").sortable({
				"ui-sortable": "highlight",
				axis : "y",
				cancel: "a,button,input",
				cursor: "move",
				items: "> div"
			});
			$("#BtnOrder").on("click", function(e){
				e.preventDefault();
				that.order_change();
			});
		},
		order_change : function(){
			var that = this;
			var form_data = $("#ChapterForm").serialize();
			$.ajax({
				url : that.url+"/order",
				type : "POST",
				data : form_data,
				success : function(data){
					alert(data.msg);
					window.location.reload();
				}
			})
		},
		insert : function(){
			var that = this;
			var form_data = $("#ChapterForm").serialize();
			$.ajax({
				url : that.url+"/write",
				type : "POST",
				data : form_data,
				success : function(data){
					alert(data.msg);
					window.location.reload();
				}
			})
		},
		update : function(data){
			var that = this;
			$.ajax({
				url : that.url+"/update",
				type : "POST",
				data : data,
				success : function(data){
					alert(data.msg);
				}
			})		
		},
		delete : function(data){
			var that = this;
			$.ajax({
				url : that.url+"/delete",
				type : "POST",
				data : data,
				success : function(data){
					alert(data.msg);
					that.order_change();
				}
			})		
		}
	}
</script>