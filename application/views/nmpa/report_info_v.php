
<div class="Form__group">
	<div class="Form__label">
	<label for="re_grade">등급</label>
	</div>
	<div class="Form__data" id="GradeSelect">
		<div class="SelectBox" style="width:10em">
			<select name="re_grade" id="re_grade">
				<?php foreach($grade_list as $gl){
					$is_selected = ft_set_value($view, 're_grade') == $gl ? "selected" : "";
					echo "<option value='{$gl}' {$is_selected}>{$gl}등급</option>";
				}?>
			</select>
		</div>
	</div>
</div>
<!-- 의료기기 -->
<?php if($task->ta_default == "TND01"){ ?>
<div class="Form__group">
	<div class="Form__label">
	<label for="rc_idx"><span class="skip">의료기기</span>품목분류</label>
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
		<input type="text" name="re_rank_2" readonly='readonly' value="<?php echo ft_set_value($view, 're_rank_2')?>" size="100" />
	</div>
</div>
<?php } ?>
<!-- //의료기기 -->
<!-- 체외진단제 -->
<?php if($task->ta_default == "TND02"){ ?>
<div class="Form__group">
	<div class="Form__label">
	<label for="rc_idx"><span class="skip">체외진단제</span>품목분류</label>
	</div>
	<div class="Form__data">
		<?php echo ft_dropdown_box('vc_idx', $vi_array, array(ft_set_value($view, 'vc_idx')), 30); ?>
		<a href="javascript:;" onclick="report.vi_open();" class="Button Button__basic">품목선택</a>
	</div>
</div>
<div class="Form__group">
	<div class="Form__label">
	<label for="rg_title">품목명</label>
	</div>
	<div class="Form__data">
		<input type="hidden" name="vd_idx" value="<?php echo ft_set_value($view, 'vd_idx')?>">
		<input type="text" name="re_rank_2" readonly='readonly' value="<?php echo ft_set_value($view, 're_rank_2')?>" size="100" />
	</div>
</div>
<?php } ?>
<!-- //체외진단제 -->