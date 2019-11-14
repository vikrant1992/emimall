/*  Copyright (c) BFL (bajaj finserv limited), India */

require(['jquery', 'jquery/jquery-storageapi'], function ($) {
    $.cookieStorage.set('mage-messages', '');
    /**** Start Whishlist ***/
    var tips;
    $(document).on('click', '.a_wishPro', function () {
        clearTimeout(tips);
        var product_id = 0;
        $('.wishlistTips p').html('');

        var rawData = $(this).attr('data-href');
        product_id = $(this).attr('data-id');
        var parsedData = JSON.parse(rawData);
        var url = parsedData.action;
        var currentwish = $(this);
        var data1 = {
            form_key: $.cookie('form_key'),
            product: product_id,
            uenc: parsedData.data.uenc,
            item: parsedData.data.item
        }

        if ($(this).children('i').hasClass('fa-heart-o')) {
            $.ajax({
                url: url,
                type: 'POST',
                data: data1,
                showLoader: true,
                success: function (data) {
                    if (data.success == true) {
                        var wlremoveUrlRaw = '{"action": "' + window.wishlist_remove_url + '", "data": {"uenc": "","product":"' + parsedData.data.product + '", "item": "' + data.item + '"}}';
                        $(currentwish).children('i').removeClass('fa-heart-o');
                        $(currentwish).children('i').addClass('fa-heart');
                        $('.wishlistTips').html('<p>' + data.message + '</p>');
                        $(currentwish).attr('data-href', wlremoveUrlRaw);
                        $('.wishlistTips').fadeIn();
                    } else {
                        /***
                         * Start Fixes : EMMS-626
                         ***/
                        if (data.error_reason == 'customer_not_found') {
                            $("#j_headerLoginPop.j_loginPop").addClass("j_showpopup");
                            $(".a_emi_header .topfHeader .a_rightnotiPop > button").trigger("click");
                        } else {
                            $('.wishlistTips').html('<p>' + data.message + '</p>');
                            $('.wishlistTips').fadeIn();
                        }
                    }
                }
            });
        } else {

            $.ajax({
                url: url,
                type: 'POST',
                data: data1,
                showLoader: true,
                success: function (resp) {
                    if (resp.success == true) {
                        var wladdUrlRaw = '{"action": "' + window.wishlist_add_url + '", "data": {"uenc": "", "product": "' + product_id + '"}}';
                        $(currentwish).children('i').removeClass('fa-heart');
                        $(currentwish).children('i').addClass('fa-heart-o');
                        $('.wishlistTips').html('<p>' + resp.message + '</p>');
                        $(currentwish).attr('data-href', wladdUrlRaw);
                        $('.wishlistTips').fadeIn();
                    } else {
                        if (resp.error_reason == 'customer_not_found') {
                            $("#j_headerLoginPop.j_loginPop").addClass("j_showpopup");
                            $(".a_emi_header .topfHeader .a_rightnotiPop > button").trigger("click");
                        } else {
                            $('.wishlistTips').html('<p>' + resp.message + '</p>');
                            $('.wishlistTips').fadeIn();
                        }
                    }

                }

            });
        }

        tips = setTimeout(function () {
            $('.wishlistTips').fadeOut();
        }, 2000);

    });
    /**** End Whishlist ***/

    /**** Footer Start ***/
    $('.footer.content .colapsFoot').click(function () {
        $(this).toggleClass('active');
        $(this).siblings('.footer.content .footerWhite').slideToggle();
        $(this).siblings('.footer.content .backtop').slideToggle();
        $(this).siblings('.footer.content .footerDark').slideToggle();

        $('html, body').animate({scrollTop: $('.footer.content .colapsFoot').offset().top - 60}, 500);


    });

    $('.footer.content .backtop a').click(function () {
        $('html, body').animate({scrollTop: 0}, 500);
    });
    /**** Footer END ***/

    /**** TnC Start ***/
    $(document).ready(function () {
        $('.cms-terms-and-conditions .p_termcondition .p_termconditiondeta .p_termtebs ul li a, .cms-privacy-policy .p_termcondition .p_termconditiondeta .p_termtebs ul li a, .cms-disclaimer .p_termcondition .p_termconditiondeta .p_termtebs ul li a, .cms-grievance-redressal .p_termcondition .p_termconditiondeta .p_termtebs ul li a').click(function () {
            $(this).addClass('active');
            $(this).parent().siblings().children('a').removeClass('active');
            var getoffdet = 0;
            $(this).parent().prevAll().each(function () {
                getoffdet = getoffdet + $(this).width();
            });
            $(".p_termcondition .p_termconditiondeta .p_termtebs ul").animate({scrollLeft: getoffdet}, 300);

        });
        $('.p_termcondition .p_termalldetatext .p_termlinks ul li a, .cms-privacy-policy .p_termcondition .p_termalldetatext .p_termlinks ul li a, .cms-disclaimer .p_termcondition .p_termalldetatext .p_termlinks ul li a, .cms-grievance-redressal .p_termcondition .p_termalldetatext .p_termlinks ul li a').click(function () {
            var getdata = $(this).attr('data-tab');
            $('html, body').animate({
                scrollTop: $("#" + getdata).offset().top - 40
            }, 500);
        });
        /*scroll-top*/
        if ($('.a_scrollUpAllever').length > 0) {
            $(window).scroll(function () {
                var getwimS = $(this).scrollTop();
                if (getwimS >= 50) {
                    $('.a_scrollUpAllever').addClass('a_scrollUpAlleverShow');
                } else {
                    $('.a_scrollUpAllever').removeClass('a_scrollUpAlleverShow');
                }

            });
        }

        $('.a_scrollUpAllever').click(function () {
            $('html,body').animate({
                scrollTop: 0
            }, 200);
        });
        /*scroll-top-end*/
    });
    /**** TnC END ***/

    /*emi-network-page*/
    $('.j_faqSec .j_padd .j_faqDiv .j_fullWfaq .j_faqSlide .j_sepSlide a').click(function () {
        $(this).siblings('p').slideToggle(200);
        $(this).find('i').toggleClass('fa-plus fa-minus');
    });

    $(".cms-emi-network .j_emiCardStep .j_padd .j_secfull .j_findStore .j_storeFull #emiFindStore").click(function (e) {
        var baseUrl = window.location.origin;
        var url = baseUrl + "/storelocator/index/session";
        $.ajax({
            showLoader: true,
            url: url,
            data: {
                findStore: 'findStore'
            },
            dataType: 'json',
            type: "POST",
            success: function (data) {
                e.stopPropagation();
                if (data.isLoggedIn == false) {
                    if ($(window).width() > 767) {
                        $("#j_headerLoginPop.j_loginPop").addClass("j_showpopup");
                        $(".a_emi_header .topfHeader .a_rightnotiPop > button").trigger("click");
                    } else {
                        $(".a_emi_header .topfHeader .getAmount > button").trigger("click");
                    }
                } else {
                    window.location.href = baseUrl + '/storelocator';
                }
            }
        });
    });

});
