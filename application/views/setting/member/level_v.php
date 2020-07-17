<form id="frmLevel">
	<ul class="InputList clearfix">
		<?php foreach ( $level_list as $le ){ ?>
		<li class="InputList__item">
			<input type="hidden" name="ml_idx[]" value="<?php echo $le->ml_idx; ?>" />
			<div class="InputList__item__group">
				<div class="InputList__title"><?php echo $le->ml_idx; ?></div>
				<div class="InputList__data">
					<input type="text" name="ml_name[]" value="<?php echo $le->ml_name; ?>" />
				</div>
			</div>
		</li>
		<?php } ?>
	</ul>
	<div class="Button__group right">
		<a href="javascript:;" onclick="uiModal.close();" class="Button Button__basic">목록</a>
		<a href="javascript:;" id="BtnSubmit" class="Button Button__create">회원 권한 수정</a>
	</div>
</form>