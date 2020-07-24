// erps 문서등록시 사용
// ajax 처리
var uiErps = (function(){
    return{
        activeIdx : null,
        init : function(){
            console.log(1);
            this.event_control();
        },
        event_control : function(){
            var that = this;
            $("#ErpItemList .Draggable__item").each(function(){
                var item = $(this);
                item.on('click', '.Button__file_ch', function(e){
                    e.preventDefault();
                    console.log("중문자료");
                    var data = {
                        'ta_idx' : item.find("[name='ta_idx']").val(),
                        'nr_idx' : item.find("[name='nr_idx[]']").val()
                    }
                    that.uploade_file(data);
                });
                item.on('click', '.Button__file_ori', function(e){
                    e.preventDefault();
                    console.log("원문자료");
                });
            });
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
        },
        uploade_file : function(_data){
            var url = "/nmpa/erps_doc/uploader?";
            if(_data.ta_idx){
                url +="ta_idx="+_data.ta_idx;
            }
            if(_data.nr_idx){
                url +="nr_idx="+_data.nr_idx;
            }
            var win = window.open(url, "", "width=500,height=300");

            return;
            var that = this;
            $.ajax({
                type : "GET",
                url : "/nmpa/erps_doc/uploader/",
                data : _data,
				success : function(res) {
                    window.uiModal.open("Uploader", res);
				}               
            });            
        }
    }
})();