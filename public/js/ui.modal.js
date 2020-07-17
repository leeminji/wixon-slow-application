var uiModal = (function(){
    return{
        open : function(_id, _data){
            var model = $("#"+_id);
            if( model.size() > 0){
                model.empty();
                model.append(_data);
                var inner = model.children(".Modal__inner");
                inner.css({
                    'top' : '50%',
                    'margin-top' : -inner.height()/2+"px"
                });
                model.addClass('active');
            }
        },
        close : function(_id){
            var modal = $(".Modal");
            if(_id){
                modal = $("#"+_id);
            }
            if( modal.size() > 0){
                modal.empty().removeClass('active').attr('style', '');
            }
        }
    }
})();