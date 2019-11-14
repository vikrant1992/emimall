require(['jquery', 'mage/apply/main','Magento_Customer/js/customer-data', 'mage/url','jquery/jquery-storageapi'], function ($, mage, customerData, url) {
    var checkcount = 0;
    var maxCheckCount = 3;
    var tips;
    checkcount = getComapreItemCount();

    if ($(window).width() < 768) {
        maxCheckCount = 2;
        removeBlankCmp(checkcount);
    }


    $(document).ready(function () {
        /** Left Filter Start**/
      $('body').on('click', '.a_opnFilter', function() {      
          $('.sidebar-main').addClass('filterShow');
          $('#maincontent').addClass('filterShow');
      });
      $('body').on('click', '.applyCanclBtn .applyFilter, .filter-content .filter-subtitle', function() { 
          $('.sidebar-main').removeClass('filterShow');
          $('#maincontent').removeClass('filterShow');
      });
      $('body').on('click', '.a_opnSort', function() {     
          $('.sidebar-main').addClass('sortShow');
          $('#maincontent').addClass('sortShow');
      });
      $('body').on('click', '.a_filterConmain .applyFilter, .filter-options-title p, #SortBY .filter-options-title img', function() { 
          $('.sidebar-main').removeClass('sortShow');
          $('#maincontent').removeClass('sortShow');
      });
        jQuery('.filter-options-content .layer-search-box').keyup(function() {
            var searchText = jQuery(this).val().toUpperCase();
            jQuery(this).siblings('ol').children('li').find('a').each(function() {
                var currentLiText = jQuery(this).text().toUpperCase(),
                    showCurrentLi = currentLiText.indexOf(searchText) !== -1;
                jQuery(this).parent('li').toggle(showCurrentLi);
            });
        });

        /** Left Filter End**/

         /** Start of  Compare Popup **/
        checkcount = getComapreItemCount();
         // check count of already added products
        if (checkcount > 0) {
            if ($(window).width() < 768) {
                $('.comparepart .mobilecomparedrop').show();
                $('.comparepart .compareProduct').show();
            } else {
                $('.comparepart .mobilecomparedrop').hide();
            }
            $('.compareBTN').fadeIn(200);
            if (checkcount >= maxCheckCount) {
                $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', true);
            } else {
                $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', false);
            }
        } else {
            $('.compareBTN').hide();
        }
            /* Reponsive compare popup*/
        $('.mobilecomparedrop').click(function () {
            $('.comparepart').toggleClass('comparepartShow',1600).promise().done(function(){
              if($(this).hasClass( "comparepartShow" )){
                $('.page-products.catalog-category-view.page-layout-2columns-left #maincontent .columns').css('z-index','101');
              }
              else {
                $('.page-products.catalog-category-view.page-layout-2columns-left #maincontent .columns').css('z-index','1');
              }
            });
            $('.a_filterBtnot').toggleClass('topsift');
            $('.a_scrollUpInMob').toggleClass('topsift');
        });

    });
       /* Show on over compare popup*/
    $(document).on("mouseenter", ".compareBTN", function () {
        $(".compareProduct").show();
        if('.oneboxPro') {
            $('.comparepart').find(".oneboxPro").each(function() {
                var getId = $(this).attr('check-set');
                var getproimg = $('#product_id_'+getId).find('img').attr('src');
                $(this).find('img').attr('src', getproimg);
            });
        }
    });
    /* close compare popup*/
    $(document).on("mouseleave", ".compareProduct", function () {
        $(".compareProduct").hide();
    });
     function getComapreItemCount()
    {
        var checkcount = 0;
        if(localStorage.getItem('mage-cache-storage')) {
            var collection = JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products'];
            if(collection) {
                checkcount = collection.count;
            }
        }
        return checkcount;
    }
    $('body').on('click', '.product-item-detailed-info .product-item-actions label', function () {   

        if ($(this).siblings("input[type='checkbox']").prop("disabled")) {
            clearTimeout(tips);
            $('.wishlistTips').fadeIn();
            if ($(window).width() > 768) {
                $(".wishlistTips p").text("You have already selected 3 products");
            } else {
                $(".wishlistTips p").text("You have already selected 2 products");
            }
            tips = setTimeout(function() {
                $('.wishlistTips').fadeOut();
            }, 2000);
        }
    });
    $(document).on('change', '.product-item-info-details input[type="checkbox"]', function () {
        //Increment count
        $('.mainProductSec .comparepart .compareBTN i').text(checkcount);

        var getproimg = $(this).parents('.product-item-info-details').find('img.product-image-photo').attr('src');
        var getProName = $(this).parents('.product-item-info-details').find('.product-item-name a').text();
        var getId = $(this).attr('id');

        var ischecked = $(this).is(':checked');
        if (ischecked) {
            checkcount++;
            var rawData = $(this).parent().siblings("a").attr('data-post');

            var url  = JSON.parse(rawData).action;

            var data = {
                form_key : $.cookie('form_key'),
                product  : JSON.parse(rawData).data.product,
                uenc     : JSON.parse(rawData).data.uenc
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                showLoader: true,
                success: function (resp) { 

                    if (resp.success == true )
                    {
                        customerData.reload('compare-products',true);
                        addproductAction(getId,getproimg,getProName);
                    } else { 
                        checkcount--;
                        $('.comparepart .compareProduct .oneboxPro[check-set="' + getId + '"]').remove();
                        $('#'+getId).prop('checked', false);
                        if(typeof(resp.message) != "undefined" && resp.message !== null) {
                            $(".wishlistTips p").text(resp.message);
                            $('.wishlistTips').fadeIn();
                            tips = setTimeout(function() {
                                $('.wishlistTips').fadeOut();
                            }, 2000);
                        }
                    }
                }
            });
        } else {
            $('.comparepart .compareProduct .oneboxPro[check-set="' + getId + '"]').children(".crossIcon").children("i").trigger("click");
            $('.comparepart .compareProduct .oneboxPro[check-set="' + getId + '"]').remove();
        }
    });
    $(document).on('click', '.compare input[type="checkbox"]', function () {
        //Increment count
        $('.mainProductSec .comparepart .compareBTN i').text(checkcount);
        var getproimg = $(this).parent().siblings('.p_comprorivew').find('.p_imgcompdp img').attr('src');
        var getProName = $(this).parent().siblings('.p_comprorivew').find('.p_detacomparepdp h2').text();
        var getId = $(this).attr('id');

        var ischecked = $(this).is(':checked');
        if (ischecked) {

            checkcount++;
            var rawData = $(this).parent().siblings("a").attr('data-post');

            var url = JSON.parse(rawData).action;
            var data = {
                form_key: $.cookie('form_key'),
                product: JSON.parse(rawData).data.product,
                uenc: JSON.parse(rawData).data.uenc,
                isAjax : true
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                showLoader: true,
                success: function (resp) {
                    $.cookieStorage.set('mage-messages', '');
                    if (resp.success == true)
                    {
                        customerData.reload('compare-products', true);
                        addproductPdpAction(getId, getproimg, getProName);
                    } else { 
                        checkcount--;
                        $('.comparepart .compareProduct .oneboxPro[check-set="' + getId + '"]').remove();
                        $('#' + getId).prop('checked', false);
                        if(typeof(resp.message) != "undefined" && resp.message !== null) {
                            $(".wishlistTips p").text(resp.message);
                            $('.wishlistTips').fadeIn();
                            tips = setTimeout(function() {
                                $('.wishlistTips').fadeOut();
                            }, 2000);
                        }
                    }
                }
            });
        } else {

            $('.comparepart .compareProduct .oneboxPro[check-set="' + getId + '"]').children(".crossIcon").children("i").trigger("click");
            $('.comparepart .compareProduct .oneboxPro[check-set="' + getId + '"]').remove();
        }
    });
    function addproductPdpAction(getId, getproimg, getProName)
    {
         var already_added = 0;
        $(".oneboxPro").each(function() {
            if($(this).attr('check-set') == getId) 
            {
                already_added = 1;
            }
        });
        if (already_added == 0) {
            $('.comparepart .compareBTN span').text(checkcount);

            if ($(window).width() < 768) {
                if (checkcount > 0) {
                    $('.comparepart .mobilecomparedrop').show();
                    $('.comparepart .compareProduct').show();
                    $('.compareBTN').fadeIn(200);

                } else {
                    $('.compareBTN').fadeOut(200);
                    $('.comparepart .mobilecomparedrop').hide();
                    $('.comparepart').removeClass('comparepartShow');
                    $('.page-products.catalog-category-view.page-layout-2columns-left #maincontent .columns').css('z-index','1');
                    $('.a_filterBtnot').removeClass('topsift');
                    $('.a_scrollUpInMob').removeClass('topsift');
                }
            } else {
                if (checkcount > 0) {
                    $('.compareBTN').fadeIn(200);
                }

            }
            removeBlankCmp(checkcount);
            var removeUrlRaw = {};
            if (JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products']) {
                var collection = JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products'];
                if (collection.items.length > 0) {
                    for (var i = 0; i < collection.items.length; i++) {
                        var compareListProduct = collection.items[i];

                        if (compareListProduct.id == getId) {
                            $('.comparepart .compareProduct').prepend('<div class="oneboxPro" check-set="' + compareListProduct.id + '"><div class="proImg"><img src="' + compareListProduct.product_image + '" alt=""><i class="fa fa-times" data-post="' + compareListProduct.remove_url + '"></i></div><p>' + compareListProduct.name + '</p></div>');
                        } else {
                            var base_url = window.location.origin + "/catalog/product_compare/remove/";
                            removeUrlRaw = '{"action": "' + base_url + '", "data": {"uenc": "", "product": "' + getId + '"}}';
                            $('.comparepart .compareProduct').prepend("<div class='oneboxPro' check-set='" + getId + "'><div class='proImg'><img src='" + getproimg + "' alt=''><i class='fa fa-times' data-post='" + removeUrlRaw + "'></i></div><p>" + getProName + "</p></div>");
                            break;
                        }
                    }
                } else {
                    var base_url = window.location.origin + "/catalog/product_compare/remove/";
                    removeUrlRaw = '{"action": "' + base_url + '", "data": {"uenc": "", "product": "' + getId + '"}}';
                    $('.comparepart .compareProduct').prepend("<div class='oneboxPro' check-set='" + getId + "'><div class='proImg'><img src='" + getproimg + "' alt=''><i class='fa fa-times' data-post='" + removeUrlRaw + "'></i></div><p>" + getProName + "</p></div>");
                }
            } else {
                var base_url = window.location.origin + "/catalog/product_compare/remove/";
                removeUrlRaw = '{"action": "' + base_url + '", "data": {"uenc": "", "product": "' + getId + '"}}';
                $('.comparepart .compareProduct').prepend("<div class='oneboxPro' check-set='" + getId + "'><div class='proImg'><img src='" + getproimg + "' alt=''><i class='fa fa-times' data-post='" + removeUrlRaw + "'></i></div><p>" + getProName + "</p></div>");
            }

            if (checkcount >= maxCheckCount) {
                $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', true);
            } else {
                $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', false);
            }
            $('#' + getId).prop('checked', true);
            $('#' + getId).parent().removeClass( "compare" ).addClass( "compare comparepdp" );
            $('#' + getId).next('label').html('Added');
            $('.compare .comparepdp label[for="' + getId + '"]').html(window.compare_added);
        }
    }
    function addproductAction(getId,getproimg,getProName)
    {
        var already_added = 0;

        $(".oneboxPro").each(function() {
            if($(this).attr('check-set') == getId) 
            {
                already_added = 1;
            }
        });
        if (already_added == 0) {
            $('.comparepart .compareBTN span').text(checkcount);

            if ($(window).width() < 768) {
                if (checkcount > 0) {
                    $('.comparepart .mobilecomparedrop').show();
                    $('.comparepart .compareProduct').show();
                    $('.compareBTN').fadeIn(200);

                } else {
                    $('.compareBTN').fadeOut(200);
                    $('.comparepart .mobilecomparedrop').hide();
                    $('.comparepart').removeClass('comparepartShow');
                    $('.page-products.catalog-category-view.page-layout-2columns-left #maincontent .columns').css('z-index','1');
                    $('.a_filterBtnot').removeClass('topsift');
                    $('.a_scrollUpInMob').removeClass('topsift');
                }
            } else {
                if (checkcount > 0) {
                    $('.compareBTN').fadeIn(200);
                }

            }
            removeBlankCmp(checkcount);
            var removeUrlRaw = {};
            if(JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products']) {
                var collection = JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products'];

                if(collection.items.length > 0) {
                    for (var i = 0; i < collection.items.length; i++) {
                        var compareListProduct = collection.items[i];

                        if(compareListProduct.id == getId) {
                            $('.comparepart .compareProduct').prepend('<div class="oneboxPro" check-set="' + compareListProduct.id + '"><div class="crossIcon"><i class="fa fa-times" data-post="'+ compareListProduct.remove_url +'"></i></div><div class="proImg"><img src="' + compareListProduct.product_image + '" alt=""></div><p>' + compareListProduct.name + '</p></div>');
                        } else {
                            var base_url = window.location.origin+"/catalog/product_compare/remove/";
                            removeUrlRaw = '{"action": "'+base_url+'", "data": {"uenc": "", "product": "'+getId+'"}}';
                            $('.comparepart .compareProduct').prepend("<div class='oneboxPro' check-set='" + getId + "'><div class='crossIcon'><i class='fa fa-times' data-post='" + removeUrlRaw +"'></i></div><div class='proImg'><img src='" + getproimg + "' alt=''></div><p>" + getProName + "</p></div>");
                            break;
                        }
                    }
                } else {
                    var base_url = window.location.origin+"/catalog/product_compare/remove/";
                    removeUrlRaw = '{"action": "'+base_url+'", "data": {"uenc": "", "product": "'+getId+'"}}';
                    $('.comparepart .compareProduct').prepend("<div class='oneboxPro' check-set='" + getId + "'><div class='crossIcon'><i class='fa fa-times' data-post='" + removeUrlRaw +"'></i></div><div class='proImg'><img src='" + getproimg + "' alt=''></div><p>" + getProName + "</p></div>");
                }
            } else {
                var base_url = window.location.origin+"/catalog/product_compare/remove/";
                removeUrlRaw = '{"action": "'+base_url+'", "data": {"uenc": "", "product": "'+getId+'"}}';
                $('.comparepart .compareProduct').prepend("<div class='oneboxPro' check-set='" + getId + "'><div class='crossIcon'><i class='fa fa-times' data-post='" + removeUrlRaw +"'></i></div><div class='proImg'><img src='" + getproimg + "' alt=''></div><p>" + getProName + "</p></div>");
            }

            addVsCmp(checkcount);

            if (checkcount >= maxCheckCount) {
                $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', true);
            } else {
                $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', false);
            }
            $('#' + getId).prop('checked', true);
            $('.product-items .product-item-detailed-info label[for="' + getId + '"]').css({'background': '#00b6b6', 'color': '#ffffff'});
            $('.product-items .product-item-detailed-info label[for="' + getId + '"]').html(window.compare_added);
        }
    }
    function removeBlankCmp(checkcount) {
        var removecnt = maxCheckCount - checkcount;
        if (checkcount > 0) {
            $('.compareProduct .blankCmparBox').slice(removecnt).remove();
        }
    }

    $(document).on('click', '.comparepart .compareProduct .oneboxPro .crossIcon i', function () {
                var cmpbtn = $(".compareBTN");
                $('body').trigger('processStart');
        var rawData = $(this).attr('data-post');
        var url  = JSON.parse(rawData).action;		
        var data = {
            form_key : $.cookie('form_key'),
            product  : JSON.parse(rawData).data.product,
            uenc     : JSON.parse(rawData).data.uenc,
            isAjax : true
        }
        $.post(url, data).complete(function(){
                $.cookieStorage.set('mage-messages', '');
                window.setTimeout(function(){
                 $('body').trigger('processStop');
                }, 1000);
    });


        $(this).parents('.oneboxPro').remove();

        var getcheckSet = $(this).parents('.oneboxPro').attr('check-set');
        $('#' + getcheckSet).prop('checked', false);
        $('.product-items .product-item-detailed-info label[for="' + getcheckSet + '"]').css({'background': '#f6f6f6', 'color': '#222222'});
        $('.product-items .product-item-detailed-info label[for="' + getcheckSet + '"]').html(window.compare_remove);
        var base_url = window.location.origin+"/customcatalog/product/ajaxadd/";
        addUrlRaw = '{"action": "'+base_url+'", "data": {"uenc": "", "product": "'+JSON.parse(rawData).data.product+'"}}';
        $("#"+getcheckSet).siblings('a.action.tocompare').attr('data-post', addUrlRaw);
        checkcount--;
        $('.comparepart .compareBTN span').text(checkcount);

        var oneboxProCount = $('.comparepart .compareProduct .oneboxPro').length;
        removeVsCmp(oneboxProCount);
        if (oneboxProCount < 1) {
            $('.comparepart .compareProduct').hide();
            $('.compareBTN').fadeOut(200);
            $('.comparepart .mobilecomparedrop').hide();
            $('.comparepart').removeClass('comparepartShow');
            $('.page-products.catalog-category-view.page-layout-2columns-left #maincontent .columns').css('z-index','1');
        }

        if (checkcount >= maxCheckCount) {
            $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', true);
        } else {
            $('.product-items .product-item-detailed-info input[type="checkbox"]:not(:checked)').prop('disabled', false);
        }		
    });
      function removeVsCmp(oneboxProCount) {
        if (oneboxProCount == 2) {
            $('.comparepart .compareProduct .vs2').remove();
        }
        if (oneboxProCount == 1) {
            $('.comparepart .compareProduct .vs1').remove();
            $('.comparepart .compareProduct .removeAllFltr .removeAll').removeClass("ShowRemoveAll");
        }
    }

       function addVsCmp(checkcount)
    {

        if( checkcount==2 ){
        $('.comparepart .compareProduct').
                            append(" <div class='vs1'><p>vs</p></div>");
          $('.comparepart .compareProduct .removeAllFltr .removeAll').addClass("ShowRemoveAll");

        }
         if(checkcount==3)
            {
                 $('.comparepart .compareProduct').
                            append(" <div class='vs2'><p>vs</p></div>");
            }  

    }

        /********** Start: Google Analytics code for PLP ************************************/
        /**
         * PPT: EMI_MALL_Login_Event_Version_1.ppt implementation : Screen-2 : Desktop : Abhishek
         * Get data layer code executed whenever someone click on 'Get your pre-approved offer' button in header
         */
        $("div .a_rightnotiPop button").click(function() {
                var pageTitle = $(document).find("title").text();
                var buttonText = $("div .a_rightnotiPop button").text();
                var customerId = '';
                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Nav_Click',                
                        'clickText': buttonText,
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': ''
                });
        });

        $(".viewCitypart").click(function() {
                var buttonText = $(".viewCitypart p").text();
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Nav_Click',                
                        'clickText': buttonText,
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': ''
                });		
        });

        /**
         * PPT: EMI_MALL_Login_Event_Version_1.ppt implementation : Screen-3 : Desktop : Abhishek
         * Get data layer code executed whenever someone click on 'Get your pre-approved offer' button in header
         */
        $(".Subbutton").click(function() {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Login_PSTP',
                        'clickText': 'Get OTP',
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': ''
                });		
        });  

        /**
         * PPT: EMI_MALL_Track implementation : Screen-9 : Desktop : Abhishek
         * PLP Enhanced Ecom Product Detail
         */
        $(".page-products.catalog-category-view.page-layout-2columns-left #maincontent .columns .column.main #layer-product-list .products.wrapper.grid.products-grid ol.products.list.items.product-items li.item.product.product-item-detailed-info").click(function() {
                var linkUrl = url.build('customcatalog/product/getproduct');
                var productId = $(this).find('.a_wishPro').data("id");
                if(productId) {
                        $.ajax({
                                        url: linkUrl,
                                        type: 'POST',
                                        data: {
                                                product_id: productId                  
                                        },
                                        showLoader: true,
                                        success: function (resp) {                    
                                                if (resp.success == true)
                                                {
                                                        /**
                                                        * PPT: EMI_MALL_Track implementation : Screen-9 : Desktop
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
                                                                                'dimension11': 'PLP',
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
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-2 & 3 : Desktop & Mobile : Jitendra
         * Get data layer code executed whenever someone click on 'Sort' radio buttons
         */
        $(document).on("click", "ul.items.grayCheck li.item", function () {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                var customerType = '';
                var clickSortvalue = $(this).find("a").text();

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Filter_Click',	
                        'clickText': 'Sort_Click',
                        'pageType': 'PLP',
                        'clickFiltervalue': 'NA',
                        'clickSortvalue': clickSortvalue,
                        'customerID': customerId,
                        'customerType': customerType
                });
        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-2 & 3 : Desktop & Mobile : Jitendra
         * Get data layer code executed whenever someone click on 'Shopping Options'
         */
        $(document).on("click", ".filter-content .filter-options .filter-options-title", function () {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                var customerType = '';
                var clickFiltervalue = $(this).text();

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Filter_Click',	
                        'clickText': 'Filter_Click',
                        'pageType': 'PLP',
                        'clickFiltervalue': clickFiltervalue,
                        'clickSortvalue': 'NA',
                        'customerID': customerId,
                        'customerType': customerType
                });
        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-4 & 5 : Desktop & Mobile : Jitendra
         * Get data layer code executed whenever someone click on 'Compare'
         */
        $(document).on("click", ".CompareButton-wrapper", function () {
                var pageTitle = $(document).find("title").text();
                var pId = $(this).find("input[type='checkbox']").attr("id");
                var customerId = '';
                var customerType = '';

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Nav_Com_Click',	
                        'clickText': 'Compare_Click',
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': customerType,
                        'clickComparevalue': 'NA',
                        'clickFavouritevalue': pId
                });
        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-4 & 5 : Desktop & Mobile : Jitendra
         * Get data layer code executed whenever someone click on 'Save to wishlist i.e. heart sign' button
         */
        $(document).on("click", ".fa.fa-heart,.fa.fa-heart-o", function () {
                var pageTitle = $(document).find("title").text();
                var pId = $(this).closest(".a_wishPro").attr("data-id");
                var customerId = '';
                var customerType = '';

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Nav_Com_Click',	
                        'clickText': 'Compare_Click',
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': customerType,
                        'clickComparevalue': 'NA',
                        'clickFavouritevalue': pId
                });
        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-6 : Desktop  : Jitendra [Not
         * needed for Mobile as 'Compare (2/3)' button doesn't appear in Mobile interface]
         * Get data layer code executed whenever someone clicks on 'Compare (2/3)' button
         */
        $(document).on("click", ".compareBTN .action.compare", function () {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                var customerType = '';
                var url = $(this).attr("href");

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Nav_Com_Click',	
                        'clickText': 'Compare_Click',
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': customerType,
                        'clickComparevalue': getComparedProductIds(url)
                });
        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-8 : Desktop  : Jitendra [Not
         * needed for Mobile as 'Compare (2/3)' button doesn't appear in Mobile interface]
         * Get data layer code executed whenever someone clicks on 'Compare (2/3)' button
         */
        $(document).on("click", ".compareBTN .action.compare", function () {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                var customerType = '';
                var url = $(this).attr("href");
                var comparedProductIds = getComparedProductIds(url);
                var comparedProductsArray = getComparedProductsArray(comparedProductIds);

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'productClick',
                        'ecommerce': {
                                'click': {
                                        'actionField': {
                                                'list': 'Compare'
                                        },
                                        'products': comparedProductsArray
                                }
                        }
                });

        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-10 : Desktop : Jitendra
         * Get data layer code executed whenever someone clicks on product image/name
         */
        $(document).on("click", ".compareBTN .action.compare", function () {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                var customerType = '';
                var url = $(this).attr("href");
                var comparedProductIds = getComparedProductIds(url);
                var comparedProductsArray = getComparedProductsArray(comparedProductIds);

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'productClick',
                        'ecommerce': {
                                'click': {
                                        'actionField': {
                                                'list': 'Compare'
                                        },
                                        'products': comparedProductsArray
                                }
                        }
                });

        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-11 : Desktop : Jitendra [Not 
         * needed for Mobile, as on clicking image, bigger image opens]
         * Get data layer code executed whenever someone clicks on Product
         */
        $(document).on("click", ".item.product.product-item-detailed-info .product.photo.product-item-photo", function () {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                var customerType = '';
                var pId = $(this).attr("data-id");

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Product_Click',	
                        'clickText': 'Title_Click|'+pId,
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': customerType
                });
        });

        /**
         * PPT: EMI MALL PLP_Version_3.ppt implementation : Screen-11 : Desktop | Mobile : Jitendra
         * Get data layer code executed whenever someone clicks on Product-Title
         */
        $(document).on("click", ".item.product.product-item-detailed-info .product.name.product-item-name a", function () {
                var pageTitle = $(document).find("title").text();
                var customerId = '';
                var customerType = '';
                var pId = $(this).closest(".item.product.product-item-detailed-info").find(".product.photo.product-item-photo").attr("data-id");

                dataLayer.push({
                        'pageTitle': pageTitle,
                        'event': 'Product_Click',	
                        'clickText': 'Tile_Click|'+pId,
                        'pageType': 'PLP',
                        'customerID': customerId,
                        'customerType': customerType
                });
        });

        /**
         * It consumes pipe separated product ids and returns array of each product details : Jitendra
         *
         * @param string comparedProductIds pipe separated product ids like '112|110|111'
         * @returns array productsArray
         */
        function getComparedProductsArray(comparedProductIds)
        {
                var productIds = comparedProductIds.split('|');

                var productsArray = [];
                var i;

                for(i = 0; i < productIds.length; i++) {
                        var productData = String($(".product.photo.product-item-photo[data-id='"+productIds[i]+"']").attr('data-details'));
                        var productDataArr = productData.split('|');

                        productsArray.push([
                                {
                                        'id': productDataArr[0],
                                        'sku': productDataArr[1],
                                        'name': productDataArr[2],
                                        'emi': productDataArr[3],
                                        'categoryId': productDataArr[4]
                                }
                        ]);
                        productData = null;
                        productDataArr = null;
                }
                return productsArray;
        }

        /**
         * It consumes url-string and find-out/return the product-ids appended in url-string : Jitendra
         *
         * @param string url like 'http://jitendray.bajaj.com/catalog/product_compare/index/items/108%2C111/uenc/..........'
         * @returns string data
         */
        function getComparedProductIds(url)
        {
                var strArray = url.split('/');
                var itemsIndex = strArray.indexOf('items');
                var productIds = strArray[itemsIndex + 1];
                var commaSeparatedProductIds = decodeURIComponent(productIds);
                var pipeSeparatedProductIds = replaceAll(commaSeparatedProductIds, ',', '|');

                return pipeSeparatedProductIds;
        }

        /**
         * Define function for escaping input to be treated as a literal string within a regular expression : Jitendra
         */
        function escapeRegExp(string)
        {
                return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
        }

        /**
         * Define functin to find and replace specified term with replacement string : Jitendra
         */
        function replaceAll(str, term, replacement) 
        {
                return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
        } 

        /********** End: Google Analytics code for PLP ************************************/

    /** EndOf Compare Popup **/
});