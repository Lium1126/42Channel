$(function() {
    $("#reload").on("click", function() {
        /*---GETパラメータの解析---*/
        // URLパラメータを取得
        var queryString = window.location.search;
        var queryObject = new Object();
        if (queryString) {
            // queryStringを〇〇=□□の形に整形
            queryString = queryString.substring(1);
            var parameters = queryString.split('&');

            // URLから連想配列を作る
            for (var i = 0; i < parameters.length; i++) {
                var element = parameters[i].split('=');

                var paramName = decodeURIComponent(element[0]);
                var paramValue = decodeURIComponent(element[1]);

                queryObject[paramName] = paramValue;
            }
        }

        $("#thread_area").empty();
        
        $.getJSON("../php/getThreadInfo.php?query=" + queryObject['title'], function(data) {
            // console.log(data);
            var num = 0;

            for (var i = 0;i < data.resp_data.length;i++) {
                if (data.resp_data[i].ID == queryObject['threadID']) {
                    num = parseInt(data.resp_data[i].num);
                }
            }

            view(parseInt(queryObject['threadID']), num);

            setTimeout(function(){
                $('html, body').animate(
                    { scrollTop: $('body').get(0).scrollHeight }, 500
                );    
            }, 500);
        })
    });
});
