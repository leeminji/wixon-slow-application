var uiMenuTree = (function(){
    return{
        activeIdx : 0,
        activeSubIdx : null,
        totalList : null,
        init : function(){
            this.list();
            this.sub_list();
            this.control_event();
            this.isControl(false);
        },
        control_event : function(){
            var that = this;
            $("#BtnMoveSave").off("click").on("click", function(e){
                e.preventDefault();
                that.move();
            });
            $("#BtnCreate").off("click").on("click", function(e){
                e.preventDefault();
                that.create();
            });  
            $("#BtnUpdate").off("click").on("click", function(e){
                e.preventDefault();
                that.update();
            });
            $("#BtnDelete").off("click").on("click", function(e){
                e.preventDefault();
                that.delete();
            });          
        },
        isControl : function(plag){
            var control = $(".MenuTree__control");
            control.css('display', 'none');
            if(!plag){
                $("#MenuTreeControl__create").css('display', 'block');
            }else{
                $("#MenuTreeControl__update").css('display', 'block');
            }
        },
        move : function(){
            var that = this;
            var params = $("#MenuTreeForm").serialize();
            $.ajax({
                data: params,
                type : "POST",
                async : false,
                url : "/setting/menu/move",
                dataType : "json",
				success : function(res, textStatus) {
                    if(res.status == 1) {
                        that.list();
                        that.sub_list();
                    }
                },
                error : function(res, textStatus) {
                    alert(textStatus + " 서버와의 통신시 문제가 발생했습니다.\n잠시후 다시 이용 하세요");
                }
            });
        },
        sub_list_event : function(){
            var that = this;
            $("#MenuTreeSub").find(".MenuTree__item").off('click').on('click', function(e){
                e.preventDefault();
                var item = $(this);
                item.siblings().removeClass("active");
                item.addClass('active');
                that.activeSubIdx = item.data('idx');
                that.showDetail();
                that.isControl(true);               
            });
            $("#MenuTreeSub > ul").sortable({
                axis: "y",
                cursor : 'move'
            });
        },
        list_event : function(){
            var that = this;
            var menuTree = $("#MenuTree");
            menuTree.find(".MenuTree__item").addClass('isOpen');
            menuTree.find(".MenuTree__item[data-idx="+that.activeIdx+"]").addClass('active');

            menuTree.find(".MenuTree__list").show();
            menuTree.find(".MenuTree__item").find(".toggle").off("click").on("click", function(e){
                var item = $(this).parent().parent();
                var submenu = item.children("ul");
                if( submenu != null ){
                    if( submenu.css('display') == 'none'){
                        submenu.show();
                        item.addClass("isOpen");
                    }else{
                        submenu.hide();
                        item.removeClass("isOpen");
                    }
                }
            });
            menuTree.find(".MenuTree__item").children('.info').off("click").on("click", function(e){
                var item = $(this).parent();
                that.activeIdx = item.data('idx');
                that.activeSubIdx = null;
                that.sub_list();
                that.isControl(false);
                that.resetDetail();
                menuTree.find(".MenuTree__item").removeClass('active');
                item.addClass("active");
            });
        },
        list : function(){
            var that = this;
            $.ajax({
                type : "GET",
                url : "/setting/menu/list",
                dataType : "json",
                data : {
                    "mt_idx" : $("select[name='mt_idx']").val()
                },
				success : function(res, textStatus) {
                    var el = $("#MenuTree");
					if(res.status == 1) {
                        that.totalList = res.list;
                        el.empty().append(res.data);
                        that.list_event();
					}else{
                        alert(res.msg);
                    }
				}
            });
        },
        sub_list : function(){
            var that = this;
            $.ajax({
                type : "GET",
                url : "/setting/menu/sub_list/"+this.activeIdx,
                data : {
                    "mt_idx" : $("select[name='mt_idx']").val()
                },                
                dataType : "json",
				success : function(res, textStatus) {
                    var el = $("#MenuTreeSub");
					if(res.status == 1) {
                        el.empty().append(res.data);
                        that.sub_list_event();
					}else{
                        el.empty().append(res.msg);
                    }
				}               
            });
        },
        create : function(){
            var that = this;
            var params = $("#MenuTreeDetailForm").serialize();
            $.ajax({
                type : "POST",
                url : "/setting/menu/create",
                dataType : "json",
                data : params,
				success : function(res, textStatus) {
                    if(res.status == 1) {
                        that.list();
                        that.sub_list();
                        that.resetDetail();
                    }else{
                        alert(res.msg);
                    }
                },
                error : function(res, textStatus) {
                    alert(textStatus + " 서버와의 통신시 문제가 발생했습니다.\n잠시후 다시 이용 하세요");
                }
            });
        },
        update : function(){
            var that = this;
            var params = $("#MenuTreeDetailForm").serialize();
            $.ajax({
                type : "POST",
                url : "/setting/menu/update/"+this.activeSubIdx,
                dataType : "json",
                data : params,
				success : function(res, textStatus) {
                    if(res.status == 1) {
                        that.list();
                        that.sub_list();
                        that.resetDetail();
                    }else{
                        alert(res.msg);
                    }
                },
                error : function(res, textStatus) {
                    alert(textStatus + " 서버와의 통신시 문제가 발생했습니다.\n잠시후 다시 이용 하세요");
                }
            });
        },
        delete : function(){
            var that = this;
            $.ajax({
                type : "GET",
                url : "/setting/menu/delete/"+this.activeSubIdx,
                dataType : "json",
				success : function(res, textStatus) {
                    if(res.status == 1) {
                        that.list();
                        that.sub_list();
                        that.activeSubIdx = null;
                        that.resetDetail();
                        that.isControl(false);
                    }else{
                        alert(res.msg);
                    }
                },
                error : function(res, textStatus) {
                    alert(textStatus + " 서버와의 통신시 문제가 발생했습니다.\n잠시후 다시 이용 하세요");
                }
            });
        },
        getItemDetail : function(idx){
            var that = this;
            console.log(that.totalList);
            return that.totalList.filter(function(item){
                return item.mm_idx == (idx == null ? that.activeSubIdx : idx );   
            });
        },
        showDetail : function(){
            var currentItem = this.getItemDetail()[0];
            $("input[name='mm_name']").val(currentItem.mm_name);
            $("input[name='mm_link']").val(currentItem.mm_link);
            $("input[name='mm_pidx']").val(currentItem.mm_pidx);
            $("input[name='mm_dep']").val(currentItem.mm_dep);
        },
        resetDetail : function(){
            $("input[name='mm_name']").val("");
            $("input[name='mm_link']").val("");
            var dep = 0;
            var pidx = 0;
            if( this.activeIdx ){
                var item = this.getItemDetail(this.activeIdx)[0];
                dep = parseInt(item.mm_dep)+1;
                pidx = this.activeIdx;
            }
            $("input[name='mm_dep']").val(dep);
            $("input[name='mm_pidx']").val(pidx);
        }
    }
})();