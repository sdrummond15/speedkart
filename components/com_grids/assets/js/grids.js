jQuery(document).ready(function ($) {

    $(window).resize(function (r) {
        var imageGrid = $('.photo');
        var tam = 0;

        imageGrid.each(function () {
            var tamLi = $(this).width();
            if (tamLi > tam) {
                tam = tamLi;
            }
        });

        $('.photo').height(Math.floor(tam));
    });

});