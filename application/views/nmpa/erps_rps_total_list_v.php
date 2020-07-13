<div class="DataLink__list">
	<?php foreach($chapter_list as $ls){ 
		$is_active = $this->nc_idx == $ls->nc_idx ? "active" : "";
		$link = "javascript:reportStatus.rps_open_category({$ls->nc_idx})";
	?>
		<a href="<?php echo $link ?>" class="DataLink DataLink__basic <?php echo $is_active ?>"><span><?php echo $ls->nc_name; ?></span></a>
	<?php } ?>
	<?php if(count($chapter_list) == 0 ){ ?>
		<div class="DataLink__empty">등록된 chapter가 없습니다.</div>
	<?php } ?>
</div>
<div class="pt10"></div>
<div class="TableStyle__1">
	<table>
		<colgroup>
			<col style="width:3em">
			<col style="width:8em">
			<col style="width:20em">
			<col>
			<col style="width:10em">
			<col style="width:10em">
		</colgroup>
		<thead>
			<tr>
				<th><input type="checkbox"></th>
				<th>RPS목록</th>
				<th>표제</th>
				<th>자료요구</th>
				<th>중문자료</th>
				<th>원문자료</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($rps_list as $ls){ ?>
			<tr>
				<td><input type="checkbox"></td>
				<td><?php echo $ls->nc_title.".".$ls->nr_num ?></td>
				<td class="left"><?php echo $ls->nr_title?></td>
				<td class="left"><?php echo $ls->nr_doc?></td>
				<td><?php echo $ls->nr_doc_ch?></td>
				<td><?php echo $ls->nr_doc_ori?></td>
			</tr>
			<?php 
				if($ls->nr_cnode > 0 ){
				$rps_sub_list = $this->Nmpa_task_rps_m->get_sub_items($ls->nr_idx);	
				//var_dump($rps_sub_list);
				foreach($rps_sub_list as $sls){
			?>
			<tr style="background:#efefef">
				<td><input type="checkbox"></td>
				<td><?php echo $ls->nc_title.".".$sls->pidx_num.".".$sls->nr_num ?></td>
				<td class="left"><?php echo $sls->nr_title?></td>
				<td class="left"><?php echo $sls->nr_doc?></td>
				<td><?php echo $sls->nr_doc_ch?></td>
				<td><?php echo $sls->nr_doc_ori?></td>
			</tr>
			<?php } //if문 종료
				} //rps_sub_list foreach 종료  
			?>
			<?php } //rps_list foreach 종료 ?>
		</tbody>
	</table>
</div>
<div class="pt10"></div>
<div class="Button__group right">
	<a href="" class="Button Button__basic">적용</a>
</div>