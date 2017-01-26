(function ($) {
    function galleryResize() {
        var heightEl = 0;
        $('.portfolio-wrapper').each(function () {
            $widthEl = $('.portfolio-element:nth-child(2)').width();
			
			if (!$widthEl) $widthEl = 300;
            
			heightEl = Math.floor($widthEl / 0.879);
            $('.portfolio-element').height(heightEl);
        });
    }

    galleryResize();
    $(window).load(function () {
        $('.flex-main-slider').flexslider({
            animation: "slide",
            directionNav: false,
            smoothHeight: true,
            slideshow: false
        });
    });
    $(window).resize(function () {
        galleryResize();
    });
})(jQuery);

