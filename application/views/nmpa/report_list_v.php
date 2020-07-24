<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
		<div class="Button__group right">
			<a href="<?php echo $this-> write_href; ?>" class="Button Button__basic">신규고객추가</a>
		</div>
		<div class="pt10"></div>
		<div class="TableStyle__1">
			<table>
				<colgroup>
					<col style="width:3em">
					<col style="width:8em">
					<col style="width:10em">
					<col style="width:5em">
					<col style="width:5em">
					<col style="width:8em">
					<col style="width:12em">
					<col style="width:7em">
					<col style="width:7em">
					<col style="width:7em">
					<col style="width:7em">
					<col style="width:11em">
				</colgroup>
				<thead>
					<tr>
						<th rowspan="2">NO.</th>
						<th rowspan="2">제조사</th>
						<th rowspan="2">제품명</th>
						<th rowspan="2">기기구분</th>
						<th rowspan="2">등급</th>
						<th rowspan="2">업무</th>
						<th rowspan="2">품목유형</th>
						<th colspan="2">진행상황</th>
						<th rowspan="2">계약일</th>
						<th rowspan="2">종료일</th>
						<th rowspan="2">등록</th>
					</tr>
					<tr>
						<th>1단계</th>
						<th>2단계</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($list as $lt){ 
						$report_detail_link = "/nmpa/report/detail/{$midx}?re_idx={$lt->re_idx}";
						$report_status_link = "/nmpa/report/status/{$midx}?re_idx={$lt->re_idx}";
					?>
					<tr>
						<td><?php echo $lt->num ?></td>
						<td><a href="<?php echo $lt->link; ?>"><?php echo $lt->re_mf ?></a></td>
						<td><a href="<?php echo $lt->link; ?>"><?php echo $lt->re_pr_name ?></a></td>
						<td><?php echo $lt->de_name ?></td>
						<td><?php echo $lt->re_grade ?></td>
						<td><?php echo $lt->ty_name ?></td>
						<td><spn class="font_sm"><?php echo $lt->re_rank_1 ?></spn></td>
						<td></td>
						<td></td>
						<td><?php echo substr($lt->re_contracted_at, 0, 10) ?></td>
						<td><?php echo substr($lt->re_ended_at, 0, 10) ?></td>
						<td>
							<div class="p5">
							<!-- <a href="<?php echo $report_detail_link; ?>" class="Button Button__basic" size="8">진행상황보고서</a>
							<div class="pt5"></div> -->
							<a href="<?php echo $report_status_link; ?>" class="Button Button__update" size="8">업체관리</a>
							</div>
						</td>
					</tr>
					<?php } ?>
					<?php if( count($list) == 0 ) echo "<tr><td class='empty' colspan='12'>등록된 업체가 없습니다.</td></tr>"; ?>
				</tbody>
			</table>		
		</div>
		<?php echo $pagination; ?>
	</div>
</main>