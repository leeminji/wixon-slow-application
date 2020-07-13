<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
		<div class="Button__group right">
			<a href="<?php echo $this-> write_href; ?>" class="Button Button__basic">신규등록</a>
		</div>
		<div class="pt10"></div>
		<div class="TableStyle__1">
			<table>
				<colgroup>
					<col style="width:3em">
					<col style="width:10em">
					<col>
					<col style="width:8em">
					<col style="width:7em">
					<col style="width:15em">
					<col style="width:7em">
					<col style="width:7em">
					<col style="width:18em">
				</colgroup>
				<thead>
					<tr>
						<th>NO.</th>
						<th>제조사명</th>
						<th>제품명</th>
						<th>품목유형</th>
						<th>업무종류</th>
						<th>품목유형</th>
						<th>계약일</th>
						<th>종료일</th>
						<th>등록</th>
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
						<td><?php echo $lt->ta_default ?></td>
						<td><?php echo $lt->ty_name ?></td>
						<td><?php echo $lt->rc_name ?></td>
						<td><?php echo substr($lt->re_contracted_at, 0, 10) ?></td>
						<td><?php echo substr($lt->re_ended_at, 0, 10) ?></td>
						<td>
							<a href="<?php echo $report_detail_link; ?>" class="Button Button__basic">진행보고서등록</a>
							<a href="<?php echo $report_status_link; ?>" class="Button Button__update">진행상황등록</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>		
		</div>

	</div>
</main>