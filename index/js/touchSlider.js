$.fn.touchSlider = function (imgWidth, imgHeight, autoScroll, interval) {
    var aspectRatio = imgWidth / imgHeight;
    var contain, content, contentLength, _width, _height, timer;
    var touchSX, touchSY, touchEX, touchEY, d1scrollLeft;
    var isDrag = false;
    var currindex = 0;
    contain = $(this);
    content = contain.find(".content");
    contentLength = content.find("li").length;

    //≥ı ºªØnumber
    var numberUl = $("<ul class='number'></ul>");
    contain.append(numberUl);
    for (var i = 0; i < contentLength; i++) {
        numberUl.append($("<li>" + (i + 1) + "</li>"));
    }

    $(window).bind("load resize", function () {
        _width = contain.width();
        _height = _width / aspectRatio;
        contain.css({ "height": _height + "px" });
        content.find("ul").css({ "width": _width * contentLength + "px" })
        content.find("img").css({ "width": _width + "px", "height": _height + "px" })
        content.scrollLeft(_width * currindex);
    })
    contain.bind("touchstart mousedown", function (e) {
        isDrag = true;
        touchSX = e.pageX || e.originalEvent.touches[0].pageX;
        touchSY = e.pageY || e.originalEvent.touches[0].pageY;
        d1scrollLeft = content.scrollLeft();
    })
    contain.bind("touchmove mousemove", function (e) {
        if (isDrag) {
            e.preventDefault();
            touchEX = e.pageX || e.originalEvent.touches[0].pageX;
            touchEY = e.pageY || e.originalEvent.touches[0].pageY;
            content.scrollLeft(d1scrollLeft - touchEX + touchSX);
        }
    })
    contain.bind("touchend mouseup", function (e) {
        isDrag = false;
        if (touchEX < touchSX && currindex < contentLength - 1) {
            _scroll(currindex + 1);
        } else if (touchEX > touchSX && currindex > 0) {
            _scroll(currindex - 1);
        }
    })
    function _scroll(scrollIndex) {
        clearTimeout(timer);
        if (scrollIndex > contentLength - 1) {
            scrollIndex = 0;
        }
        if (scrollIndex <= 0) {
            scrollIndex = 0;
        }
        currindex = scrollIndex;
        content.animate({ scrollLeft: _width * currindex }, "", "", function () {
            numberUl.find("li").eq(currindex).addClass("current").siblings("li").removeClass("current");
        })
        if (autoScroll) {
            timer = setTimeout(function () { _scroll(currindex + 1); }, interval);
        }
    }
    _scroll(currindex);
    if (autoScroll) {
        timer = setTimeout(function () { _scroll(currindex + 1); }, interval);
    }
}