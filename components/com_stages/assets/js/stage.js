jQuery(document).ready(function ($) {

    $(window).resize(function (r) {
        var imageStage = $('.img_best');
        var tam = 0;

        imageStage.each(function () {
            var tamLi = $(this).width();
            if (tamLi > tam) {
                tam = tamLi;
            }
        });

        $('.img_best').height(Math.floor(tam));
    });


});