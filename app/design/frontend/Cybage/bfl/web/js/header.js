/**** Start Header*****/
require(['jquery'], function ($) {
       document.onreadystatechange = function () {
           var lazyloadImages = document.querySelectorAll("img.lazy");
            var lazyloadThrottleTimeout;

            function lazyload() {
                if (lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }

                lazyloadThrottleTimeout = setTimeout(function () {
                    var scrollTop = window.pageYOffset;
                    lazyloadImages.forEach(function (img) {
                        if (img.offsetTop < (window.innerHeight + scrollTop)) {
                            if(img.dataset.src !== undefined){
                                img.src = img.dataset.src;
                            }
                            img.classList.remove('lazy');
                        }
                        lazyloadImages = document.querySelectorAll("img.lazy");
                    });
                    if (lazyloadImages.length === 0) {
                        document.removeEventListener("scroll", lazyload);
                        window.removeEventListener("resize", lazyload);
                        window.removeEventListener("orientationChange", lazyload);
                    }
                }, 20);
            }
            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
    }

    $(document).ready(function () {
       
        $('.header.content .a_mall_search .a_searchinfild .block.block-search .block.block-content input').removeAttr('style').css('background', 'transparent !important');
        $('.categorySelect').click(function (e) {
            e.stopPropagation();
            if ($(window).width() < 992) {
                $(this).parents('.a_emi_header').find('.a_openSelectcat').addClass('catpopinMob');
            } else {
                $(this).parents('.a_emi_header').find('.a_openSelectcat').slideToggle(200);
            }
        });        
        $('.a_emi_header .a_mall_search .a_searchinfild input').css({"background": "#f2f2f2 !important", "border-radius": "30px 30px 30px 30px", "box-shadow": "none", "border-bottom": "none"});
        /*onhover menu show*/
        $('.a_emi_header .topfHeader .a_openSelectcat .a_deskcatagory > ul > li > a:not(:first)').addClass('inactive');
        $('.a_contantRight .a_cetegoryOne').hide();
        $('.a_cetegoryOne:first').show();

        $('.a_emi_header .topfHeader .a_openSelectcat .a_deskcatagory > ul > li > a').hover(function () {
            var t = $(this).attr('id');
            if ($(this).hasClass('inactive')) {
                $('.a_emi_header .topfHeader .a_openSelectcat .a_deskcatagory > ul > li > a').addClass('inactive');
                $(this).removeClass('inactive');
                $('.a_contantRight .a_cetegoryOne').hide();
                $('#' + t + 'C').fadeIn('fast');
            }
        });
        /*onhover menu show*/

        /*onclick menu show for mobile*/
        $('.mobileCategoryPop ul > li > a').click(function () {
            var th = $(this).attr('id');
            $('.a_cetegoryOne').hide();
            $('#' + th + 'M').show();
            /* position for body and HTML */
            $("html").css({"overflow": "hidden", "position": "relative"});   
            $("body").css({"overflow": "hidden", "position": "relative"});
            /* position for body and HTML */
        });


        $('.catboxBorder').click(function (e) {
            e.stopPropagation();
        });
        $('.a_emi_header .a_mainoffersLinka .a_mobileScrollwhithLo >ul>li>a').click(function (e) {
            e.stopPropagation();
            $(this).toggleClass('active');
            $(this).parent().siblings().children('a').removeClass('active');
            $(this).siblings('.a_moreoffer').slideToggle(200);
            $(this).siblings('.a_branstabs').slideToggle(200);
            $('.a_emi_header .a_mall_search .a_searchinfild input').css({"background": "#f2f2f2", "border-radius": "30px 30px 30px 30px", "box-shadow": "none", "border-bottom": "none"});
            $('.a_emi_header .topfHeader .a_mall_search .a_searchinfild .mst-searchautocomplete__autocomplete._active').css('visibility', 'hidden');
            if ($(window).width() > 992) {
                if (!$(this).hasClass('categorySelect')) {
                    $('.a_emi_header .a_openSelectcat').fadeOut(100);
                }
                $(this).parent().siblings().children('div').fadeOut(100);
            }
            $('.a_emi_header .a_mall_search .a_searchinfild  .a_searchLinks').fadeOut(100);
            $('.a_emi_header .a_rightnotiPop ul li .popdis').fadeOut(200);
        });
        $('.a_emi_header .a_mall_search .a_searchinfild input').click(function (e) {
            e.stopPropagation();
            $(this).siblings('.a_searchLinks').slideDown(200);
            /*    $(this).css('border-radius','20px 20px 0px 0px');
             $(this).css('background','#ffffff');*/
            $(this).css({"background": "#ffffff", "border-radius": "20px 20px 0px 0px", "box-shadow": "0 1px 4px 0 #cacaca", "border-bottom": "1px solid #eee"});
            $('.a_emi_header .a_rightnotiPop ul li .popdis').fadeOut(200);
            $('.a_emi_header .topfHeader .a_mall_search .a_searchinfild .mst-searchautocomplete__autocomplete._active').css('visibility', 'visible');
            if ($(window).width() > 992) {
                $('.a_emi_header .a_openSelectcat').fadeOut(100);
                $('.a_emi_header .a_mainoffersLinka .a_mobileScrollwhithLo >ul>li>a').parent().siblings().children('div').fadeOut(100);
            }
            $('.a_emi_header .a_mainoffersLinka .a_mobileScrollwhithLo >ul>li>a').removeClass('active');
        });
        $('.a_emi_header .topfHeader .a_mall_search .a_searchinfild .a_searchLinks').click(function (e) {
            e.stopPropagation();
        });

        $('.recentSS li a').click(function () {
            $('.a_searchPart .searchPart > input').val($(this).children('p').text());
        });

        if ($('.topfHeader').length > 0) {
            //var sortOfset = $('.MainHeader').offset().top;
            var sortOfset = $('.topfHeader').offset().top;
            var oldiCurScrollPos = 0;
            $(window).scroll(function () {
                var win_scroll = $(this).scrollTop();
                if (win_scroll > sortOfset) {
                    $('.topfHeader').addClass('topfHeaderSticky');
                }
                if (win_scroll < oldiCurScrollPos) {
                    $('.topfHeader').removeClass('topfHeaderSticky');
                }
                oldiCurScrollPos = win_scroll;
            });
        }

        $('.p_startingpricce ul li').click(function () {
            var getoffdet = 0;
            $(this).prevAll().each(function () {
                getoffdet = getoffdet + $(this).width();
            });
            $(".p_startingpricce ul").animate({scrollLeft: getoffdet}, 300);
        });

        $(document).click(function (e) {
            $('.a_emi_header .a_openSelectcat').fadeOut(100);
            $('.a_emi_header .a_mainoffersLinka .a_mobileScrollwhithLo >ul>li>a').removeClass('active');
            $('.a_emi_header .a_mall_search .a_searchinfild input').css({"background": "#f2f2f2", "border-radius": "30px 30px 30px 30px", "box-shadow": "none", "border-bottom": "none"});
            $('.a_emi_header .topfHeader .a_mall_search .a_searchinfild .a_searchLinks').hide();
        });

        /*header mobile*/
        $(".a_emi_header .topfHeader .a_rightnotiPop > ul > li > .account,.mobileBottomTab ul li .account").click(function (e) {
            e.stopPropagation();
            $(".mobileSubCategoryPop").removeClass("ShowSubCategoryPop");
            $(".mobileCategoryPop").removeClass("ShowCategoryPop");
            $(".j_ProNTBMain").addClass("j_showprofilepop");
            $(".mobileBottomTab ul li a").removeClass("active");
            $(this).addClass("active");
        });

        $(".mobileBottomTab ul li .category").click(function (e) {
            $(".mobileCategoryPop").addClass("ShowCategoryPop");
            $(".mobileBottomTab ul li a").removeClass("active");
            $(this).addClass("active");
            /* position for body and HTML */
            $("html").css({"overflow": "hidden", "position": "relative"});   
            $("body").css({"overflow": "hidden", "position": "relative"}); 
            /* position for body and HTML */
        });

        $(".mobileCategoryPop ul li a").click(function (e) {
            $("body").css("overflow", "hidden");
            $(".mobileSubCategoryPop").addClass("ShowSubCategoryPop");
        });

        $(".mobileSubCategoryPop .backHeader .a_backHeader").click(function (e) {
            $(".mobileSubCategoryPop").removeClass("ShowSubCategoryPop");
        });

        $(" .mobileCategoryPop .backHeader .a_backHeader").click(function (e) {
            $(".mobileCategoryPop").removeClass("ShowCategoryPop");
            /* position for body and HTML */
             $("html").css("overflow", "auto");
            $("body").css("overflow", "auto");
            /* position for body and HTML */
        });
        
        $(".a_emi_header .topfHeader .a_backHeaderInnerPages").click(function(e) {
            e.stopPropagation();
            window.history.back();
        });

        /****city selector****/

        $("#currentGeoLocation").click(function () {
            var options = {enableHighAccuracy: true, maximumAge: 15000, timeout: 30000};
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getGeoLocationCallback, getGeoLocationErrorCallback, options);
            }
        });

        function getGeoLocationCallback(position) {
            showPosition(position.coords);
        }

        function getGeoLocationErrorCallback() {
            var ipInfoUrl = $("#ipinfo-url").val();
            $.getJSON(ipInfoUrl, function (response) {
                var loc = response.loc.split(',');
                var coords = {
                    latitude: loc[0],
                    longitude: loc[1]
                };
                showPosition(coords);
            });
        }

        function showPosition(position) {
            var apiurl = $("#apiurl").val();
            var apikey = $("#apikey").val();
            var GEOCODING = apiurl + position.latitude + '%2C' + position.longitude + '&language=en&key=' + apikey;
            $.getJSON(GEOCODING).done(function (location) {
                $('.viewCitypart p').html(location.results[0].address_components[3].long_name);
                var baseUrl = window.location.origin;
                var url = baseUrl + "/storelocator/index/session";
                var city = location.results[0].address_components[3].long_name;
                $.ajax({
                    showLoader: true,
                    url: url,
                    data: {
                        city: city
                    },
                    type: "POST",
                    success: function () {
                        window.location.reload();
                    }
                });
            });
        }

        $(".popularcitys li a").click(function (e) {
            var baseUrl = window.location.origin;
            var url = baseUrl + "/storelocator/index/session";
            var city = jQuery(this).attr('data-city');
            $.ajax({
                showLoader: true,
                url: url,
                data: {
                    city: city
                },
                type: "POST",
                success: function () {
                    e.stopPropagation();
                    $(".viewCitypart p").show().text(city);
                    if(window.location.pathname == '/storelocator') {
						window.location.reload();
					}
                }
            });
        });

        $("#searchcityinput").keyup(function () {
            searchFilter();
            if ($(this).val()) {
                $(".popularcityUl").hide();
                $(".popularcitys>h2").hide();
                $(".othercities").show().text("Search Result");
            } else {
                $(".popularcityUl").show();
                $(".popularcitys>h2").show();
                $(".othercities").show().text("Other Cities");
                ;
            }
        });

        $(".selectcitypopup .selectCityBox .popularcitys .popularcityUl li a,.selectcitypopup .selectCityBox .popularcitys .allcitybox .allcityUl li a").click(function () {
            $(".selectcitypopup").hide();
            $(".transparentBG").hide();
            $("body").css("overflow", "auto");
        });

        function searchFilter() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("searchcityinput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("allcityUl");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('a')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        $("header .viewCitypart").click(function (e) {
            e.stopPropagation();
            $(".selectcitypopup").show();
            $(".transparentBG").show();
            $("body").css("overflow", "hidden");
        });

        $("#searchcityinput").focus(function () {
            $(".selectcitypopup").addClass("selectcitypopupTopZero");
        });
        
        $(".selectcitypopup .selectCityBox .slctCityToggle").click(function () {
            if ($('.selectcitypopup').hasClass('selectcitypopupTopZero')){
                $(".selectcitypopup").removeClass("selectcitypopupTopZero");
                $(".storehead").show();
            } else{
               $(".selectcitypopup").addClass("selectcitypopupTopZero");
            }
        });
        

        $(".recentsearch li a").click(function () {
            var rcnt = $(this).children(".proName").text();
            $(".a_searchinfild input").val(rcnt);
        });
        
        if ($(window).width() < 768) {
            if ($('.popularcitys').length > 0) {
                var sortOfset = $('.selectCityBox').offset().top;
                var oldiCurScrollPos = 0;
                $('.popularcitys').scroll(function () {
                    var win_scroll = $(this).scrollTop();
                    if (win_scroll > sortOfset) {
                        $(".selectcitypopup").addClass("selectcitypopupTopZero");
                        $(".storehead").hide();
                        $(".selectcitypopup.selectcitypopupTopZero .selectCityBox .searchbarmainBox").css('margin-top','35px');
                    }
                    if (win_scroll < oldiCurScrollPos) {
                        $('.selectcitypopup').removeClass('selectcitypopupTopZero');
                        $(".storehead").show();
                        $(".selectcitypopup .selectCityBox .searchbarmainBox").css('margin-top','80px');
                    }
                    oldiCurScrollPos = win_scroll;
                });
            }
        }

        /*footer*/
        $('.a_colapsFoot').click(function () {
            $(this).toggleClass('active');
            $('.a_footerWhite').slideToggle('slow');
            $('html, body').animate({scrollTop: $('.a_colapsFoot').offset().top - 60}, 500);
        });

        /*search mobile*/
        $('.a_emi_header .topfHeader .a_mobSrch').click(function () {
            $('.a_searchBlack').show();
            $('.mainSearch').addClass('showSearch');
        });

        $('.a_searchBlack').click(function () {
            $(this).hide();
            $(this).siblings('.a_mall_search').removeClass('showSearch');
        });

        $(".a_searchPart .searchPart > input").keyup(function () {
            if ($(this).val()) {
                $(".a_searchPart .searchPart > .crosImg").show();
                $(".a_searchPart .searchPart > .micImg").hide();
            } else {
                $(".a_searchPart .searchPart > .crosImg").hide();
                $(".a_searchPart .searchPart > .micImg").show();
            }
        });

        $('.recentSS li a').click(function () {
            $('.a_searchPart .searchPart > input').val($(this).children('p').text());
        });

        $('.a_seachCont .productList > li > a').click(function () {
            $(this).addClass('active');
            $(this).parent().siblings().children('a').removeClass('active');


            var getoffdet = 0;
            $(this).parent().prevAll().each(function () {
                getoffdet = getoffdet + $(this).width();
            });
            $(".a_seachCont .productList").animate({scrollLeft: getoffdet}, 300);

        });

        $(".a_searchPart .a_backHeader").click(function (e) {
            $(".mainSearch").removeClass("showSearch");
            $(".a_searchBlack").hide();
            $("#search_mini_form_smd").trigger('reset');
            /* position for body and HTML */
             $("html").css("overflow", "auto");
            $("body").css("overflow", "auto");
            /* position for body and HTML */
        });
        $('.cms-home.cms-index-index.page-layout-1column .mainSearch.showSearch .a_searchPart .searchPart .field.search input').trigger("click");
    
    
	$(".mob_store, .a_mobileScrollwhithLo ul li #stores").click(function (e) {
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
				if(data.isLoggedIn == false) {
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
		
    $(window).load(function() { 
        $('.header.content .a_mall_search .a_searchinfild .block.block-search .block.block-content input').removeAttr('style').css('background', 'transparent !important');
    });

});



