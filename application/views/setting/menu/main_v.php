<main class="Page">
    
	<div class="Page__inner">
		<div class="Location">
			<h1 class="Location__title">Menu Setting</h1>
			<p class="Location__text">메뉴설정</p>
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
                            <input type="hidden" name="m_pidx" />
                            <input type="hidden" name="m_dep" />
                            <div class="InputBox__basic">
                                <div class="title">메뉴명</div>
                                <div class="cont">
                                    <input type="text" name="m_name" />
                                </div>
                            </div>
                            <div class="InputBox__basic">
                                <div class="title">링크</div>
                                <div class="cont">
                                    <input type="text" name="m_link" />
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