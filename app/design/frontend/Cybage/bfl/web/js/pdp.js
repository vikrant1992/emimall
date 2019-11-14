/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/******************* start pdp***************************/

require(['jquery', "mage/url", "slick", ], function ($, url) {
    $(document).ready(function () {
        window.dataLayer = window.dataLayer || [];
        $('.slider-nav').slick({
            slidesToShow: 5,
            asNavFor: '.slider-main',
            vertical: true,
            infinite: false,
            focusOnSelect: true,
            arrows: true,
            autoplay: false,
            //centerMode: true
        });
        if ($(window).width() > 767) {
            $('.slider-main').slick({
                slidesToShow: 1,
                arrows: true,
                asNavFor: '.slider-nav',
                vertical: false,
                infinite: false,
                autoplay: false,
                dots: false,
                verticalSwiping: false,
                //centerMode: true
            });
        } else {
            $('.slider-main').slick({
                slidesToShow: 1,
                arrows: false,
                asNavFor: '.slider-nav',
                vertical: false,
                infinite: false,
                autoplay: false,
                dots: true,
                verticalSwiping: false,
                //centerMode: true
            });
        }

        if ($(window).width() > 768) {
            $('.exprtreview').slick({
                dots: false,
                infinite: false,
                speed: 300,
                arrows: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: false,
                            arrows: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            dots: false,
                            arrows: false
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1.1,
                            slidesToScroll: 1,
                            dots: false,
                            arrows: false
                        }
                    }
                ]
            });
        }
        if ($(window).width() > 768) {
            $('.catalog-product-view .p_iphoneside').each(function () {
                $(this).not('.slick-initialized').slick({
                    dots: false,
                    infinite: false,
                    speed: 300,
                    arrows: true,
                    slidesToShow: 5.1,
                    slidesToScroll: 1,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 8,
                                slidesToScroll: 1,
                                infinite: false,
                                dots: false
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }

                    ]
                });
            });
        }

        $('.j_pdpFullWidth #p_rightdesignpdp .j_proConsTb .j_tbBor li').click(function () {
            $(this).addClass('active');
            $(this).siblings().removeClass('active');

            var getData = $(this).children('a').attr('data-tab');
            $('#' + getData).fadeIn();
            $('#' + getData).siblings().fadeOut(0);

            var getoffdet = 0;
            $(this).prevAll().each(function () {
                getoffdet = getoffdet + $(this).width();
            });
            $(".p_pdpdesign .p_rightsidesesign .p_expreview .p_expertreviewteb .p_tebreviewdesign ul").animate({scrollLeft: getoffdet}, 300);
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_pdpram .p_rambtn ul li a:not(.disable)').click(function () {
            $(this).parent().addClass('active');
            $(this).parent().siblings().removeClass('active');

            var getram = $(this).attr('data-ram');
            $('.j_pdpFullWidth #p_rightdesignpdp .p_pdpram .P_ramtitle p').text(getram);
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_storege .p_storegebtn ul li a:not(.disable)').click(function () {
            $(this).parent().addClass('active');
            $(this).parent().siblings().removeClass('active');

            var getstrg = $(this).attr('data-strg');
            $('.j_pdpFullWidth #p_rightdesignpdp .p_storege .p_storegtitle p').text(getstrg);
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_colors .p_colortyps ul li:not(.disable) a').click(function () {
            $(this).parent().addClass('active');
            $(this).parent().siblings().removeClass('active');

            var getClr = $(this).attr('data-clr');
            $('.j_pdpFullWidth #p_rightdesignpdp .p_colors .p_colortitle p').text(getClr);
        });

        $(function () {
            $('.j_pdpFullWidth #p_rightdesignpdp .p_productdescription a').on("click", function () {
                var txt = $('.j_pdpFullWidth #p_rightdesignpdp .p_productdescription p').text();
                if ($('.j_pdpFullWidth #p_rightdesignpdp .p_productdescription p').hasClass('hgtauto')) {
                }
                if ($(this).hasClass("expand")) {
                    $(this).removeClass("expand").addClass("reset").text("More");
                    $('.j_pdpFullWidth #p_rightdesignpdp .p_productdescription p').removeClass('heightvictra');
                } else {
                    $(this).removeClass("reset").addClass("expand").text("Less");
                    $('.j_pdpFullWidth #p_rightdesignpdp .p_productdescription p').addClass('heightvictra');
                }
            });
        });

        $('.prodDesPdp .p_productdescription p').each(function () {
            if ($(this).text().length < 150) {
                $(this).siblings('a').hide();
            }
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_productspeci .p_productone a').click(function () {
            $(this).siblings('.p_genreltabel').slideToggle(200);
            $(this).toggleClass('active');
            $(this).find('i').toggleClass('fa-plus fa-minus');
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_pdpfaqs .p_faqsdata .p_faqsdesign a').click(function () {
            $(this).siblings('p').slideToggle(200);
            $(this).find('i').toggleClass('fa-plus fa-minus');
        });

        if ($(window).width() > 768) {
            function scrollThree() {
                var $sticky = $('.product.media');
                if (!!$sticky.offset()) {
                    var generalSidebarHeight = $sticky.outerHeight();
                    var stickyTop = $sticky.offset().top;
                    var stickOffset = 0;
                    $(window).scroll(function () {
                        var windowTop = $(window).scrollTop();
                        var $stickyrStopper = $('.p_compaermobilespdp');
                        var stickyStopperPosition = $stickyrStopper.offset().top;
                        var stopPoint = stickyStopperPosition - generalSidebarHeight - stickOffset;
                        var diff = stickyStopperPosition - generalSidebarHeight - 1;

                        if (stopPoint + 0 < windowTop) {
                            $sticky.css({position: 'absolute', top: diff + 0});
                        } else if (stickyTop < windowTop + stickOffset) {
                            $sticky.css({width: '50%', position: 'fixed', top: stickOffset, left: '0px'});
                        } else {
                            if ($(window).width() > 1439) {
                                $sticky.css({position: 'static', top: 'initial', left: 'initial', width: '50%'});
                            } else {
                                $sticky.css({position: 'static', top: 'initial', left: 'initial', width: '50%'});
                            }
                        }
                    });
                }
            }
            setTimeout(function () {
                scrollThree();
            }, 500);
        }

        $('.swatch-option.color').click(function () {
            $('.swatch-option-dotted').addClass('borderActive');
        });

        $('.shreTrans .S_midle .s_whiteBack .S_closepart a').click(function () {
            $(this).parents('.shreTrans').hide();
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_iconswshilist ul li a.a_shareIcon').click(function () {
            $('.shreTrans').show();
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_shareandcompere .p_btnrows .p_sharesbtn a.shareMob').click(function () {
            $('.shreTrans').addClass('shreTransShow');
            $('.shreTrans .S_midle').addClass('S_midleShow');
            $('body').css('overflow-y', 'hidden');
        });

        $('.shreTrans').click(function () {
            $('.shreTrans').removeClass('shreTransShow');
            $('.shreTrans .S_midle').removeClass('S_midleShow');
            $('body').css('overflow-y', 'scroll');
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .p_pdptitles .p_Emifrom .p_emileftfrom a').click(function () {
            $('.j_pdpFullWidth #p_rightdesignpdp .p_pdptitles .p_Emifrom .emiOptns').slideToggle(200);
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .j_commReviSec .j_viewAllLink a').click(function (e) {
            if ($(window).width() > 768) {
                e.preventDefault();
                $('.j_pdpFullWidth #p_rightdesignpdp .j_commReviSec .j_commReviBox.inactive').show();
            }
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .j_commReviSec .j_viewAllLink a').click(function (e) {
            if ($(window).width() < 767) {
                e.preventDefault();
                $('.reviewsMobile').addClass('showReviewsMobile');
                $('.j_pdpFullWidth #p_rightdesignpdp .reviewsMobile .rewueBox .j_commReviBox.active').show();
                $('.j_pdpFullWidth #p_rightdesignpdp .reviewsMobile .rewueBox .j_commReviBox.inactive').show();
            }
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .reviewsMobile .rewueBox .j_commReviSec .j_commReviBox > a').click(function () {
            $(this).siblings('p').toggleClass('heghtAuto');
            if ($(this).text() == 'More') {
                $(this).text('Less');
            } else {
                $(this).text('More');
            }
        });

        /*To hide more button when less char*/
        $('.expertRePdp .j_commReviSec .j_commReviBox p').each(function () {
            if ($(this).text().length < 135) {
                $(this).siblings('a').hide();
            }
        });

        /*video view all*/
        $('.j_pdpFullWidth #p_rightdesignpdp .j_videsec .videoViewAllLink a').click(function () {
            $('.j_pdpFullWidth #p_rightdesignpdp .j_videsec .j_commReviBox.inactive').show();
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .j_videsec .videoViewAllLink a').click(function () {
            $('.j_pdpFullWidth #p_rightdesignpdp .j_videsec .j_partVid.active').show();
            $('.j_pdpFullWidth #p_rightdesignpdp .j_videsec .j_partVid.inactive').show();
            $('.expertRePdp .videoViewAllLink a').hide();
        });

        $(".catalog-product-view #p_rightdesignpdp .expertRePdp .reviewsMobile .a_revHeader a").click(function (e) {
            $(".reviewsMobile").removeClass("showReviewsMobile");
        });

        $('.expertRePdp .sliderreves .slioneSec .j_videsec .j_slidSlid .j_partVid').click(function () {
            var videoUrl = $(this).attr('data-videourl');
            $(".pdp_iframe").each(function(index) {
               $(this).hide();
             });
            $('#'+videoUrl).show();
            $('.p_expertreviewpopup').show();
            $('body').css('overflow-y', 'hidden');
        });

        $('.p_expertreviewpopup .p_expertreviewpopupblack .p_videobackground .p_videoarea .p_videoclose a img').click(function () {
            $('.p_expertreviewpopup').hide();
            $('body').css('overflow-y', 'scroll');
            $(".pdp_iframe").each(function() {
                $(this)[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*')
            });
        });

        $('.expertRePdp .sliderreves .slioneSec .j_videsec .j_slidSlid .j_partVid .videoimg').click(function () {
            $('.p_expertreviewpopup').show();
            $('body').css('overflow-y', 'hidden');
        });
        /**/

        $(".catalog-product-view #j_headerLoginPop.j_loginPop .backHeader .a_backHeader").click(function (e) {
            $(".j_loginPop").removeClass("j_showpopup");
            $(".transparentBG").hide();
        });

        $('.p_pdpdesign p_rightsidesesign .p_expreview .p_rowexppdp .p_expreviewbox .p_expviewdesign a img').click(function () {
            $('.p_expertreviewpopup').show();
            $('body').css('overflow-y', 'hidden');
        });

        $('.p_expertreviewpopup .p_expertreviewpopupblack .p_videobackground .p_videoarea .p_videoclose a img').click(function () {
            $('.p_expertreviewpopup').hide();
            $('body').css('overflow-y', 'scroll');
        });
        $('.j_pdpFullWidth .product.media .p_pdpproductslider .p_prouductbigimg .j_proBckCol ul li .videoimg').click(function () {
            $('.p_expertreviewpopup').show();
            $('body').css('overflow-y', 'hidden');
        });
                
        /*fixed header menu hide when section not present*/
        $('.fullpageBar > ul > li >a').each(function(){
	var liVariable = $(this).attr('href');
            
            if ($(''+liVariable+'').length === 0 ) {
                $('.fullpageBar>ul>li>a[href="'+liVariable+'"]').closest('li').remove();
            } else {
                var innerlength = $(''+liVariable+'').html();
                if (innerlength.trim().length === 0 ) {
                    $('.fullpageBar>ul>li>a[href="'+liVariable+'"]').closest('li').remove();
                }
            }	
        });
        /**/
        
        $(".j_pdpFullWidth #p_rightdesignpdp .p_reviewpoint ul li .p_twomorereview").click(function () {
            $(".fullpageBar > ul > li > a[href='#experRew4']").trigger("click");
        });
        
        if ($('.topfHeader').length > 0) {
            var sortOfset = $('.topfHeader').offset().top;
            var oldiCurScrollPos = 0;
            $(window).scroll(function () {
                var win_scroll = $(this).scrollTop();
                if (win_scroll > sortOfset) {
                    $('.topfHeader').addClass('topfHeaderSticky');
                    $('.fullpageBar').addClass('stiky3bar');
                }

                if (win_scroll < oldiCurScrollPos) {
                    $('.topfHeader').removeClass('topfHeaderSticky');
                    $('.fullpageBar').removeClass('stiky3bar');
                }
                oldiCurScrollPos = win_scroll;
            });
        }

        if ($('.fullpageBar').length > 0) {
            var sections = [],
                    nav = $('.fullpageBar'),
                    nav_height = nav.outerHeight();
            $('.fullpageBar ul li').each(function () {
                sections.push($(this).children('a').attr('href'));
            });

            $(window).on('scroll', function () {
                var cur_pos = $(this).scrollTop();
                var crnttabSts = 0;
                for (var s = 0; s < sections.length; s++) {
                    if ($(sections[s]).length) {
                        var top = $(sections[s]).offset().top - nav_height - 40,
                                bottom = top + $(sections[s]).outerHeight();
                        if (cur_pos >= top && cur_pos <= bottom) {
                            crnttabSts = 1;
                            $('.fullpageBar ul li a').removeClass('active');
                            $('.fullpageBar ul li a[href="' + sections[s] + '"]').addClass('active');
                        } else {
                            if (crnttabSts == 0) {
                                $('.fullpageBar ul li a').removeClass('active');
                            }
                        }
                    }
                }
            });

            nav.find('a').on('click', function () {
                var $el = $(this),
                        id = $el.attr('href');
                $('html, body').animate({
                    scrollTop: $(id).offset().top - nav_height - 0
                }, 500);

                var getoffdet = 0;
                $(this).parent().prevAll().each(function () {
                    getoffdet = getoffdet + $(this).width();
                });
                $(".fullpageBar > ul").animate({scrollLeft: getoffdet}, 300);

                return false;
            });
        }

        if ($(window).width() < 768) {
            if ($('.product.media').length > 0) {
                var pageofset = $('.product.media').offset().top - 40;
                $(window).scroll(function () {
                    var winscroll = $(this).scrollTop();
                    if (pageofset < winscroll) {
                        $('.fullpageBar').show();
                    } else {
                        $('.fullpageBar').hide();
                    }
                });
            }
        }

        $('.a_notifyMe > a').click(function () {
            $(this).parent().hide();
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .j_verText .j_more').click(function () {
            $(this).siblings('p').toggleClass('heghtAuto');
            if ($(this).text() == 'More') {
                $(this).text('Less');
            } else {
                $(this).text('More');
            }
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .j_verText p').each(function () {
            if ($(this).text().length < 200) {
                $(this).siblings('.j_more').hide();
            }
        });

        $('.j_pdpFullWidth #p_rightdesignpdp .j_commReviSec .j_commReviBox > a').click(function () {
            $(this).siblings('p').toggleClass('heghtAuto');
            if ($(this).text() == 'More') {
                $(this).text('Less');
            } else {
                $(this).text('More');
            }
        });
        $('.rewueBox .j_commReviBox > a').click(function () {
            $(this).siblings('p').toggleClass('heghtAuto');
            if ($(this).text() == 'More') {
                $(this).text('Less');
            } else {
                $(this).text('More');
            }
        });

        /**
         * EDW
         */
        $('#pdp_getEMIOptions').one("click", function () {
            var modelCode = $('#modelcode').val();
            var indicativePrice = $('#hid_indicative_price').val();
            var edwUrl = url.build('edw');
            $.ajax({
                showLoader: true,
                url: edwUrl,
                data: {
                    model_code: modelCode,
                    indicativePrice: indicativePrice
                    },
                type: "POST",
                dataType: 'json'
            }).success(function (data) {
                $('#emioptionvalues').html(data.output);
            });
        });

        $('#copytoclipboard').click(function () {
           $('.wishlistTips').fadeIn();            
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('#product-url').val()).select();
            document.execCommand("copy");
            $temp.remove();
            $('.wishlistTips p').text("Copied the text: " + $('#product-url').val());
            /* Alert the copied text */
            tips = setTimeout(function () {
                $('.wishlistTips').fadeOut();
            }, 2000);
        });    

        /********** Start: Google Analytics code for PDP Page ************************************/
        /**
         * PPT: EMI_MALL_Login_Event_Version_1.ppt implementation : Screen-2 : Desktop
         * Get data layer code executed whenever someone click on 'Get your pre-approved offer' button in header
         */
        $("div .a_rightnotiPop button").click(function () {
            var pageTitle = $(document).find("title").text();
            var buttonText = $("div .a_rightnotiPop button").text();
            var customerId = '';
            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Nav_Click',
                'clickText': buttonText,
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': ''
            });
        });

        $(".viewCitypart").click(function () {
            var buttonText = $(".viewCitypart p").text();
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Nav_Click',
                'clickText': buttonText,
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': ''
            });
        });

        /**
         * PPT: EMI_MALL_Login_Event_Version_1.ppt implementation : Screen-3 : Desktop
         * Get data layer code executed whenever someone click on 'Get your pre-approved offer' button in header
         */
        $(".Subbutton").click(function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Login_PSTP',
                'clickText': 'Get OTP',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': ''
            });
        });
        /**
         * PPT: EMI MALL Track implementation : Screen-7 from Latest Version: PDP Find A Store
         */
//        $("div .p_callstores a").click(function () {
//            var linkUrl = url.build('customcatalog/product/getproduct');
//            var pageTitle = $(document).find("title").text();
//            var buttonText = $("div .a_rightnotiPop button").text();
//            var productId = $("div .price-final_price").data('productId');
//            var customerId = '';
//            if (productId) {
//                $.ajax({
//                    url: linkUrl,
//                    type: 'POST',
//                    data: {
//                        product_id: productId
//                    },
//                    showLoader: true,
//                    success: function (resp) {
//                        if (resp.success == true)
//                        {
//                            /**
//                             * PPT: EMI MALL Track implementation : Screen-7 from Latest Version: PDP Find A Store
//                             */
//                            dataLayer.push({
//                                'event': 'addToCart',
//                                'ecommerce': {
//                                    'currencyCode': resp.data['currency'],
//                                    'add': {
//                                        'products': [{
//                                                'name': resp.data['name'],
//                                                'id': resp.data['id'],
//                                                'price': resp.data['price'],
//                                                'brand': resp.data['brand'],
//                                                'category': resp.data['category'],
//                                                'variant': resp.data['variant'],
//                                                'quantity': 1,
//                                                'dimension11': 'PDP',
//                                            }]
//                                    }
//                                }
//                            });
//
//                            /**
//                             * PPT: EMI MALL Track implementation : Screen-8 from Latest Version: PDP Find A Store
//                             */
//                            dataLayer.push({
//                                'event': 'checkout',
//                                'ecommerce': {
//                                    'checkout': {
//                                        'actionField': {'step': 1, 'option': 'Visa'},
//                                        'products': [{
//                                                'name': resp.data['name'],
//                                                'id': resp.data['id'],
//                                                'price': resp.data['name'],
//                                                'brand': resp.data['price'],
//                                                'category': resp.data['category'],
//                                                'variant': resp.data['variant'],
//                                                'quantity': 1,
//                                                'dimension11': 'PDP'
//                                            }]
//                                    }
//                                }
//                            });
//                        }
//                    }
//                });
//            }
//
//        });



        /**
         * PPT: EMI_MALL_Track implementation : Screen-6 : Desktop
         * Get data layer code executed whenever someone click on 'Get your pre-approved offer' button in header
         */
        $("div .p_getproductpdp").click(function () {
            var linkUrl = url.build('customcatalog/product/getproduct');
            var mainProductId = $("div .price-final_price").data('productId');
            if (mainProductId) {
                $.ajax({
                    url: linkUrl,
                    type: 'POST',
                    data: {
                        product_id: mainProductId
                    },
                    showLoader: false,
                    success: function (resp) {
                        if (resp.success == true)
                        {
                            dataLayer.push({
                                'event': 'addToCart',
                                'ecommerce': {
                                    'currencyCode': resp.data['currency'],
                                    'add': {
                                        'products': [{
                                                'name': resp.data['name'],
                                                'id': resp.data['id'],
                                                'price': resp.data['name'],
                                                'brand': resp.data['price'],
                                                'category': resp.data['category'],
                                                'variant': resp.data['variant'],
                                                'quantity': 1,
                                                'dimension11': 'PDP'
                                            }]
                                    }
                                }
                            });
                        }
                    }
                });
            }
        });
        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-2 : Desktop
         * Get data layer code executed whenever someone click on 'Wishlist i.e. heart icon' button
         */

        $(".a_wishPro.action.towishlist.a_addwish").click(function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';
            var pId = $(this).attr("data-id");

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Nav_Com_Click',
                'clickText': 'Favourites_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickComparevalue': 'NA',
                'clickFavouritevalue': pId
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-2 : Desktop
         * Get data layer code executed whenever someone click on 'Share icon' button
         */

        $(".p_shareicon:first").click(function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Nav_Com_Click',
                'clickText': 'Share_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickComparevalue': 'NA',
                'clickFavouritevalue': 'NA'
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-2 : Desktop
         * Get data layer code executed whenever someone click on 'Compare icon' button
         */

        $(document).on("click", ".p_shareicon a img[alt='compare']", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';
            var pId = $(".a_wishPro.action.towishlist.a_addwish").attr("data-id");

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Nav_Com_Click',
                'clickText': 'Share_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickComparevalue': pId,
                'clickFavouritevalue': 'NA'
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-3 : Desktop
         * Get data layer code executed whenever someone clicks on side-images
         */

        $(document).on("click", ".fotorama__nav__shaft img", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';
            var pId = $(".a_wishPro.action.towishlist.a_addwish").attr("data-id");

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Gallery_Click',
                'clickText': 'Button_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickGalleryimage': pId
            });
        });


        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-4 : Desktop
         * Get data layer code executed whenever someone clicks on 'Find a Store' button
         */

        $(document).on("click", ".p_callstores a", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';
            var pId = $(".a_wishPro.action.towishlist.a_addwish").attr("data-id");

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Purchase_Click',
                'clickText': 'Find_a_Store',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': pId
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-4 : Desktop
         * Get data layer code executed whenever someone clicks on 'Buy Now' button
         */

        $(document).on("click", ".p_getproductpdp a", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';
            var pId = $(".a_wishPro.action.towishlist.a_addwish").attr("data-id");

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Purchase_Click',
                'clickText': 'Buy_Now',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': pId
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-5 : Desktop
         * Get data layer code executed whenever someone clicks on 'Similar Products : View All'
         */

        $(document).on("click", ".p_titlehome a", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Similar_Products_Click',
                'clickText': 'ViewAll',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': 'NA'
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-5 : Desktop
         * Get data layer code executed whenever someone clicks on 'Similar Products : Arrow-Sign'
         */

        $(document).on("click", ".slick-next.slick-arrow,.slick-prev.slick-arrow", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Similar_Products_Click',
                'clickText': 'Arrow_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': 'NA'
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-5 : Desktop
         * Get data layer code executed whenever someone clicks on 'Similar Products : Product-Click'
         */

        $(document).on("click", ".p_applebox.slick-slide", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Similar_Products_Click',
                'clickText': 'Product_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': 'NA'
            });
        });

        $(document).on("click", "#pdpcompare", function () {
            var rawData = $(this).attr('data-custompost');
            var compareurl = url.build('catalog/product_compare');
            if (rawData.trim() && rawData.length > 1) {

                var urlpath = JSON.parse(rawData).action;
                var data = {
                    form_key: $.cookie('form_key'),
                    product: JSON.parse(rawData).data.product,
                    uenc: JSON.parse(rawData).data.uenc
                }
                $.ajax({
                    url: urlpath,
                    type: 'POST',
                    data: data,
                    success: function (resp) {
                        console.log(resp);
                        if (resp.success == true)
                        {
                            var compareurl = url.build('catalog/product_compare')
                            $(this).attr('href', compareurl);
                            location.href = compareurl;
                        } else {
                            if (typeof (resp.message) != "undefined" && resp.message !== null) {
                                $(".wishlistTips p").text(resp.message);
                                $('.wishlistTips').fadeIn();
                                tips = setTimeout(function () {
                                    $('.wishlistTips').fadeOut();
                                }, 2000);
                            }
                        }
                    }
                });
            } else {
                location.href = compareurl;
            }
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-4 : Desktop
         * Get data layer code executed whenever someone clicks on 'Find a Store' button
         */

        $(document).on("click", ".p_callstores a", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';
            var pId = $(".a_wishPro.action.towishlist.a_addwish").attr("data-id");
            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Purchase_Click',
                'clickText': 'Find_a_Store',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': pId
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-4 : Desktop
         * Get data layer code executed whenever someone clicks on 'Buy Now' button
         */

        $(document).on("click", ".p_getproductpdp a", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';
            var pId = $(".a_wishPro.action.towishlist.a_addwish").attr("data-id");

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Purchase_Click',
                'clickText': 'Buy_Now',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': pId
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-5 : Desktop
         * Get data layer code executed whenever someone clicks on 'Similar Products : View All'
         */

        $(document).on("click", ".p_titlehome a", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Similar_Products_Click',
                'clickText': 'ViewAll',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': 'NA'
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-5 : Desktop
         * Get data layer code executed whenever someone clicks on 'Similar Products : Arrow-Sign'
         */

        $(document).on("click", ".slick-next.slick-arrow,.slick-prev.slick-arrow", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Similar_Products_Click',
                'clickText': 'Arrow_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': 'NA'
            });
        });

        /**
         * PPT: EMI MALL PDP_Version_1.ppt implementation : Screen-5 : Desktop
         * Get data layer code executed whenever someone clicks on 'Similar Products : Product-Click'
         */

        $(document).on("click", ".p_applebox.slick-slide", function () {
            var pageTitle = $(document).find("title").text();
            var customerId = '';
            var customerType = '';

            dataLayer.push({
                'pageTitle': pageTitle,
                'event': 'Similar_Products_Click',
                'clickText': 'Product_Click',
                'pageType': 'PDP',
                'customerID': customerId,
                'customerType': customerType,
                'clickPurchasevalue': 'NA'
            });
        });

        /**
         * PPT: EMI MALL Track implementation : Screen-10 from Latest Version: PDP Similar Product Click
         */
        $(document).on("click", ".slick-next.slick-arrow,.slick-prev.slick-arrow", function () {
            var linkUrl = url.build('customcatalog/product/getsimilarproduct');
            var mainProductId = $("div .price-final_price").data('productId');
            if (mainProductId) {
                $.ajax({
                    url: linkUrl,
                    type: 'POST',
                    data: {
                        product_id: mainProductId
                    },
                    showLoader: false,
                    success: function (resp) {
                        if (resp.success == true)
                        {
                            /**
                             * PPT: EMI_MALL_Track implementation : Screen-9 : Desktop
                             */
                            dataLayer.push({
                                'ecommerce': {
                                    'impressions': resp.data
                                }
                            });
                        }
                    }
                });
            }
        });
    });

    /**
     * PPT: EMI MALL Track implementation : Screen-5 from Latest Version
     */
    $(window).load(function () {
        var mainProductId = $("div .price-final_price").data('productId');
        var linkUrl = url.build('customcatalog/product/getproduct');
        if (mainProductId) {
            $.ajax({
                url: linkUrl,
                type: 'POST',
                data: {
                    product_id: mainProductId
                },
                showLoader: false,
                success: function (resp) {
                    if (resp.success == true)
                    {
                        /**
                         * PPT: EMI MALL Track implementation : Screen-8 from Latest Version: PDP Find A Store
                         */
                        dataLayer.push({
                            'ecommerce': {
                                'detail': {
                                    'actionField': {'list': 'Apparel Gallery'},
                                    'products': [{
                                            'name': resp.data['name'],
                                            'id': resp.data['id'],
                                            'price': resp.data['price'],
                                            'brand': resp.data['brand'],
                                            'category': resp.data['category'],
                                            'variant': resp.data['variant'],
                                            'dimension11': 'PDP',
                                        }]
                                }
                            }
                        });
                    }
                }
            });
        }
    });
    /********** End: Google Analytics code for PLP ************************************/
});
/******************* End pdp***************************/
