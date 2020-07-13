<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
		<form action="" class="Form">
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_id">관리번호</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo set_value($view, 're_id')?>" id="re_id" />
				</div>
			</div>			
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">제조사</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo set_value($view, 're_mf')?>" id="re_mf" />
				</div>
			</div>
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_pr_name">제품명</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo set_value($view, 're_pr_name')?>" id="re_pr_name" />
				</div>
			</div>
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">위탁업무</label>
				</div>
				<div class="Form__data">
					<?php echo ft_dropdown_box('ta_idx', $task_array, array(set_value($view, 'ta_idx')),20); ?>
				</div>
			</div>
						
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_grade">등급</label>
				</div>
				<div class="Form__data">
					<?php echo ft_dropdown_box('re_grade', $grade_array, array(set_value($view, 're_grade'))); ?>
				</div>
			</div>


			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">품목분류</label>
				</div>
				<div class="Form__data">
					<?php echo ft_dropdown_box('rc_idx', $ra_array, array(set_value($view, 'rc_idx')), 30); ?>
					<a href="#" class="Button Button__basic">품목선택</a>
				</div>
			</div>			
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">품목명</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo set_value($view, 'rg_title')?>" size="30" />
				</div>
			</div>
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">위탁일</label>
				</div>
				<div class="Form__data">
					<input type="text" class="datepicker" value="<?php echo set_value($view, 're_contracted_at')?>" />
				</div>
			</div>
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">종료일</label>
				</div>
				<div class="Form__data">
					<input type="text" class="datepicker" value="<?php echo set_value($view, 're_ended_at')?>" />
				</div>
			</div>
			<!-- <div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">담당자</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo set_value($view, 'cu_manager')?>" />				
				</div>
			</div>
			<div class="Form__group">
				<div class="Form__label">
				<label for="re_mf">연락처</label>
				</div>
				<div class="Form__data">
					<input type="text" value="<?php echo set_value($view, 'cu_tel')?>" />
				</div>
			</div> -->
		</form>
		<div class="pt10"></div>
		<div class="Button__group right">
			<a href="<?php echo $this->list_href ?>" class="Button Button__basic">목록</a>
			<a href="<?php echo $this->list_href ?>" class="Button Button__create">등록</a>
		</div>
	</div>
</main>