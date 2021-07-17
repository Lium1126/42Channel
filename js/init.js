$(function() {
  // 最新のスレッド一覧の見出しを表示
  var thread = $("#thread_area");
  thread.append("<h1>最新のスレッド一覧</h1>");

  var result_ids = [];             // 取得したスレッドのthreadIDを配列に記憶
  var result_num = 0;              // 取得したスレッドの数

  // 最新スレッドの情報を最大5件取得
  $.getJSON("../php/getNearestThreadInfo.php", function(threadInfo) {
    // 取得したデータの確認用
    // console.log(threadInfo);

    // 取得に失敗した場合
    if (threadInfo.state != "SUCCESS") {
      alert("検索結果の取得に失敗しました");
    }

    // 取得に成功した場合
    else {
      // 取得したスレッド情報の数を変数に保存
      result_num = threadInfo.resp_num;

      // 取得したスレッド情報が0件
      if (result_num <= 0) {
        var str = '<p class="search_result_title">スレッドがありません</p>';
        thread.append(str);
      }

      // 取得したスレッド情報が1件以上
      else {
        // 取得結果を新しい順に一覧表示
        for (var i = 0;i < result_num;i++) {
          var result_title = "";                      // 取得したスレッドへのリンク
          var title = threadInfo.resp_data[i].title;  // 取得したスレッドのタイトル
          var num = threadInfo.resp_data[i].num;      // 取得したスレッドの投稿数
          var id = threadInfo.resp_data[i].ID;        // 取得したスレッド一件のthreadID
          var url = 'html/view.html?threadID=' + id + '&num=' + num + '&title=' + encodeURIComponent(title);

          // 取得したthreadIDを配列に保存
          result_ids.push(id)

          result_title += '<div class="search_result_title">';
          result_title += '<a href="' + url + '">' + title + '(' + num + ')</a>';
          result_title += '</div>';
          result_title += '<div id="first_content' + id + '"></div>';  // そのスレッドの1つ目の投稿を表示するエリアを作成
          thread.append(result_title);
        }
      }
    }

    // 取得したスレッドの1件目の投稿を表示
    for (var i = 0;i < result_num;i++) {
      dispFirstContent(result_ids[i]);
    }
  });
});
