(function ($) {
    "use strict";

    /* Open window function */
    window.iwOpenWindow = function (url) {
        window.open(url, 'sharer', 'toolbar=0,status=0,left=' + ((screen.width / 2) - 300) + ',top=' + ((screen.height / 2) - 200) + ',width=650,height=380');
        return false;
    }

    /**  Equal height for list items   */
    window.equalHeight = function(container){
        var maxHeight = 0;
        $(container).each(function() {
            var $el = $(this);
            if($el.height() > maxHeight){
                maxHeight = $el.height();
            }
        })
        $(container).height(maxHeight);
    }

    /** theme prepare data */

    function theme_init() {
        $('.iw-button-effect .effect').each(function () {
            $(this).attr('data-hover', $(this).text());
        });
        $('.header .search-form .search-wrap span').on('click', function () {
            if($(this).parents('.display-search-box').length && $(this).prev().val() ){
                $(this).parents('form').submit();
            }else{
                $('.header .search-form-header').toggleClass('display-search-box');
                $('.header .search-form-header input').focus();
            }
        });

        /** hash link scroll */
        $('.wrapper a').on('click', function (e) {
            var anchor = $(this).attr('href');
            if (anchor) {
                anchor = anchor.substr(anchor.indexOf('#'));
                if (!$(this).hasClass('ui-tabs-anchor') && anchor.indexOf('#') >= 0 && $(anchor).length && !$(anchor).hasClass('vc_tta-panel')) {
                    var top = $(anchor).offset().top;
                    $('html, body').animate({
                        scrollTop: top - 90
                    }, 'slow');
                    e.preventDefault();
                } else {
                    if (anchor == '#') {
                        e.preventDefault();
                    }
                }
            }
        });
        if (typeof ($.fn.arctext) == 'function') {
            $('.iw-heading.style2 .iwh-title').arctext({radius: 3000});
        }
        if (typeof ($.fn.select2) == 'function') {
            $('.wpcf7-form select').select2();
            $('.sort-by select').select2();
        }
		
		$('.wpcf7-form .form-button-submit').on('click',function(e){
				$(this).parents('form').submit();
		});

    }


    /**
     * Woocommerce increase/decrease quantity function
     */
    function woocommerce_init() {
        var clickOutSite = false;

        window.increaseQty = function (el, count) {
            var $el = $(el).parent().find('.qty');
            $el.val(parseInt($el.val()) + count);
        }
        window.decreaseQty = function (el, count) {
            var $el = $(el).parent().find('.qty');
            var qtya = parseInt($el.val()) - count;
            if (qtya < 1) {
                qtya = 1;
            }
            $el.val(qtya);
        }
        var owl = $(".product-detail .product-essential .owl-carousel");
        owl.owlCarousel({
            direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
            items: 5,
            itemsDesktopSmall: [979, 5],
            itemsTablet: [768, 4],
            itemsTabletSmall: false,
            itemsMobile: [479, 3],
            pagination: false,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        });

        /** Quick view product */
        var buttonHtml = '';
        $('.quickview').on('click', function (e) {
            var el = this;
            buttonHtml = $(el).html();
            $(el).html('<i class="quickviewloading fa fa-cog fa-spin"></i>');
            var effect = $(el).find('input').val();
            Custombox.open({
                target: woocommerce_params.ajax_url + '?action=load_product_quick_view&product_id=' + el.href.split('#')[1],
                effect: effect ? effect : 'fadein',
                complete: function () {
                    $(el).html(buttonHtml);
                    var owl = $(".quickview-box .product-detail .product-essential .owl-carousel");
                    owl.owlCarousel({
                        direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
                        items: 4,
                        itemsDesktopSmall: [979, 5],
                        itemsTablet: [768, 4],
                        itemsTabletSmall: false,
                        itemsMobile: [479, 3],
                        pagination: false,
                        navigation: true,
                        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    });
                    $(".quickview-body .next").click(function () {
                        owl.trigger('owl.next');
                    })
                    $(".quickview-body .prev").click(function () {
                        owl.trigger('owl.prev');
                    });
                    $(".quickview-body .woocommerce-main-image").click(function (e) {
                        e.preventDefault();
                    })
                    $(".quickview-body .owl-carousel .owl-item a").click(function (e) {
                        e.preventDefault();
                        if ($(".quickview-body .woocommerce-main-image img").length == 2) {
                            $(".quickview-body .woocommerce-main-image img:first").remove();
                        }
                        $(".quickview-body .woocommerce-main-image img").fadeOut(function () {
                            $(".quickview-body .woocommerce-main-image img").stop().hide();
                            $(".quickview-body .woocommerce-main-image img:last").fadeIn();
                        });
                        $(".quickview-body .woocommerce-main-image").append('<img class="attachment-shop_single wp-post-image" style="display:none;" src="' + this.href + '" alt="">');

                    })
                },
                close: function () {
                    $(el).html(buttonHtml);
                }
            });
            e.preventDefault();

        });

        $('.add_to_cart_button').on('click', function (e) {
            if ($(this).find('.fa-check').length) {
                e.preventDefault();
                return;
            }
            $(this).addClass('cart-adding');
            $(this).html('<i class="fa fa-cog fa-spin"></i>');

        });

        $('.add_to_wishlist').on('click', function (e) {
            if ($(this).find('.fa-check').length) {
                e.preventDefault();
                return;
            }
            $(this).addClass('wishlist-adding');
            $(this).find('i').removeClass('fa-star').addClass('fa-cog fa-spin');
        });

        $('.yith-wcwl-add-to-wishlist').appendTo('.add-to-box');
        $('.yith-wcwl-add-to-wishlist .link-wishlist').appendTo('.add-to-box form.cart');
        if ($('.variations_form .variations_button').length) {
            $('.yith-wcwl-add-to-wishlist .link-wishlist').appendTo('.variations_form .variations_button');
        }

        //trigger events add cart and wishlist
        $('body').on('added_to_wishlist', function () {
            $('.wishlist-adding').html('<i class="fa fa-check"></i>');
            $('.wishlist-adding').removeClass('wishlist-adding');
        });

        $('body').on('added_to_cart', function (e, f) {
            $('.added_to_cart.wc-forward').remove();
            // $('.cart-adding i').remove();
            //$('.cart-adding').removeClass('cart-adding');
            $('.cart-adding').html('<i class="fa fa-check"></i>');
            $('.cart-adding').addClass('cart-added');
            $('.cart-adding').removeClass('cart-adding');
        });

        /**
         * submitProductsLayout
         */
        window.submitProductsLayout = function (layout) {
            $('.product-category-layout').val(layout);
            $('.woocommerce-ordering').submit();
        }
    }

    /**
     * Carousel social footer
     */
    function carousel_init() {
        $(".owl-carousel").each(function () {
            var slider = $(this);
            var defaults = {
                direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
                paginationSpeed : 500,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            }
            var config = $.extend({}, defaults, slider.data("plugin-options"));
            // Initialize Slider
            slider.owlCarousel(config).addClass("owl-carousel-init");
        });

        $('.post-gallery .gallery,.post-text .gallery').each(function () {
            var galleryOwl = $(this);
            var classNames = this.className.toString().split(' ');
            var column = 1;
            $.each(classNames, function (i, className) {
                if (className.indexOf('gallery-columns-') != -1) {
                    column = parseInt(className.replace(/gallery-columns-/, ''));
                }
            });
            galleryOwl.owlCarousel({
                direction: $('body').hasClass('rtl') ? 'rtl' : 'ltr',
                items: column,
                singleItem: false,
                navigation: true,
                pagination: false,
                navigationText: ["<i class=\"fa fa-arrow-left\"></i>", "<i class=\"fa fa-arrow-right\"></i>"],
                autoHeight: true
            });
        });


    }

    /**
     parallax effect */
    function parallax_init() {
        $('.iw-parallax').each(function () {
            $(this).css({
                'background-repeat': 'no-repeat',
                'background-attachment': 'fixed',
                'background-size': '100% auto',
                'overflow': 'hidden'
            }).parallax("50%", $(this).attr('data-iw-paraspeed'));
        });
        $('.iw-parallax-video').each(function () {
            $(this).parent().css({"height": $(this).attr('data-iw-paraheight'), 'overflow': 'hidden'});
            $(this).parallaxVideo("50%", $(this).attr('data-iw-paraspeed'));
        });
    };

    /**
     * Sticky Menu
     */

    function sticky_menu(){

        /** menu append logo to middle */
        if($('.middle-logo').length) {
            var eq = Math.ceil($('.middle-logo ul.iw-nav-menu > li').length /2) - 1;
            $('.middle-logo ul.iw-nav-menu > li:eq("' + eq + '")').after($('.middle-logo .logo'));
            $(window).on('load', function () {
                var headerWidth = $('.header').width();
                var middleLogo = $('.middle-logo .logo img:visible');
                if(middleLogo.length){
                    var offsetX = middleLogo.offset().left;
                    var marginLeft = parseInt((headerWidth-offsetX*2)) -  middleLogo.width();
                    $('.middle-logo ul.iw-nav-menu').css('margin-left', marginLeft+'px');
                }
            });
        }
        var $windows_width = $(window).width();
        //if($windows_width > 991){
            var $header = $(".header-sticky"),
                $clone = $header.before($header.clone().addClass("clone"));
            $(window).on("scroll", function() {
                var fromTop = $(document).scrollTop();
                $('body').toggleClass("down", (fromTop > 200));
            });
       // }
    }

    /*** RUN ALL FUNCTION */
    /*doc ready*/
    $(document).ready(function () {
        sticky_menu();
        woocommerce_init();
        parallax_init();
        theme_init();
        carousel_init();

        /*** fit video */
        $(".fit-video").fitVids();
    });

    /*window loaded */
    $(window).on('load', function () {

        /** init parallax*/
        parallax_init();

        /** comparision slider*/
        if (typeof ($.fn.twentytwenty) == 'function') {
            $(".comparision-slider").twentytwenty({default_offset_pct: 0.5});
        }
    });

})(jQuery);

