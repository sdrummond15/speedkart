jQuery(document).ready(function ($) {

    $(window).resize(function (r) {
        var imagePilot = $('.detail_imgkart');
        var tam = 0;

        imagePilot.each(function () {
            var tamLi = $(this).width();
            if (tamLi > tam) {
                tam = tamLi;
            }
        });

        $('.detail_imgkart').height(Math.floor(tam * 0.9));
    });


});