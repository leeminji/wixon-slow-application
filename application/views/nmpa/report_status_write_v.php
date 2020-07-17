<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $title; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt10"></div>
		<div>
			업무 : <?php echo $report_view->ta_task ?>
		</div>
		<div class="pt10"></div>
		<?php 
			$attr = array('class' => 'form', 'id'=>'frm');
			echo form_open('', $attr);
		?>
		<input type="hidden" name="re_idx" value="<?php echo $this->re_idx; ?>">
		<div class="TableStyle__1">
			<table>
				<colgroup>
					<col style="width:12em">
					<col>
					<col style="width:6em">
				</colgroup>
				<thead>
					<tr>
						<th>진행</th>
						<td>분류</td>
						<td>상황</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>1. 사전준비</th>
						<td>
							<div class="StepList">
							<ul class="StepList__list">
								<li class="StepList__item active"><a href="">기술요구 작성</a></li>
								<li class="StepList__item"><a href="">서류번역</a></li>
								<li class="StepList__item active"><a href="">등록검사</a>
									<ul class="StepList__list">
										<li class="StepList__item"><a href="">등록/보완 검사 위탁</a></li>
										<li class="StepList__item"><a href="">시료 발송</a></li>
										<li class="StepList__item"><a href="">결재</a></li>
									</ul>
								</li>
								<li class="StepList__item"><a href="">임상시험</a></li>
							</ul>
							</div>
						</td>
						<td>
							<select name="" id="">
								<option value="">진행</option>
								<option value="">종료</option>
						</select>
						</td>
					</tr>
					<tr>
						<th>2. eRPS</th>
						<td>
							<input type="hidden" name="nr_idx_array" value="<?php echo ft_set_value($status_view ,'nr_idx_array')?>" />
							<div class="pt10"></div>
							<div id="RpsTotalList" class="Layer__content">
								<div class="Layer__loading"></div>	
							</div>
							<div class="pt10"></div>
						</td>
						<td>
							<select name="" id="">
								<option value="">진행</option>
								<option value="">종료</option>
							</select>
						</td>	
					</tr>
					<tr>
						<th>3. 심사평가 및 승인</th>
						<td></td>
						<td>
							<select name="" id="">
								<option value="">진행</option>
								<option value="">종료</option>
							</select>
						</td>	
					</tr>
				</tbody>
			</table>
		</div>
		<div class="pt10"></div>
		<div class="Button__group right">
			<button type="submit" class="Button Button__create"><span>저장</span></button>
			<a href="/nmpa/report/49" class="Button Button__basic"><span>목록</span></a>
		</div>
		<?php echo form_close(); ?>
	</div>
</main>

<script>
	$(document).ready(function(){
		reportStatus.taskIdx = <?php echo $report_view->ta_idx?>;
		reportStatus.init();
	});
	var reportStatus = {
		cateIdx : 1,
		taskIdx : 1,
		idxArray : [],
		init : function(){
			var idxArrayValue = $("[name='nr_idx_array']").val().trim();
			if( idxArrayValue != "" ){
				this.idxArray = idxArrayValue.split(',');
			}
			this.rps_open();
		},
		rps_open : function(_ta_idx){
			var that = this;
			if(_ta_idx){
				that.taskIdx = _ta_idx;
			}
			$.ajax({
				url : "/nmpa/erps_doc/rps_total_list",
				data : {
					"ta_idx" : that.taskIdx,
					"nc_idx" : that.cateIdx
				},
				type : "GET",
				success : function(res){
					uiModal.open('RpsTotalList',res);
					that.set_rps_list();
					that.get_rps_list();
				}
			});
		},
		rps_open_category : function(_nc_idx){
			this.cateIdx = _nc_idx;
			this.rps_open();
		},
		get_rps_list : function(){
			var that = this;
			$("#RpsTotalList input[name='nr_idx[]']").off("change").on("change", function(){
				if($(this).is(":checked")){
					that.idxArray.push($(this).val());
				}else{
					var index = that.idxArray.indexOf($(this).val());
					if( index > -1 ){
						that.idxArray.splice(index, 1);
					}
				}
				$("[name='nr_idx_array']").val(that.idxArray.join(","));
			});
		},
		set_rps_list : function(){
			var that = this;
			if( that.idxArray.length > 0 ){
				$("#RpsTotalList input[name='nr_idx[]']").each(function(){
					var index = that.idxArray.indexOf($(this).val());
					if( index > -1 ){
						$(this).prop("checked", true);
					}
				});
			}
		}
	}
</script>