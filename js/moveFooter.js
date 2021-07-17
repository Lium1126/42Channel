function moveFooter(offset,top) {
    var height = offset + top;
    var sh = window.innerHeight

    if(sh > height){
        $("#footer").css("top", sh + "px"); //フッターに内容とヘッダーの高さ分下げる。
    } else {
        $("#footer").css("top", height + "px"); //フッターに内容とヘッダーの高さ分下げる。
    }
}
