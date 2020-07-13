<main class="Page">
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title"><?php echo $title; ?></h1>
			<p class="Location__text"><?php echo $description ?></p>
		</div>
		<div class="pt20"></div>
		<div class="Button__group right">
			<a href="" class="Button Button__basic"><span>보고서 다운로드(execel)</span></a>
		</div>
		<div class="pt10"></div>
        <div class="Layout__row">
            <div class="Layout__col3">		
			<form action="" class="Form">
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_id">고객</label>
					</div>
					<div class="Form__data">(주)휴비츠</div>
				</div>			
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_id">관리번호</label>
					</div>
					<div class="Form__data"><?php echo set_value($view, 're_id')?></div>
				</div>			
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_mf">제조사</label>
					</div>
					<div class="Form__data"><?php echo set_value($view, 're_mf')?></div>
				</div>
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_pr_name">제품명</label>
					</div>
					<div class="Form__data"><?php echo set_value($view, 're_pr_name')?></div>
				</div>
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_mf">위탁업무</label>
					</div>
					<div class="Form__data">
						<?php echo set_value($view, 'ta_task')?>
					</div>
				</div>
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_grade">등급</label>
					</div>
					<div class="Form__data">
						<?php echo set_value($view, 're_grade')?>
					</div>
				</div>
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_mf">품목분류</label>
					</div>
					<div class="Form__data"><?php echo set_value($view, 'rc_name')?></div>
				</div>			
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_mf">품목명</label>
					</div>
					<div class="Form__data"><?php echo set_value($view, 'rg_title')?></div>
				</div>
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_mf">위탁일</label>
					</div>
					<div class="Form__data"><?php echo set_value($view, 're_contracted_at')?></div>
				</div>
				<div class="Form__group">
					<div class="Form__label">
					<label for="re_mf">종료일</label>
					</div>
					<div class="Form__data"><?php echo set_value($view, 're_ended_at')?></div>
				</div>
			</form>
			</div>
			<div class="Layout__col9">
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
		</div>
		<div class="Button__group right">
			<a href="/nmpa/report/49" class="Button Button__basic"><span>목록</span></a>
		</div>
	</div>
</main>