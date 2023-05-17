jQuery(document).ready(function ($) {

    $(window).resize(function (r) {
        var imagePilot = $('.pilotimg');
        var tam = 0;

        imagePilot.each(function () {
            var tamLi = $(this).width();
            if (tamLi > tam) {
                tam = tamLi;
            }
        });

        $('.pilotimg').height(Math.floor(tam));
    });


});