function appendImage(imgPath, target) {

    var element = new Image() ;

    element.onload = function () {
        var img = '<a href="' + imgPath + '" rel="lightbox"><img src="' + imgPath + '" ';

		if (element.naturalWidth > element.naturalHeight) {  // 横長画像の場合
            img += 'width="100"';
        } else {
            img += 'height="100"';
        }

        img += '></a>';

        target.append(img);

        var obj = $("#thread_area");
        moveFooter(obj.height(), obj[0].offsetTop);
    }

    element.src = imgPath;
}
