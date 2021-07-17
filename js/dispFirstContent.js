function dispFirstContent(id) {
    // スレッドIDが引数idのスレッドの1件目の投稿を取得する
    var one_content = $("#first_content" + id);  // スレッドの1件目の投稿を表示するエリア
    var first_content = "";                      // スレッドの1件目の投稿
  
    // 引数のIDのスレッドの1件目の投稿を取得して表示
    $.getJSON("../php/getThreadContent.php?threadID=" + id + "&begin=1&end=1", function(threadContet) {
        // console.log(threadContet);
        // stateがSUCCESSかつ取得したデータが存在する場合のみ1件目の投稿を表示
        // (正しく取得できなかった場合や取得したデータが0件の場合は何もしない)
        if (threadContet.state == "SUCCESS" && threadContet.resp_num > 0) {
            var content_html = threadContet.resp_data[0].content;   // 投稿内容のHTML形式で表示する文字列を格納
            content_html = AutoLink(content_html);
            content_html = AutoNextLine(content_html);
  
            /*---投稿内容---*/
            first_content = '<div class="one_content" id="content' + id + '">';
            first_content += "1 ";
            first_content += '<span class="name">名無しさん</span>';
            first_content += '<div class="content">' + content_html + '</div>';

            /*---画像を表示するエリアを作成しておく---*/
            first_content += '<div class="image_area"></div>';

            /*---日付---*/
            first_content += '<div class="date">';
            var date = threadContet.resp_data[0].date;
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
            first_content += date.year + "/" + date.month + "/" + date.day + " " + date.hour + ":" + minute + "." + second;
            first_content += '</div>';
            first_content += '</div>';
  
            one_content.append(first_content);
        }

        var obj = $("#thread_area");
        moveFooter(obj.height(), obj[0].offsetTop);

        if (threadContet.resp_data[0].img != null) {
            appendImage(threadContet.resp_data[0].img, $("#content" + id + " > .image_area"));
        }
    });
}
