jQuery(document).ready(function ($) {

    $(window).resize(function (r) {
        var imageStage = $('.circuitimg');
        var tam = 0;

        imageStage.each(function () {
            var tamLi = $(this).width();
            if (tamLi > tam) {
                tam = tamLi;
            }
        });

        $('.circuitimg').height(Math.floor(tam * 0.7));
    });


});