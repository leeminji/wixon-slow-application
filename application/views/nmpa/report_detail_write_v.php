<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $title; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
        <div class="Layout__row">
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
			<div class="pt30"></div>
			<div class="Button__group right">
				<a href="" class="Button Button__basic"><span>보고서 다운로드(execel)</span></a>
			</div>
			<div class="pt10"></div>
			<form action="" class="Form">
				<!-- Draggable -->
				<div class="Draggable" id="tbl_report_detail">
					<div class="Draggable__title">
						<div class="Draggable__list">
							<div class="Draggable__item">
								<span class="col col1">NO</span>
								<span class="col col2">진행단계</span>
								<span class="col col3">상세내용</span>
								<span class="col col4">작성일</span>
								<span class="col col5">비고</span>
								<span class="col col6">작성</span>
							</div>
						</div>
					</div>
					<!-- 등록 -->
					<div class="Draggable__body bg01">
						<div class="Draggable__list">
							<div class="Draggable__item">
								<span class="col col1">등록</span>
								<span class="col col2">
									<?php echo ft_dropdown_box("rs_idx",$step_array, array(), 10); ?>
								</span>
								<span class="col col3">
									<input type="text" size="100" name="rd_content" />
								</span>
								<span class="col col4">
									<input type="text" size="100" name="rd_created_at" />
								</span>
								<span class="col col5">
									<input type="text" size="100" name="rd_etc" />
								</span>
								<span class="col col6">
									<a href="#" class="Button Button__create">작성</a>
								</span>
							</div>
						</div>
					</div>
					<!-- //등록 -->
					<div class="Draggable__body">
						<div class="Draggable__list">
							<?php foreach($report_detail_list as $ls){ ?>
							<div class="Draggable__item">
								<input type="hidden" name="rd_idx[]" value="<?php echo $ls->rd_idx ?>">
								<span class="col col1"><?php echo ($ls->rd_num)+1 ?></span>
								<span class="col col2">
									<?php echo ft_dropdown_box("rs_idx",$step_array, array($ls->rs_idx), 10); ?>
								</span>
								<span class="col col3">
									<input type="text" value="<?php echo $ls->rd_content; ?>" size="100">
								</span>
								<span class="col col4">
									<input type="text" value="<?php echo substr($ls->rd_created_at,0,10); ?>" size="100">
								</span>
								<span class="col col5">
									<input type="text" value="<?php echo $ls->rd_etc ?>" size="100">
								</span>
								<span class="col col6">
									<a href="#" class="Button Button__basic">수정</a>
								</span>				
							</div>
							<?php } ?>
						</div>
					</div>
					<!-- <div class="Draggable__bottom">
						<button class="Button Button__basic"><span>순서수정</span></button>
					</div> -->
				</div>
				<!-- //Draggable -->
			</form>
		</div>
		<div class="pt30"></div>
		<div class="Button__group right">
			<a href="/nmpa/report/49" class="Button Button__basic"><span>목록</span></a>
		</div>
	</div>
</main>
