document.onreadystatechange = function () {
    if (document.readyState == "complete") {
        console.log(document.readyState)
        $("#preloader").hide();
        $('body').css('overflow', 'scroll');
    }
}