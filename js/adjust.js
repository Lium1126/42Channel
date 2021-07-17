function AutoLink(str) {
    var regexp_url = /((h?)(ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+))/g; // ']))/;  // URL文字列の正規表現
    var regexp_makeLink = function(all, url, h, href) {
        return '<a href="h' + href + '" target="_blank">' + url + '</a>';
    }

    return str.replace(regexp_url, regexp_makeLink);
}

function AutoNextLine(str) {
    const next_line = new RegExp(/\n/gi);
    return str.replace(next_line, '<br>')
}

function AutoMention(str) {
    // 「>>数字」を見つけたら、それに「#content数字」にジャンプするリンクを貼る
    // <a href="#content7" onclick="scroll用関数"> <= idがcontent7の要素に飛ぶ
    // *scroll用関数は、idが渡されたものに対して、ヘッダ分ずらした位置までスクロールするような関数

    // 1.「>>数字」を見つける正規表現を準備
    var regexp_mention = /&gt;&gt;[0-9]+/;  // メンションの正規表現

    // 2.AutoLink()を参考に、1の正規表現にマッチするところをaタグで囲む
    var regexp_makeMention = function(mention) {
        // mention:ex)"&gt;&gt;9"
        var id = mention.substring(8);  // mentionから数字(ID)を抽出

        return '<a href="#content' + id + '" onclick="scrollMention(this)">' + mention + '</a>';
    }

    // 3.replaceしたstrを返す
    return str.replace(regexp_mention, regexp_makeMention);
}
