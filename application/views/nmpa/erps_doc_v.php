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
		<div class="DataLink__list">
			<?php foreach($chapter_list as $ls){ 
				$is_active = $this->nc_idx == $ls->nc_idx ? "active" : "";
				$link = "/nmpa/erps_doc/45?ta_idx={$this->ta_idx}&nc_idx={$ls->nc_idx}";
			?>
				<a href="<?php echo $link ?>" class="DataLink DataLink__basic <?php echo $is_active ?>"><span><?php echo $ls->nc_name; ?></span></a>
			<?php } ?>
			<?php if(count($chapter_list) == 0 ){ ?>
				<div class="DataLink__empty">등록된 chapter가 없습니다.</div>
			<?php } ?>
		</div>
		<div class="pt10"></div>
		<?php if(count($chapter_list) > 0 ){ ?>
		<form action="" class="Form">
			<!-- Draggable -->
			<div class="Draggable" id="tbl_erps_rps">
				<div class="Draggable__title">
					<div class="Draggable__list">
						<div class="Draggable__item">
							<span class="col col1">RPS목록</span>
							<span class="col col2">표제</span>
							<span class="col col5">자료요구</span>
							<span class="col col3">중문자료</span>
							<span class="col col4">원문자료</span>
							<span class="col col6">작업</span>
						</div>
					</div>
				</div>
				<!-- 등록 -->
				<div class="Draggable__body bg01">
					<div class="Draggable__list">
						<div class="Draggable__item">
							<span class="col col1">등록</span>
							<span class="col col2">
								<div class="TextAreaInput">
								<textarea size="100" name="nr_title[]" placeholder="표제등록"></textarea></div>
							</span>
							<span class="col col5">
								<div class="TextAreaInput">
									<textarea size="100" name="nr_doc[]" placeholder="자료요구 등록"></textarea>
								</div>
							</span>
							<span class="col col3">
								<?php echo ft_dropdown_box("nr_doc_ch",$doc_array, array(), 4); ?>
								<button class="Button Button__basic"><span>등록</span></button>
							</span>
							<span class="col col4">
								<?php echo ft_dropdown_box("nr_doc_ori",$doc_array, array(), 4); ?>
								<button class="Button Button__basic"><span>등록</span></button>
							</span>
							<span class="col col6">
								<button class="Button Button__create"><span>등록</span></button>
							</span>
						</div>
					</div>
				</div>
				<!-- //등록 -->
				<div class="Draggable__body">
					<div class="Draggable__list">
						<?php foreach($rps_list as $ls){ ?>
						<div class="Draggable__item">
							<input type="hidden" name="nr_idx[]" value="<?php echo $ls->nr_idx ?>">
							<span class="col col1"><?php echo $ls->nc_title ?>.<?php echo $ls->nr_num ?></span>
							<span class="col col2">
								<div class="TextAreaInput">
								<textarea size="100" name="nr_title[]"><?php echo $ls->nr_title?></textarea></div>
							</span>
							<span class="col col5">
								<div class="TextAreaInput">
								<textarea size="100" name="nr_doc[]"><?php echo $ls->nr_doc?></textarea></div>
							</span>
							<span class="col col3">
								<?php echo ft_dropdown_box("nr_doc_ch",$doc_array, array($ls->nr_doc_ch), 4); ?>
								<a href="/sns/ms_auth/signin" class="Button Button__basic"><span>자료</span></a>
							</span>
							<span class="col col4">
								<?php echo ft_dropdown_box("nr_doc_ori",$doc_array, array($ls->nr_doc_ori), 4); ?>
								<a href="javascript:uiModal.show('Uploader', '/uploader/tester', tester);" class="Button Button__basic"><span>자료</span></a>
							</span>
							<span class="col col6">
								<a href="javascript:;" class="Button Button__basic" onclick="uiErps.open_sub_list(<?php echo $ls->nr_idx?>)"><span>하위목록</span></a>
								<button class="Button Button__update"><span>수정</span></button>
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
        <div class="Layout__row">
            <div class="Layout__col4">
			</div>
            <div class="Layout__col8">
			</div>
		</div>
		<?php } ?>
	</div>
</main>

<!-- Modal -->
<div id="RpsSubList" class="Modal"></div>
<div id="Uploader" class="Modal"></div>
<!-- //Modal -->

<script src="/public/js/ui.erps.js"></script>
<script>
	function tester(){
		alert('dd');
	}
	$(document).ready(function(){
		uiErps.init();
	});
</script>
