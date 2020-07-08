<main class="Page">
    
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title">Menu Setting</h1>
			<p class="Location__text">메뉴설정</p>
            <div class="pt10"></div>
            <div>
                <select name="mt_idx" id="mt_idx" onchange="window.ui.location(this);">
                    <option value="">메뉴선택</option>
                    <?php foreach($type_list as $list){ ?>
                    <option <?php echo $list->mt_idx == $mt_idx ? "selected" : "" ?> value="<?php echo $list->mt_idx ?>"><?php echo $list->mt_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="pt10"></div>
        <div class="Layout__row">
            <div class="Layout__col4">
                <div class="MenuDetail">
                    <div class="MenuDetail__top">
                        <h1 class="title">전체메뉴</h1>
                    </div>
                    <div class="MenuDetail__content">
                        <!-- MenuTree -->
                        <div class="MenuTree" id="MenuTree"></div>
                        <!-- //MenuTree -->
                    </div>
                </div> 
            </div>
            <div class="Layout__col3">
                <form id="MenuTreeForm">
                <div class="MenuDetail">
                    <div class="MenuDetail__top right">
                    <Button class="btn_basic" id="BtnMoveSave"><span class='txt' >순서변경적용</span></Button>
                    </div>
                    <div class="MenuDetail__content">
                        <!-- MenuTree -->
                        <div class="MenuTree noDepth" id="MenuTreeSub"></div>
                        <!-- //MenuTree --> 
                    </div>
                </div>
                </form>
            </div>
            <div class="Layout__col5">
                <div class="MenuDetail">
                    <div class="MenuDetail__top right">
                        <span id="MenuTreeControl__create" class="MenuTree__control">
                            <Button class="btn_basic" id="BtnCreate"><span class='txt'>하위메뉴등록</span></Button>
                        </span>    
                        <span id="MenuTreeControl__update" class="MenuTree__control">
                            <Button class="btn_basic" id="BtnUpdate"><span class='txt'>변경저장</span></Button>
                            <Button class="btn_basic" id="BtnDelete"><span class='txt'>메뉴삭제</span></Button>
                        </span>
                    </div>
                    <div class="MenuDetail__content">
                        <form id="MenuTreeDetailForm">
                            <input type="hidden" name="mt_idx" value="<?php echo $mt_idx?>" />
                            <input type="hidden" name="mm_pidx" />
                            <input type="hidden" name="mm_dep" />
                            <div class="InputBox__basic">
                                <div class="title">메뉴명</div>
                                <div class="cont">
                                    <input type="text" name="mm_name" />
                                </div>
                            </div>
                            <div class="InputBox__basic">
                                <div class="title">링크</div>
                                <div class="cont">
                                    <input type="text" name="mm_link" />
                                </div>
                            </div>
                            <div class="InputBox__basic">
                                <div class="title">허용그룹</div>
                                <div class="cont">
                                    <select name="" id="">
                                        <option value="A">A</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="/public/js/ui.menutree.js"></script>
<script>
    uiMenuTree.init();
</script>