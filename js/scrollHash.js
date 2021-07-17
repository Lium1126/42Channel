$(function() {
    // URLにハッシュIDがあるか調べる
    var hash = window.location.hash;

    if (hash) {  // ハッシュがある場合
        // ページ内リンク(メンション移動)ではないので自動的に最下部にスクロール
        // (スレッド閲覧エリアが大きい場合に限る)
        setTimeout(function(){
            var thread_area = document.getElementById("thread_area");
            var thread_area_height = thread_area.clientHeight;
            if (thread_area_height > 400) {
                $('html, body').animate(
                    { scrollTop: $('body').get(0).scrollHeight }, 500
                );    
            }
        }, 500);
    }
});

function scrollMention(event) {
    console.log(event);
    var speed = 500;
    var href= $(event).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top - document.getElementById("header").clientHeight;
    $("html, body").animate({scrollTop:position}, speed, "swing");
};
