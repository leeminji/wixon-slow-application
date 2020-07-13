// erps 문서등록시 사용
// ajax 처리
var uiErps = (function(){
    return{
        activeIdx : null,
        init : function(){
            this.event_control();
        },
        event_control : function(){
            // var that = this;
            // $(".BtnSubList").off("click").on("click", function(e){
            //     e.preventDefault();
            //     that.sub_list();
            // });
        },
        open_sub_list : function(_pidx){
            var that = this;
            this.activeIdx = _pidx;
            this.sub_list();
        },
        sub_list : function(){
            var that = this;
            $.ajax({
                type : "GET",
                url : "/nmpa/erps_doc/rps_list/"+this.activeIdx,
				success : function(res) {
                    //console.log(res);
                    that.open_layer("RpsSubList", res);
				}               
            });
        },
        open_layer : function(_id, _html){
            var model = $("#"+_id);
            if( model ){
                model.addClass('active');
                model.empty().append(_html);
            }
        }
    }
})();