<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $title; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
		<!-- 업체정보 -->
		<div class="TableStyle__1"> 
			<table>
				<colgroup>
					<col style="width:12em">
					<col>
					<col style="width:12em">
					<col>
				</colgroup>
				<tbody>
					<tr>
						<th>고객명</th>
						<td class="left"><?php echo $view->mb_name ?></td>
						<th>구분</th>
						<td class="left"><?php echo $view->de_name ?></td>
					</tr>
					<tr>
						<th>제품명</th>
						<td class="left"><?php echo $view->re_pr_name ?></td>
						<th>등급</th>
						<td class="left"><?php echo $view->re_grade ?>등급</td>
					</tr>
					<tr>
						<th>중분류</th>
						<td class="left"><?php echo $view->re_rank_1 ?></td>
						<th>업무유형</th>
						<td class="left"><?php echo $view->ty_name ?></td>
					</tr>
					<tr>
						<th>제조사</th>
						<td class="left"><?php echo $view->re_mf ?></td>
						<th>관리번호</th>
						<td class="left"><?php echo $view->re_id?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //업체정보 -->
		<div class="pt10"></div>
		<?php 
			$attr = array('class' => 'form', 'id'=>'frm');
			echo form_open('', $attr);
		?>
		<input type="hidden" name="re_idx" value="<?php echo $this->re_idx; ?>">
		<input type="hidden" name="nr_idx_array" value="<?php echo ft_set_value($status_view ,'nr_idx_array')?>" />
		<input type="hidden" name="step" value="<?php echo $this->step?>" />
		<div class="pt30"></div>
		<!-- 단계선택 -->
		<div class="ReportStep">
			<div class="ReportStep__title"><span>진행단계</span></div>
			<div class="ReportStep__list">
				<div class="ReportStep__item <?php if($this->step==1) echo 'active' ?>">
					<a href="<?php echo $step_link."&step=1" ?>" class="link"></a>
					<div class="title">사전준비</div>
					<div class="check">
						<span class="Switch__txt">진행</span>
						<span class="Switch__txt">완료</span>
					</div>
				</div>
				<div class="ReportStep__item <?php if($this->step==2) echo 'active' ?>">
					<a href="<?php echo $step_link."&step=2" ?>" class="link"></a>
					<div class="title">eRPS</div>
					<div class="check">
						<span class="Switch__txt">진행</span>
						<span class="Switch__txt">완료</span>
					</div>
				</div>
				<div class="ReportStep__item <?php if($this->step==3) echo 'active' ?>">
					<a href="<?php echo $step_link."&step=3" ?>" class="link"></a>
					<div class="title">심사평가 및 승인</div>
					<div class="check">
						<span class="Switch__txt">진행</span>
						<span class="Switch__txt">완료</span>
					</div>
				</div>
			</div>
		</div>
		<div class="pt10"></div>
		<div class="RadiusBox RadiusBox__page">
		<!-- //단계선택 -->
			<?php if($this->step=="1"){ ?>
				<div class="Button__group right"><a href="" class="Button__basic Button">보고서다운로드</a></div>
				<div class="pt10"></div>
				<div class="TableStyle__1">
					<table>
						<colgroup>
							<col style="width:3em">
							<col style="width:10em">
							<col style="width:12em">
							<col style="width:25em">
							<col>
							<col>
							<col>
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>세부단계</th>
								<th>진행상황</th>
								<th>세부내용</th>
								<th>작성일</th>
								<th>고객제출서류</th>
								<th>관리자서류</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1;
							foreach($step_detail as $ls){ ?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $ls ?></td>
								<td><?php echo ft_dropdown_box("st_status[]", $status_array)?></td>
								<td><input type="text" value="" name="" size="100"></td>
								<td><input type="text" value="" name="" class="datepicker"  size="8"></td>
								<td><span>자료</span></td>
								<td><span>Y</span> <a href="" class="Button__basic Button">등록</a></td>
							</tr>
							<?php $i++; } ?>
						</tbody>
					</table>
				</div>
			<?php } ?>
			<?php if($this->step=="2"){ ?>
				<div class="TableStyle__1">
					<table>
						<colgroup>
							<col style="width:3em">
							<col style="width:10em">
							<col style="width:12em">
							<col style="width:25em">
							<col>
							<col>
							<col>
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>세부단계</th>
								<th>진행상황</th>
								<th>세부내용</th>
								<th>작성일</th>
								<th>고객제출서류</th>
								<th>관리자서류</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1;
							foreach($step_detail as $ls){ ?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $ls ?></td>
								<td><?php echo ft_dropdown_box("st_status[]", $status_array)?></td>
								<td><input type="text" value="" name="" size="100"></td>
								<td><input type="text" value="" name="" class="datepicker"  size="8"></td>
								<td><span>자료</span></td>
								<td><span>Y</span> <a href="" class="Button__basic Button">등록</a></td>
							</tr>
							<?php $i++; } ?>
						</tbody>
					</table>
				</div>			
				<!-- erps -->
				<div class="pt20"></div>
				<!-- 문서선택 -->
				<div id="RpsTotalList" class="Layer__content">
					<div class="Layer__loading"></div>	
				</div>
				<!-- //문서선택 -->
				<!-- //erps -->
			<?php } ?>
			<?php if($this->step=="3"){ ?>
				<div class="Button__group right"><a href="" class="Button__basic Button">보고서다운로드</a></div>
				<div class="pt10"></div>
				<div class="TableStyle__1">
					<table>
						<colgroup>
							<col style="width:3em">
							<col style="width:10em">
							<col style="width:12em">
							<col style="width:25em">
							<col>
							<col>
							<col>
						</colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>세부단계</th>
								<th>진행상황</th>
								<th>세부내용</th>
								<th>작성일</th>
								<th>고객제출서류</th>
								<th>관리자서류</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1;
							foreach($step_detail as $ls){ ?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $ls ?></td>
								<td><?php echo ft_dropdown_box("st_status[]", $status_array)?></td>
								<td><input type="text" value="" name="" size="100"></td>
								<td><input type="text" value="" name="" class="datepicker"  size="8"></td>
								<td><span>자료</span></td>
								<td><span>Y</span> <a href="" class="Button__basic Button">등록</a></td>
							</tr>
							<?php $i++; } ?>
						</tbody>
					</table>
				</div>
			<?php } ?>
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
		reportStatus.taskIdx = <?php echo $view->ta_idx?>;
		reportStatus.init();
	});
	var reportStatus = {
		cateIdx : 1,
		taskIdx : 1,
		idxArray : [],
		step : 1,
		init : function(){
			this.step = $("[name='step']").val();
			//사전준비
			if( this.step == 2){
				var idxArrayValue = $("[name='nr_idx_array']").val().trim();
				if( idxArrayValue != "" ){
					this.idxArray = idxArrayValue.split(',');
				}
				this.rps_open();
			}
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