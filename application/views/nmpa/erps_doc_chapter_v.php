<main class="Page">
	<div class="Page__inner">
        <!-- <div class="Page__setting">
            <button class="Button Button__icon">Setting</button>
        </div> -->
		<div class="Location">
			<h1 class="Location__title"><?php echo $menu_info->mm_name; ?></h1>
			<p class="Location__text">NMPA 업무등록</p>
		</div>
		<div class="pt10"></div>
		<form action="" class="Form">
			<div class="Form__group">
				<div class="Form__label">
					<label for="ta_idx">업무선택</label>
				</div>
				<div class="Form__data">
					<?php echo $task_select ?>
					<button class="Button Button__basic"><span>검색</span></button>
				</div>
			</div>
		</form>
		<div class="pt10"></div>
		<form action="" class="Form">
			<!-- Draggable -->
			<div class="Draggable" id="tbl_erps_chapter">
				<div class="Draggable__title">
					<div class="Draggable__list">
						<div class="Draggable__item">
							<span class="col col1">NO</span>
							<span class="col col1">CH</span>
							<span class="col col2">제출문서목록</span>
							<span class="col col3">작업</span>
						</div>
					</div>
				</div>
				<div class="Draggable__body bg01">
					<div class="Draggable__list">
						<div class="Draggable__item">
							<span class="col col1">등록</span>
							<span class="col col1"><input type="text" value="" size="100" placeholder="CH 등록" /></span>
							<span class="col col2">
								<input type="text" value="" size="100" placeholder="목록등록" />
							</span>
							<span class="col col3">
								<button class="Button Button__basic"><span>등록</span></button>
							</span>
						</div>
					</div>
				</div>
				<div class="Draggable__body">
					<div class="Draggable__list">
						<?php foreach($chacter_list as $ls){ ?>
						<div class="Draggable__item">
							<input type="hidden" name="nc_idx[]" value="<?php echo $ls->nc_idx ?>">
							<span class="col col1"><?php echo ($ls->nc_num)+1 ?></span>
							<span class="col col1"><input type="text" value="<?php echo $ls->nc_title?>" size="100" name="nc_title[]" /></span>
							<span class="col col2">
								<input class="InputText" type="text" value="<?php echo $ls->nc_name?>" size="100" name="nc_name[]" />
							</span>
							<span class="col col3">
								<button class="Button Button__basic"><span>수정</span></button>
							</span>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="Draggable__bottom">
					<button class="Button Button__basic"><span>순서수정</span></button>
				</div>
			</div>
			<!-- //Draggable -->
		</form>
	</div>
</main>