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
				<div class="Form__data">
					<?php echo ft_dropdown_box('ta_idx', $task_array, array(ft_set_value($view, 'ta_idx')),30); ?>
				</div>
			</div>
						
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_grade">등급</label>
				</div>
				<div class="Form__data">
					<?php echo ft_dropdown_box('re_grade', $grade_array, array(ft_set_value($view, 're_grade'))); ?>
				</div>
			</div>

			<div class="Form__group">
				<div class="Form__label">
				<label for="rc_idx">품목분류</label>
				</div>
				<div class="Form__data">
					<?php echo ft_dropdown_box('rc_idx', $ra_array, array(ft_set_value($view, 'rc_idx')), 30); ?>
					<a href="javascript:;" onclick="report.ra_open();" class="Button Button__basic">품목선택</a>
				</div>
			</div>

			<div class="Form__group">
				<div class="Form__label">
				<label for="rg_title">품목명</label>
				</div>
				<div class="Form__data">
					<input type="hidden" name="rg_idx" value="<?php echo ft_set_value($view, 'rg_idx')?>">
					<input type="text" name="rg_title" readonly='readonly' value="<?php echo ft_set_value($view, 'rg_title')?>" size="100" />
				</div>
			</div>

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
				<button type="submit" class="Button Button__create">등록</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</main>
<div class="Modal size_sm" id="GradeList"></div>
<script>
	var report = {
		raCateIdx : 5,
		getDocId : function(){
			$.ajax({
				url : "/nmpa/report/create_doc_id",
				type : "GET",
				success : function(data){
					$("[name='re_id']").val(data.doc_id);
				}
			});			
		},
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
		get_ra_grade : function(){
			var that = this;
			var item = $("#GradeList").find(".InputList__item");
			item.each(function(index){
				var _item = $(this);
				$(this).off("click").on("click", ".Button", function(e){
					e.preventDefault();
					var rg_idx = _item.find('[name="rg_idx[]"]').val();
					var rg_title = _item.find('[name="rg_title[]"]').val();
					
					that.set_ra_grade(rg_idx, rg_title);
					uiModal.close('GradeList');
				});
			});
		},
		set_ra_grade : function(rg_idx, rg_title){
			$("[name='rg_idx']").val(rg_idx);
			$("[name='rg_title']").val(rg_title);
		}
	}
</script>