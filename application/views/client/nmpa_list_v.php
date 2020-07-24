<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
        </div>
		<div class="pt30"></div>
		<div class="TableStyle__1">
			<table>
				<colgroup>
					<col style="width:3em">
					<col style="width:10em">
					<col style="width:10em">
					<col style="width:10em">
					<col style="width:10em">
				</colgroup>
				<thead>
					<tr>
						<th rowspan="1">NO.</th>
						<th rowspan="1">제품명</th>
						<th rowspan="1">기기구분</th>
						<th rowspan="1">등급</th>
						<th rowspan="1">업무</th>
						<th rowspan="1">상세보기</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($list as $lt){ 
						$report_status_link = "/nmpa/report/status/{$midx}?re_idx={$lt->re_idx}";
					?>
					<tr>
						<td><?php echo $lt->num ?></td>
						<td><?php echo $lt->re_pr_name ?></td>
						<td><?php echo $lt->de_name ?></td>
						<td><?php echo $lt->re_grade ?></td>
						<td><?php echo $lt->ty_name ?></td>		
						<td><a href="<?php echo $lt->link ?>" class="Button Button__basic">상세보기</a></td>		
					</tr>
					<?php } ?>
					<?php if( count($list) == 0 ) echo "<tr><td class='empty' colspan='5'>등록 된 인허가 업무가 없습니다.</td></tr>"; ?>
				</tbody>
			</table>		
		</div>
		<?php echo $pagination; ?>        
    </div>
</main>
