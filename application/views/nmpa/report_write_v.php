<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
		<?php echo alert_error($errors); ?>
		<?php 
			$attr = array('class' => 'Form', 'id'=>'frm');
			echo form_open('', $attr); 
		?>
			<?php if($this->state == 'update'){ ?>
			<input type="hidden" name="re_idx" value="<?php echo $view->re_idx?>" />
			<?php } ?>
			<div class="Form__group">
				<div class="Form__label">
				<label for="mb_idx">업체선택</label>
				</div>
				<div class="Form__data">
					<?php echo ft_dropdown_box('mb_idx', $member_array, array(ft_set_value($view, 'mb_idx')),20); ?>
				</div>
			</div>		
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_id">관리번호</label>
				</div>
				<div class="Form__data">
					<?php if($this->state == 'write'){ ?>
						<input type="text" name="re_id" size="6" value="<?php echo ft_set_value($view, 're_id')?>" readonly="readonly" />
						<span class="unit">-</span>
						<input type="text" name="re_id_add" size="5" value="<?php echo ft_set_value($view, 're_id_add')?>" />
						<a href="javascript:;" onclick="report.getDocId();" class="Button Button__basic">관리번호생성</a>
					<?php }else{ ?>
						<input type="text" value="<?php echo ft_set_value($view, 're_id')?>" name="re_id" readonly='readonly' size="20" />
					<?php } ?>
				</div>
			</div>		

			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">제조사</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo ft_set_value($view, 're_mf')?>" id="re_mf" name="re_mf" />
				</div>
			</div>

			<div class="Form__group">
				<div class="Form__label">
				<label for="re_pr_name">제품명</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo ft_set_value($view, 're_pr_name')?>" id="re_pr_name" name="re_pr_name" />
				</div>
			</div>

			<div class="Form__group">
				<div class="Form__label">
				<label for="ta_idx">위탁업무</label>
				</div>
				<div class="Form__data" id="TaskSelect">
					<?php echo ft_dropdown_box('ta_idx', $task_array, array(ft_set_value($view, 'ta_idx')),30); ?>
				</div>
			</div>
			<div id="TaskInfo"></div>
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_contracted_at">위탁일</label>
				</div>
				<div class="Form__data">
					<input type="text" class="datepicker" id="re_contracted_at" name="re_contracted_at" value="<?php echo ft_set_value($view, 're_contracted_at', true)?>" />
				</div>
			</div>

			<div class="Form__group">
				<div class="Form__label">
				<label for="re_ended_at">종료일</label>
				</div>
				<div class="Form__data">
					<input type="text" class="datepicker" name="re_ended_at" id="re_ended_at" value="<?php echo ft_set_value($view, 're_ended_at', true)?>" />
				</div>
			</div>

			<div class="pt10"></div>

			<div class="Button__group right">
				<a href="<?php echo $this->list_href?>" class="Button Button__basic">목록</a>
				<a href="javascript:;" class="Button Button__delete" id="btnDelete">삭제</a>
				<button type="submit" class="Button Button__create">등록</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</main>
<div class="Modal size_sm" id="GradeList"></div>
<script>
	$(document).ready(function(){
		report.init();
	});	
	var report = {
		viCateIdx : null,
		grade : null,
		raCateIdx : 5,
		taskIdx : null,
		init : function(){
			this.reportIdx = $("[name='re_idx']").val();

			this.event_control();
			this.task_info();
		},
		event_control : function(){
			var that = this;

			var taskSelect = $("#TaskSelect select");
			if( this.reportIdx == null ){
				//위탁업무 선택시 변경
				taskSelect.off("change").on("change", function(e){
					that.taskIdx = $(this).val();
					that.task_info();
				});				
			}else{
				taskSelect.off('change').attr('readonly','readonly');
			}

			//삭제
			$("#btnDelete").off("click").on("click", function(){
				var form = $("#frm");
				if( confirm("삭제하시겠습니까?") ){
					form.attr("action", "/nmpa/report/delete/49");
					form.submit();
				}
			});
		},
		event_select : function(){
			var that = this;
			//등급선택시 변경
			$("#GradeSelect select").off("change").on("change", function(e){
				that.grade = $(this).val();
				that.task_info();
			});
		},
		//관리번호생성
		getDocId : function(){
			$.ajax({
				url : "/nmpa/report/create_doc_id",
				type : "GET",
				success : function(data){
					$("[name='re_id']").val(data.doc_id);
				}
			});			
		},
		//의료기기품목분류
		ra_open : function(){
			var that = this;
			that.raCateIdx = $("select[name='rc_idx']").val();
			//console.log(that.raCateIdx);
			$.ajax({
				url : "/ref/ra_category/grade_list",
				data : {
					"rc_idx" : that.raCateIdx,
				},
				type : "GET",
				success : function(res){
					uiModal.open('GradeList',res);
					that.get_ra_grade();
				}
			});
		},
		//의료기기품목분류 가져오기
		get_ra_grade : function(){
			var that = this;
			var item = $("#GradeList").find(".InputList__item");
			item.each(function(index){
				var _item = $(this);
				$(this).off("click").on("click", ".Button", function(e){
					e.preventDefault();

					var rg_idx = _item.find('[name="rg_idx[]"]').val();
					var rg_title = _item.find('[name="rg_title[]"]').val();
					
					//의료기기품목분류 적용
					$("[name='rg_idx']").val(rg_idx);
					$("[name='re_rank_2']").val(rg_title);
					uiModal.close('GradeList');
				});
			});
		},
		//체외진단제품목분류
		vi_open : function(){
			var that = this;
			that.viCateIdx = $("select[name='vc_idx']").val();
			$.ajax({
				url : "/ref/vi_category/detail_list",
				data : {
					"vc_idx" : that.viCateIdx,
					"rg_grade" : that.grade,
				},
				type : "GET",
				success : function(res){
					uiModal.open('GradeList',res);
					that.get_vi_detail();
				}
			});
		},
		//의료기기품목분류 가져오기
		get_vi_detail : function(){
			var that = this;
			var item = $("#GradeList").find(".InputList__item");
			item.each(function(index){
				var _item = $(this);
				$(this).off("click").on("click", ".Button", function(e){
					e.preventDefault();

					var idx = _item.find('[name="vd_idx[]"]').val();
					var title = _item.find('[name="vd_name[]"]').val();
					
					//의료기기품목분류 적용
					$("[name='vd_idx']").val(idx);
					$("[name='re_rank_2']").val(title);

					uiModal.close('GradeList');
				});
			});
		},
		//위탁업무 클릭시 의료기기, 체외진단제 구분 및 해당등급 가져오기 
		task_info : function(){
			var that = this;
			$.ajax({
				url : "/nmpa/report/info",
				data : {
					"ta_idx" : that.taskIdx,
					"re_idx" : $("[name='re_idx']").val(),
					"re_grade" : that.grade
				},
				type : "GET",
				success : function(data){
					$("#TaskInfo").empty().append(data);
					that.event_select();
				}
			});			
		}
	}
</script>