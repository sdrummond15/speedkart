jQuery(document).ready(function ($) {

    $(window).resize(function (r) {
        var imageStage = $('.img_kartodromo');
        var tam = 0;

        imageStage.each(function () {
            var tamLi = $(this).width();
            if (tamLi > tam) {
                tam = tamLi;
            }
        });

        $('.img_kartodromo').height(Math.floor(tam * 0.7));
    });

    $(window).resize(function (r) {
        var imageStage = $('.img_podio');
        var tam = 0;

        imageStage.each(function () {
            var tamLi = $(this).width();
            if (tamLi > tam) {
                tam = tamLi;
            }
        });

        $('.img_podio').height(Math.floor(tam * 0.7));
    });


});