// ページが読み込まれた際の処理
window.onload = function() {
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

    // queryObject['paramName']でアクセスできる
    // this.console.log(queryObject['threadID']);
    // this.console.log(queryObject['num']);
    // this.console.log(queryObject['title']);

    /*---スレタイを表示---*/
    var title_area = $("#title_area");
    title_area.append(queryObject['title']);

    /*--書き込みフォーム内のinput要素(hidden属性)にthreadIDを持たせる---*/
    $("#threadID_in_form").attr({'value' : queryObject['threadID']});

    view(parseInt(queryObject['threadID']), parseInt(queryObject['num']));
}


//--------------------------------
//id:スレッドID
//num:投稿件数
//--------------------------------
function view(id, num) {
    /*
    // テストデータでやってみる
    var thread = $("#thread_area");               // 変数thread=スレッドを表示するエリアが格納されている
    var div_start = '<div class="one_content">';  // 投稿内容を囲むdivタグの開始
    var div_end = '</div>';                       // 投稿内容を囲むdivタグの終了
    var id = 8;
    var content = "http://rio2016.5ch.net/test/read.cgi/math/1573635692\n"+"5channel";
    var year = 2020;
    var month = 6;
    var day = 1;
    var hour = 14;
    var minute = 1;
    var second = 15;

    content = AutoLink(content);
    content = AutoNextLine(content);

    var one_content = div_start;
    one_content += (id + " ");
    one_content += '<span class="name">名無しさん</span>';
    one_content += '<div class="content">' + content + '</div>';
    one_content += '<div class="date">';
    one_content += year + "/" + month + "/" + day + " " + hour + ":" + minute + "." + second;
    one_content += '</div>';
    one_content += div_end;

    thread.append(one_content);
    */

    /*---JSONから書き込みの内容を取得---*/
    $.getJSON("../php/getThreadContent.php?threadID=" + id + "&begin=1&end=" + num, function(data) {
        // JSONを取得した際の処理を書く
        // thread_areaに書き込みを表示する
        var thread = $("#thread_area");               // 変数thread=スレッドを表示するエリアが格納されている

        // 取得に失敗していたらアラートを表示
        if (data.state == "FAILURE") {
            alert("内容の取得に失敗しました");
        }
        // 取得に成功していたらthread_areaに内容を追加していく
        else {
            // 取得した書き込みの件数分ループ
            for (var i = 0;i < data.resp_num;i++) {
                // threadに書き込みを追加していく
                /*---投稿内容---*/
                var content = data.resp_data[i].content;
                content = AutoLink(content);
                content = AutoNextLine(content);
                content = AutoMention(content);
                var one_content = '<div class="one_content" id="content' + data.resp_data[i].ID +'">';
                one_content += (data.resp_data[i].ID + " ");
                one_content += '<span class="name">名無しさん</span>';
                one_content += '<div class="content">' + content + '</div>';
                
                /*---画像を表示するエリアを作っておく---*/
                one_content += '<div class="image_area"></div>'

                /*---日付---*/
                one_content += '<div class="date">';
                var date = data.resp_data[i].date;
                // 分,秒に関しては、1桁だったら先頭に"0"を付加する
                var minute = "";
                var second = "";
                if (String(date.minute).length == 1) {
                    minute = "0" + String(date.minute);
                } else {
                    minute = String(date.minute);
                }
                if (String(date.second).length == 1) {
                    second = "0" + String(date.second);
                } else {
                    second = String(date.second);
                }
                // 分,秒に"0"をつける処理の終端
                one_content += date.year + "/" + date.month + "/" + date.day + " " + date.hour + ":" + minute + "." + second;
                one_content += '</div>';

                /*---divタグを閉じる---*/
                one_content += '</div>';
                thread.append(one_content);

                if (data.resp_data[i].img != null) {
                    appendImage("../" + data.resp_data[i].img, $("#content" + data.resp_data[i].ID + " > .image_area"));
                }
            }
        }

        var obj = $("#thread_area");
        moveFooter(obj.height(), obj[0].offsetTop);
    });
}
