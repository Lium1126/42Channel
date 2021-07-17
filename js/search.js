$(function() {
  /*--- 検索ボタンをクリックしたら ---*/
  $("#search_btn").on("click", function() {
    var result_ids = [];             // 検索にヒットしたスレッドのthreadIDを配列に記憶
    var result_num = 0;              // 検索にヒットしたスレッドの数

    // 検索文字列が空文字列の場合
    var query = document.getElementById("search_txt").value;
    if (query == "") {
      alert("検索文字列がありません");
    }

    // 検索文字列がある場合は検索結果を取得
    else {
      var thread = $("#thread_area");  // 検索結果一覧を表示するエリア

      thread.empty();
      thread.append('<h1>"' + query + '"の検索結果</h1>');

      // 検索結果の取得
      $.getJSON("../php/getThreadInfo.php?query=" + query, function(threadInfo) {
        // 取得したデータの確認用
        // console.log(threadInfo);

        // 検索結果の取得に失敗した場合
        if (threadInfo.state != "SUCCESS") {
          alert("検索結果の取得に失敗しました");
        }

        // 検索結果の取得に成功した場合
        else {
          // 検索結果のヒット数を変数に保存
          result_num = threadInfo.resp_num;

          // 検索結果が0件
          if (result_num <= 0) {
            var str = '<p class="search_result_title">検索結果がありません</p>';
            thread.append(str);
          }

          // 検索結果が1件以上
          else {
            // 検索結果を新しい順に一覧表示
            for (var i = result_num - 1;i >= 0;i--) {
              var result_title = "";                      // 検索結果のリンク
              var title = threadInfo.resp_data[i].title;  // 検索結果のタイトル
              var num = threadInfo.resp_data[i].num;      // 検索結果一件の投稿数
              var id = threadInfo.resp_data[i].ID;        // 検索結果一件のthreadID
              var url = 'html/view.html?threadID=' + id + '&num=' + num + '&title=' + encodeURIComponent(title);

              // 検索にヒットしたthreadIDを配列に保存
              result_ids.push(id)

              result_title += '<div class="search_result_title">';
              result_title += '<a href="' + url + '">' + title + '(' + num + ')</a>';
              result_title += '</div>';
              result_title += '<div id="first_content' + id + '"></div>';  // 検索結果の1つ目の投稿を表示するエリアを作成
              thread.append(result_title);
            }
          }
        }

        // 検索にヒットしたスレッドの1件目の投稿を表示
        for (var i = 0;i < result_num;i++) {
          dispFirstContent(result_ids[i]);
        }
      });

    }
  });
});
