<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $title; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt10"></div>
		<div>
			업무 : <?php echo $view->ta_task ?>
		</div>
		<div class="pt10"></div>
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
							<a href="javascript:reportStatus.rps_open(<?php echo $view->ta_idx?>);" class="Button Button__basic">eRPS 문서 선택</a>
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
			<a href="#" class="Button Button__create"><span>저장</span></a>
			<a href="/nmpa/report/49" class="Button Button__basic"><span>목록</span></a>
		</div>
	</div>
</main>
<div id="RpsTotalList" class="Modal"></div>
<script>
	var reportStatus = {
		cateIdx : 1,
		taskIdx : 1,
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
					$("#RpsTotalList").empty().append(res).addClass("active");
				}
			});
		},
		rps_open_category : function(_nc_idx){
			this.cateIdx = _nc_idx;
			this.rps_open();
		}
	}
</script>