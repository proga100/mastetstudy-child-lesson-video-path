(function($) {

    // Fixed header class
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
    
        if (scroll >= 1) {
            $('.header').addClass('sticky');
        } else {
            $('.header').removeClass('sticky');
        }
    });

    // Mobile menu
    $('.mobile-menu__toggle').click(function() {
        $(this).toggleClass('active');
        $('.menu').toggleClass('opened');
    });

    $('.menu ul li a').click(function() {
        $('.menu').removeClass('opened');
    });

    // Testimonials slider
    $('#testimonials_slider').owlCarousel({
        loop: true,
        autoplay: false,
        autoplaySpeed: 1000,
        items: 1,
        center: true,
        margin: 30,
        nav: true,
        dots: false,
        navContainer: '#testimonials_slider_nav',
        
        responsive:{
            0:{
                autoWidth: false,
                touchDrag  : true,
                mouseDrag  : true,
                stagePadding: 15,
            },
            576:{
                autoWidth: true,
                touchDrag  : false,
                mouseDrag  : false,
            },
            768:{
                autoWidth: true,
                touchDrag  : false,
                mouseDrag  : false,
            },
            992:{
                autoWidth: true,
                touchDrag  : false,
                mouseDrag  : false,
            }
        }
    })

    // Video inside bootstrap modal
    $(document).ready(function() {
        $('#youtubeVideo_1').on('hidden.bs.modal', function() {
            var $this = $(this).find('iframe'),
            tempSrc = $this.attr('src');
            $this.attr('src', "");
            $this.attr('src', tempSrc);
        });

        $('#html5Video').on('hidden.bs.modal', function() {
            var html5Video = document.getElementById("htmlVideo");
            if (html5Video != null) {
                html5Video.pause();
                html5Video.currentTime = 0;
            }
        });
    });

})(jQuery);