$(function() {
    var if_ctrl = 0;
    var if_r = 0;
    function is_ctrl(pressKey){
        if(pressKey==17){ //ctrl
            return 1;
        } else if (navigator.userAgent.match(/macintosh/i)){
            if (pressKey == 224 && navigator.userAgent.match(/firefox/i)){
                return 1;
            } else if (pressKey == 91 || pressKey == 93){
                return 1;
            }
        }
        return 0;
    }
    
    function disable_reload(e){
        if(navigator.userAgent.match(/msie/i) && window.event){
            window.event.returnValue=false;
            window.event.keyCode=0
        } else if (navigator.userAgent.match(/macintosh/i) || e.preventDefault){
            e.preventDefault();
            e.stopPropagation();
        }
        
        return false;
    }

    function catchkeydown(e){
        var pressKey;
        if (eval(e)){
            pressKey=e.keyCode;
        } else {
            pressKey=event.keyCode;
        }

        if(is_ctrl(pressKey)==1){ //ctrl
            if_ctrl=1;
            if(if_r==1){return disable_reload(e);}
        }
        
        if(pressKey==82){ //r
            if_r=1;
            if(if_ctrl==1){return disable_reload(e);}
        }
    
        if(pressKey==116){ //f5
            if (navigator.userAgent.match(/safari/i) && !navigator.userAgent.match(/chrome/i)){
                window.location="%_myname_%?n=%_n_%&i=%_i_%";
                return true;
            } else {
                return disable_reload(e);
            }
        }
    }
    
    function catchkeyup(e){
        var pressKey;
        if (eval(e)){
            pressKey=e.keyCode;
        } else {
            pressKey=event.keyCode;
        }
        if(is_ctrl(pressKey)==1){ //ctrl
            if_ctrl=0;
            if(if_r==1){return disable_reload(e);}
        }
        if(pressKey==82){ //r
            if_r=0;
            if(if_ctrl==1){return disable_reload(e);}
        }
        if(pressKey==116){ //f5
            if (navigator.userAgent.match(/safari/i) && !navigator.userAgent.match(/chrome/i)){
                window.location="%_myname_%?n=%_n_%&i=%_i_%";
            } else {
                return disable_reload(e);
            }
        }
    }

    document.onkeydown = catchkeydown;

    document.onkeyup = catchkeyup;

    // 右クリックメニューの禁止
    document.oncontextmenu = function(){
        return false;
    };
});