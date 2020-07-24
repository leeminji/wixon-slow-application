<main class="Page">
	<div class="Page__inner">
        <!-- <div class="Page__setting">
            <button class="Button Button__icon">Setting</button>
        </div> -->
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
		<?php echo alert_error($errors); ?>
        <div class="Layout__row">
            <div class="Layout__col4">
				<?php echo form_open('', array("class"=>'Form')); ?>
					<div class="Form__group">
						<div class="Form__label">
						<label for="">분류선택</label>
						</div>
						<div class="Form__data">
						<?php echo $default_select; ?>
						</div>
					</div>
					<div class="Form__group">
						<div class="Form__label">
						<label for="">업무타입</label>
						</div>
						<div class="Form__data">
						<?php echo $type_select; ?>
						</div>
					</div>
					<div class="Form__group">
						<div class="Form__label">
						<label for="">등급</label>
						</div>
						<div class="Form__data">
						<?php echo $grade_check; ?>
						</div>
					</div>
					<div class="Form__group">
						<div class="Form__label">
						<label for="ta_task">업무명</label>
						</div>
						<div class="Form__data">
						<input type="text" size="100" name="ta_task" id="ta_task" value="<?php echo set_value('ta_task'); ?>" />
						</div>
					</div>					
					<div class="Form__button">
						<button type="submit" class="Button Button__basic">등록</button>
					</div>
				<?php echo form_close() ?>
			</div>
			<div class="Layout__col8">
				<div class="TableStyle__1">
				<table>
					<colgroup>
						<col style="width:4em">
						<col style="width:10em">
						<col style="width:8em">
						<col style="width:12em">
						<col>
						<col style="width:10em">
					</colgroup>
					<thead>
						<tr>
							<th>NO</th>
							<th>분류</th>
							<th>등급</th>
							<th>업무종류</th>
							<th>업무명</th>
							<th>등록</th>
						</tr>
					</thead>
					<tbody id="taskList">
						<?php 
						$i=1;
						foreach($task_list as $lt){ ?>
						<tr>
							<td><input type="hidden" name="ta_idx[]" value="<?php echo $lt->ta_idx ?>"><?php echo $i ?></td>
							<td><?php echo $lt->ta_default ?></td>
							<td><?php echo $lt->ta_grade ?></td>
							<td><?php echo $lt->ta_type ?></td>
							<td class='left'><input type="text" value="<?php echo $lt->ta_task ?>" size="100"></td>
							<td>
								<a href="javascript:;" class="Button Button__basic"><span>수정</span></a>
								<a href="javascript:;" class="Button Button__basic Button_delete"><span>삭제</span></a>
							</td>
						</tr>
						<?php $i++; }?>
					</tbody>
				</table>		
			</div>
		</div>
	</div>
</main>

<script>
	$(document).ready(function(){
		erpTask.init();
	});
	var erpTask = {
		init : function(){
			this.event_control();
		},
		event_control : function(){
			var that = this;
			$("#taskList tr").each(function(){
				var item = $(this);
				$(this).on("click", ".Button_delete", function(){
					var data = {
						ta_idx : item.find("[name='ta_idx[]']").val()
					};
					that.delete(data);
				})
			});
		},
		delete : function(_data){
			$.ajax({
				type :"POST",
				url : "/nmpa/erps_task/ajax_delete",
				data : _data,
				success : function(data){
					alert(data.msg);
				}
			})
		}
	}

</script>