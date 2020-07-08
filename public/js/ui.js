var ui = (function(){
    return{
        init : function(){
            console.log("ui");
        },
        location : function(_this){
            if (_this.value){
                window.location.href = window.location.pathname+"?"+_this.id+"="+_this.value;
            }else{
                return false;
            }
        }
    }
})();