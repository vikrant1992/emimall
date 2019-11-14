require(['jquery','jquery/jquery.cookie', 'slick'], function (JQuery) {
    JQuery(document).ready(function (JQuery) {
        var tips;

        /* start storelocator */
        var map;
        var Allmarker = [];
        var image1;
        var outsidemarkerclick = 0;
        var directionsService;
        var directionsDisplay;
        var user_lat;
        var user_lng;
        var city_lat;
        var city_lng;
        function LoadingShow() {
            JQuery(".loadingboxmain").show();
        }

        function LoadingHide() {
            JQuery(".loadingboxmain").hide();
        }

        getLocation();

        JQuery('.stotreOffer').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 1.1,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1.1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1.1,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1.1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        JQuery("#searchcityinput").keyup(function () {
            searchFilter();
        });

        JQuery("#searchcityinput").focus(function () {
            JQuery(".popularcitys > h2").hide();
            JQuery(".popularcityUl").hide();
        });
        
             
        
        /* Filter option city Selection start*/
        
        JQuery("#selected-city").keyup(function () {            
            searchcityFilter();
        });
      
        JQuery("#selected-city").focus(function () {
            JQuery(".a_filterConmain").hide();
            JQuery(".a_newFilter .buttonDiv").hide();
            JQuery(".a_newFilter .allcitybox").show();
        });

        JQuery("body").on("click", ".a_newFilter.Storefilter .fitlerHear", function (e) { 
            JQuery(".a_filterConmain").show();
            JQuery(".a_newFilter .buttonDiv").show();
            JQuery(".a_newFilter .allcitybox").hide();
        });
        if (JQuery(window).width() > 768) {
          JQuery(".storelocatorRight.storelocatorRightFull").click(function(){
            JQuery(".a_filterConmain").show();
            JQuery(".a_newFilter .buttonDiv").show();
              JQuery(".a_newFilter .allcitybox").hide();
          });
        }


        function searchcityFilter() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("selected-city");
            filter = input.value.toUpperCase();
            ul = document.getElementById("filtercityul");
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
        /* Filter option city Selection end*/
        
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

        /*category active show*/
        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .a_lookingPart .a_lookProtab ul li:first-child a').addClass("active");
        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .a_lookingPart .productInfoMainWrap:first .a_productInfo').first().css("display", "block");

        function setMarkers(map, locations) {
            var marker, i;
            var shoppingPin = JQuery("#shopping-pin").val();
            var selectedPin = JQuery("#selected-pin").val();
            var image = {
                url: selectedPin,
                size: new google.maps.Size(40, 50),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(0, 50)
            };

            image1 = {
                url: shoppingPin,
                size: new google.maps.Size(40, 50),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(0, 50)
            };

            Allmarker = [];
			infoWindows = [];
            var direction = JQuery("#directions-icon").val();
            var phone = JQuery("#call-icon").val();
            var callIcon = JQuery("#ico-call").val();
            var iconCallRequest = JQuery("#ico-call-request").val();
           
            locations.forEach(function (store) {
                var lat = parseFloat(store.latitude);
                var long = parseFloat(store.longitude);
                var infohtml = "<b>" + store.dealer_name + "</b> <div class='address'>" + store.address + "</div>";
                latlngset = new google.maps.LatLng(lat, long);
				var infowindow = new google.maps.InfoWindow();
				infowindow.setContent(infohtml);
				infoWindows.push(infowindow);
				
				var marker = new google.maps.Marker({
					position: latlngset,
					map: map,
					icon: image1
				  });
				
                Allmarker.push(marker);

                map.setCenter(marker.getPosition())
                var content = store.dealer_name;
				
                var preinfo = false;
                var isDivPresent = false;
                google.maps.event.addListener(marker, 'click', (function (marker, content, infowindow) {
                    return function () {
                        var storeDetails = "";
                        if (JQuery(".located").length > 0) {
                            isDivPresent = true;
                        }
                        outsidemarkerclick = 1;
                        var dt = content.split("data-tab")[1];
						if (infowindow) {
							infowindow.close();
						}
                        if (preinfo) {
                            preinfo.close();
                        }
						//close all
						for (var i = 0; i < infoWindows.length; i++) {
						  infoWindows[i].close();
						}
						if(!marker.open){
							infowindow.open(map, marker);
							marker.open = true;
						}
						else{
							infowindow.close();
							marker.open = false;
						}
						google.maps.event.addListener(map, 'click', function() {
							infowindow.close();
							marker.open = false;
						});
						
                        preinfo = infowindow;
						
                        resetmarkers();
                        marker.setIcon(image);

                        storeDetails = '<div class="p_storedetilsbox located" >' +
                                '<a class="storeDealer" data-dealerID="dealer'+store.bajaj_dealerid+'" href="#;">' +
                                '<div class="p_nameoffer">' +
                                '<div class="p_salesnametitle">' +
                                '<h2>' + content + '</h2>' +
                                '</div>' +
                                '</div>' +
                                '<div class="p_storelistdeta">'+
                                    '<div class="a_adddisc">'+
                                        '<p></p>'+
                                    '</div>'+
                                '</div>'+
                                '</a>' +
                                '<div class="p_knowmore">'+
                                '<ul><li class="p_btnknow getDirectionbtn"><a href="#;" data-lat="'+store.latitude+'" data-long="'+store.longitude+'"><img src="'+direction+'" alt=""> <p>Get Directions</p></a></li>'+
                                '<li class="p_phone">'+
                                '<a href="#;"><img src="'+phone+'" alt=""> <p>Contact Store</p></a></li></ul>'+
                                '</div>'+
                                '<div class="a_continuSdop">'+
                                '<div class="a_continuSdopBlack">'+
                                '<div class="a_continuPopCon">'+
                                '<div class="a_title">'+
                                '<h4>'+store.dealer_name+'</h4>'+
                                '</div>'+
                                '<div class="a_mainCcOn">'+
                                '<p>A callback request has been sent to the store. A representative will be calling you shortly</p>'+
                                '<a href="#;">Continue Shopping</a>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '<div class="a_storeLList"><div class="a_storeLBlack"><div class="a_continuPopCon">'+
                                '<div class="a_title"><h4>Contact</h4></div>'+
                                '<div class="a_callAndreq"><ul><li>'+
                                '<a href="tel:'+store.phone+'" class="callStore">'+
                                '<img src="'+callIcon+'" alt="">'+
                                '<h4>Call Store</h4><p>For a better experience, call from your registered number</p>'+
                                '</a></li>'+
                                '<li><a href="#;" id="callBack" class="callBack" data-storeid="'+store.bajaj_dealerid+'">'+
                                '<img src="'+iconCallRequest+'" alt="">'+
                                '<h4>Request a Callback</h4><p>Get a call from this store</p></a>'+
                                '</li></ul></div></div>'+
                                '</div></div>'+
                                '</div>';

                        var storeInfo = '<a class="storeDealer" data-dealerID="dealer'+store.bajaj_dealerid+'" href="#;">' +
                                '<div class="p_nameoffer">' +
                                '<div class="p_salesnametitle">' +
                                '<h2>' + content + '</h2>' +
                                '</div>' +
                                '</div>' +
                                '<div class="p_storelistdeta">'+
                                    '<div class="a_adddisc">'+
                                        '<p></p>'+
                                    '</div>'+
                                '</div>'+
                                '</a>'+
                                '<div class="p_knowmore">'+
                                '<ul><li class="p_btnknow getDirectionbtn"><a href="#;" data-lat="'+store.latitude+'" data-long="'+store.longitude+'"><img src="'+direction+'" alt=""> <p>Get Directions</p></a></li>'+
                                '<li class="p_phone">'+
                                '<a href="#;"><img src="'+phone+'"> <p>Contact Store</p></a></li></ul>'+
                                '</div>'+
                                '<div class="a_continuSdop">'+
                                '<div class="a_continuSdopBlack">'+
                                '<div class="a_continuPopCon">'+
                                '<div class="a_title">'+
                                '<h4>'+store.dealer_name+'</h4>'+
                                '</div>'+
                                '<div class="a_mainCcOn">'+
                                '<p>A callback request has been sent to the store. A representative will be calling you shortly</p>'+
                                '<a href="#;">Continue Shopping</a>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '<div class="a_storeLList"><div class="a_storeLBlack"><div class="a_continuPopCon">'+
                                '<div class="a_title"><h4>Contact</h4></div>'+
                                '<div class="a_callAndreq"><ul><li>'+
                                '<a href="tel:'+store.phone+'" class="callStore">'+
                                '<img src="'+callIcon+'" alt="">'+
                                '<h4>Call Store</h4><p>For a better experience, call from your registered number</p>'+
                                '</a></li>'+
                                '<li><a href="#;" id="callBack" class="callBack" data-storeid="'+store.bajaj_dealerid+'">'+
                                '<img src="'+iconCallRequest+'" alt="">'+
                                '<h4>Request a Callback</h4><p>Get a call from this store</p></a>'+
                                '</li></ul></div></div>'+
                                '</div>'+
                                '</div>';
                        if (isDivPresent === true) {
                            JQuery(".p_storedetilsbox.located").html(storeInfo);
                        } else {
                            JQuery(storeDetails).appendTo(JQuery(".mappindetailbox"));
                        }
                        
                        JQuery(".p_storelist").hide();
                        JQuery(".p_storeloction").hide();
                        JQuery(".p_storelistbg").hide();
                        JQuery(".mappindetailbox").slideDown();
                        JQuery(".p_storedetilsbox.located").show();
                        if (JQuery(window).width() > 767) {
                            JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .mappindetailbox .desktopbacklist').show();
							JQuery('.storelocatorRight').addClass('store-selected');
                        }
						
                    };
                })(marker, content, infowindow));
            });
        }
		
        function resetmarkers() {
            for (var a = 0; a < Allmarker.length; a++) {
                Allmarker[a].setIcon(image1);
            }
        }

        function initMap() {
            var mapCenter;
            city_lat = "23.628915";
            city_lng = "78.418910";
            if((typeof city_lat !== 'undefined' || city_lat !== '') && (typeof city_lng !== 'undefined' || city_lng !== '')){
                mapCenter = new google.maps.LatLng(city_lat, city_lng);
            }
            var mapCanvas = document.getElementById("googleMap");
            var mapOptions = {center: mapCenter, zoom: 12, disableDefaultUI: true};
            map = new google.maps.Map(mapCanvas, mapOptions);

            JQuery("body").on("click", ".locationaddres .proadd a", function (e) {
                var lat = "78.418910";
                var long = "78.418910";
                map.setCenter(new google.maps.LatLng(lat, long));
                map.setZoom(10);
            });
            getAllStores();
        }

            

       
			JQuery("body").on("click", ".p_storedetilsbox .getdirection.listGetDirection", function (e) {            
                if (directionsDisplay != null) {
                    directionsDisplay.setMap(null);
                }
                if (JQuery(window).width() < 768) {
                    JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");
                    JQuery(this).parent().parent().parent(".p_storeloction").hide();
                    JQuery(".storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder").show();
                    JQuery(".page-header").toggleClass("hide-header"); 
                    JQuery(".p_storelist .storehead.stores-header").toggleClass("hide-headerTitle");                    
                }
                var latitude = JQuery(this).attr('data-lat');
                var longitude = JQuery(this).attr('data-long');
                calculateAndDisplayRoute(latitude, longitude, JQuery(this));
            });
      
                   
			JQuery("body").on("click", ".p_storegetdriction .getdirection", function (e) {
                if (directionsDisplay != null) {
                    directionsDisplay.setMap(null);
                }
                if (JQuery(window).width() < 768) {
                    JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");
                    JQuery(this).parent().parent().parent(".p_storeloction").hide();
                    JQuery(".storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder").show();
                    JQuery(".p_storelist .storehead.stores-header").toggleClass("hide-headerTitle");
                    JQuery(".page-header.dealer-hide-header").toggleClass("hide-header");
                    JQuery(".page-header").removeClass("dealer-hide-header");                                         
                }
                var latitude = JQuery(this).attr('data-lat');
                var longitude = JQuery(this).attr('data-long');
                calculateAndDisplayRoute(latitude, longitude, JQuery(this));
            });
        
        
        JQuery("body").on("click", ".p_storedetilsbox.located .getDirectionbtn a", function (e) {            
                if (directionsDisplay != null) {
                    directionsDisplay.setMap(null);
                }
                if (JQuery(window).width() < 768) {
                    JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");
                    JQuery(this).parent().parent().parent(".p_storeloction").hide();
                    JQuery(".storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder").show();                    
                }
                var latitude = JQuery(this).attr('data-lat');
                var longitude = JQuery(this).attr('data-long');
                calculateAndDisplayRoute(latitude, longitude, JQuery(this));
            
        });

        JQuery("#showdirection").click(function () {
            var latitude = JQuery(this).attr('data-lat');
            var longitude = JQuery(this).attr('data-long');
            calculateAndDisplayRoute(latitude, longitude, JQuery(this));
        });

        /* Get Current Location*/
        function getLocation() {
            //if(window.location.protocol === "https:"){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getGeoLocationCallback, getGeoLocationErrorCallback);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
            //}
        }

        function getGeoLocationCallback(position) {
            showPosition(position.coords);
        }
        
        function getCityLocationErrorCallBack(error){
            var ipInfoUrl = JQuery("#ipinfo-url").val();
            JQuery.getJSON(ipInfoUrl, function(response) { 
                var loc = response.loc.split(',');
                var coords = {
                    latitude: loc[0],
                    longitude: loc[1]
                };
                getCityLocation(coords);
            });
        }
        
        function chooseCityCallback(position){
            showPosition(position.coords);
        }
        
        function chooseCityErrorCallBack(error){
            var ipInfoUrl = JQuery("#ipinfo-url").val();
            JQuery.getJSON(ipInfoUrl, function(response) { 
                var loc = response.loc.split(',');
                var coords = {
                    latitude: loc[0],
                    longitude: loc[1]
                };
                selectCity(coords);
            });
        }
        
        function selectCity(position) {
            var geoLocationAPI = JQuery("#geolocation-api-url").val();
            var GEOCODING = geoLocationAPI + position.latitude + '%2C' + position.longitude + '&language=en&key=AIzaSyB4-jbJzHGNiPfJUEWf-cFk2Kd04m1ouKg';
            JQuery.getJSON(GEOCODING).done(function(location) {
                var city = location.results[0].address_components[3].long_name;
                JQuery("#selected-city").val(city);
            });
        }
        
        function getCityLocation(position) {
            var geoLocationAPI = JQuery("#geolocation-api-url").val();
            var GEOCODING = geoLocationAPI + position.latitude + '%2C' + position.longitude + '&language=en&key=AIzaSyB4-jbJzHGNiPfJUEWf-cFk2Kd04m1ouKg';
            JQuery.getJSON(GEOCODING).done(function(location) {
                var city = location.results[0].address_components[3].long_name;
                JQuery("#searchcityinput").val(city);
            });
        }
        
        function setCityInSession(city){
                var baseUrl = window.location.origin;
                var url = baseUrl + "/storelocator/index/session";
                JQuery.ajax({
                    showLoader: true,
                    url: url,
                    data: {
                        city: city
                    },
                    type: "POST",
                    success: function () {
                        JQuery(this).parents('.select_city_block').hide();
                        if (JQuery(window).width() > 600) {
							if (JQuery('.popularcityUl li a').hasClass('lobexist')) {
								location.reload();
							} else {
								//do nothing
							}
						} else {
							if (JQuery('.popularcityUl li a').hasClass('lobexist')) {
								location.reload();
							} else {
								JQuery('.selectCityBox').addClass('slideleft');
								JQuery('.a_lookingPart').removeClass('slideright');
							}

						}
                    }
                });
                return false;
        }
        
        function showPosition(coords) {
            user_lat = coords.latitude;
            user_lng = coords.longitude;
        }

        function getGeoLocationErrorCallback(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    getPositionCoordinates();
                    break;
                default:
                    getPositionCoordinates();
            }
        }

        function getPositionCoordinates() {
            var ipInfoUrl = JQuery("#ipinfo-url").val();
            JQuery.getJSON(ipInfoUrl, function (response) {
                var loc = response.loc.split(',');
                var coords = {
                    latitude: loc[0],
                    longitude: loc[1]
                };
                showPosition(coords);
            });
        }

        /* End*/

        function calculateAndDisplayRoute(latitude, longitude, currentElem) {
            directionsService = new google.maps.DirectionsService;
            directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);
            if (user_lat && user_lng) {
                directionsService.route({
                    origin: new google.maps.LatLng(user_lat, user_lng),
                    destination: new google.maps.LatLng(latitude, longitude),
                    travelMode: 'DRIVING'
                }, function (response, status) {
                    if (status === 'OK') {
                        directionsDisplay.setDirections(response);
                        currentElem.addClass('close-direction');
                        currentElem.removeClass('show-direction');
                        clearLocations();
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            }
        }

        function getAllStores() {
            jQuery.ajax({
                url: 'storelocator/index/stores',
                type: 'GET',
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        setMarkers(map, data);
                    }
                }
            });
        }

        function clearLocations() {
            for (var i = 0; i < Allmarker.length; i++) {
                Allmarker[i].setMap(null);
            }
            Allmarker.length = 0;
        }

        if (JQuery("#googleMap").length > 0) {
            initMap();
        }

        var previous = "";

        JQuery(".storelocatorsec .allcitybox").append("<div id='alphaindex'></div>");
        JQuery(".storelocatorsec .allcityUl li").each(function () {
            var current = JQuery(this).children("a").text().trim()[0];

            if (current != previous) {
                JQuery(this).attr("id", "first_letter_" + current);
                previous = current;
                JQuery(".storelocatorsec #alphaindex").append("<a href='#first_letter_" + current + "'>" + current + "</a><br/>");
            }
        });

        var citytop;
        if (JQuery(".storelocatorsec .allcitybox").length > 0) {
            citytop = JQuery(".storelocatorsec .allcitybox").offset().top;
        }

        JQuery(".popularcitys").scroll(function () {
            if (JQuery(this).scrollTop() > citytop - 190) {
                if (!JQuery(".storelocatorsec #alphaindex").hasClass("fixedalpha")) {
                    JQuery(".storelocatorsec #alphaindex").addClass("fixedalpha");
                }
            } else {
                JQuery(".storelocatorsec #alphaindex").removeClass("fixedalpha");
            }
        });

        JQuery("body").on("click", ".allcityUl li a", function (e) {        
            var city_lat = JQuery(this).attr("data-lat");
            var city_lng = JQuery(this).attr("data-long");
            JQuery(this).parents('.select_city_block').hide();
            JQuery.cookie("city_lat", city_lat);
            JQuery.cookie("city_lng", city_lng);
            var citySelected = JQuery(this).text();
            JQuery("#selected-city").val(citySelected);
            JQuery(this).parents('.allcitybox').hide();            
            JQuery('.a_filterConmain.a_filterConmainShow, .a_newFilter .buttonDiv').show();
        });

        JQuery("body").on("click", ".a_productInfo a", function (e) {
            if (JQuery(window).width() > 600) {
                JQuery('.a_lookingPart').hide();
                JQuery('.p_storelist').show();
                JQuery('.a_storeListavail').show();
                JQuery('.storelocatorLeft').removeClass('storelocatorLeftFull');
            }
        });


        JQuery("body").on("click", ".a_selectBTitle h4 a,.a_brandPart .a_row8 .a_onePro a", function (e) {
            if (JQuery(window).width() > 600) {
                JQuery('.a_selectBrand').hide();
                JQuery('.p_storelist').show();
                JQuery('.a_storeListavail').show();
                JQuery('.a_filterwht').show();
            } else {
                JQuery('.a_selectBrand').addClass('slideleft');
                JQuery('.p_storelist').removeClass('slideright');
                JQuery('.a_filterwht').fadeIn();
            }

            JQuery(".storelocatorRight").removeClass("storelocatorRightFull");
            JQuery(".storelocatorLeft").removeClass("storelocatorLeftFull");
            JQuery(".loadingboxmain").show();
            setTimeout(function () {
                JQuery(".loadingboxmain").hide();
            }, 2000);

            JQuery('.a_storfilteropen').show();
        });
		JQuery("body").on("click", ".p_storedetilsbox a.storeName", function () {        
				JQuery(this).parent().siblings('.p_storedetilsbox').hide();
				var parentId = JQuery(this).parent().attr('id');
				var matches = parentId.match(/(\d+)/);
				var dealerId = matches[0];
				var baseUrl = window.location.origin;
                var url = baseUrl + "/storelocator/index/filters";
                JQuery.ajax({
					url: url,
					type: 'POST',
					showLoader: true,
					data: {storedetails: dealerId},
					dataType: 'html',
					success: function (data) {
						JQuery('#' + parentId).append(data);
						
						JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .mappindetailbox .storehead, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder ').hide();                
						JQuery(".p_storelist .storehead.stores-header").toggleClass("hide-headerTitle");
						JQuery('.p_storelistbg').hide();
						JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storelistbox .p_storedetilsbox .p_storeloction .storehead p').show();
						JQuery('.a_flatMain').slick('refresh');
						if (JQuery(window).width() > 767) {
							JQuery('.p_storelistbox').css('top', '0px');
							JQuery('.p_storelistbox').addClass("changeHeight");
						}
					}
				});
            });
        

        JQuery("body").on("click", ".p_storelist .a_storeListavail .p_storelistbox .p_storedetilsbox .p_storeloction .p_loctiontitle h2 > img", function () {
            JQuery('.a_likespops').hide();
			JQuery('.p_storeloction').hide();
            JQuery('.p_storedetilsbox, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder').show();
            JQuery(".p_storedetilsbox.view-more-stores").hide();
            JQuery('.mappindetailbox').hide();
            if (JQuery(window).width() > 767) {
                JQuery('.p_storelistbox').css('top', '70px');
				JQuery('.p_storelistbox').removeClass("changeHeight");				
            }
            resetmarkers();
        });
		
        JQuery("body").on("click", ".p_storelist .a_storeListavail .p_storelistbox .p_storeloction .storehead p > img", function () {
            if (JQuery(window).width() < 768) {                
                JQuery('.p_storedetilsbox, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder').show();
                 JQuery(".page-header.dealer-hide-header").toggleClass("hide-header");
                 JQuery(".page-header").removeClass("dealer-hide-header");
            }
        });        
		JQuery("body").on("click", ".p_storelistbox .p_storedetilsbox .p_knowmore ul .p_phone", function (e) {
            if (JQuery(window).width() < 768) {	
			e.preventDefault();
                JQuery(this).parent().parent().siblings('.a_storeLList').show();
				JQuery(this).parent().parent().siblings(".a_storeLList").children(".a_storeLBlack").addClass("a_callpopupshow");
                JQuery(this).parent().parent().siblings(".a_storeLList").children(".a_storeLBlack").children(".a_continuPopCon").addClass("show");
            } else{
               JQuery(this).parent().parent().siblings('.a_storeLList').show();
               JQuery('.p_storelistbox').css('overflow-y', 'hidden');     
            }
        });
        
        JQuery("body").on("click", ".p_storedetilsbox.located .p_knowmore ul li.p_phone", function () {				
            if (jQuery(window).width() < 768) {
                jQuery(this).parent().parent().siblings('.a_storeLList').show();
                jQuery(".a_storeLList .a_storeLBlack").addClass("a_callpopupshow");
                jQuery(".a_storeLBlack .a_continuPopCon").addClass("show");
            } else{
               jQuery(this).parent().parent().siblings('.a_storeLList').show();                   
            }
        });
		JQuery("body").on("click", ".storelocatorsec .storelocatorMain .storelocatorLeft .p_storeloction .p_storecallderction .p_storecall", function () {
            JQuery(this).parent().parent().siblings('.a_storeLList').show();
            if (JQuery(window).width() < 768) {
                JQuery(".a_storeLList .a_storeLBlack").addClass("a_callpopupshow");
                JQuery(".a_storeLBlack .a_continuPopCon").addClass("show");
            }
        });
		JQuery("body").on("click", ".a_storeLBlack", function () {       
            if (JQuery(window).width() < 600) {
                JQuery(".a_storeLList .a_storeLBlack").removeClass("a_callpopupshow");
                JQuery(".a_storeLBlack .a_continuPopCon").removeClass("show");
            }
        });

        JQuery("body").on("click", ".a_callAndreq ul li #callBack", function (e) {
            var baseUrl = window.location.origin;
            var url = baseUrl + "/storelocator/index/sfdc";
            var storeid = JQuery(this).attr('data-storeid');
			var thisCallback= JQuery(this);			
            JQuery.ajax({
                showLoader: true,
                url: url,
                data: {
                    storeid: storeid
                },
                type: "POST",
                success: function () {
                    if (JQuery(window).width() > 600) {
                        JQuery(thisCallback).parent().parent().parent().parent().parent().parent().siblings('.a_continuSdop').show();
                    } else {
                        JQuery(".a_storeLList .a_storeLBlack").removeClass("a_callpopupshow");
                        JQuery(".a_storeLBlack .a_continuPopCon").removeClass("show");
                        JQuery(".a_continuSdop .a_continuSdopBlack").addClass("a_callbackpopopen");
                        JQuery(".a_continuSdop .a_continuPopCon").addClass("show");
                    }
                }
            });
        });

        JQuery("body").on("click", ".p_requestcall", function (e) {
            if (JQuery(window).width() > 600) {
                JQuery('.a_continuSdop').show();
            } else {
                JQuery(".a_continuSdop .a_continuSdopBlack").addClass("a_callbackpopopen");
                JQuery(".a_continuSdop .a_continuPopCon").addClass("show");
            }
        });

        JQuery(".a_continuSdopBlack").click(function () {
            if (JQuery(window).width() < 600) {
                JQuery(".a_continuSdop .a_continuSdopBlack").removeClass("a_callbackpopopen");
                JQuery(".a_continuSdop .a_continuPopCon").removeClass("show");
            }
        });

        JQuery("body").on("click", ".a_continuPopCon", function (e) {
            if (JQuery(window).width() < 600) {
                e.stopPropagation();
            }
        });

        JQuery('.a_lookingPart .storehead p img').click(function () {
            if (JQuery(window).width() > 600) {
                JQuery('.a_lookingPart').hide();
                JQuery('.selectCityBox').show();
            } else {                
                window.history.back();
            }
        });
		JQuery("body").on("click", ".p_storelist .storehead p img", function (e) {        
            if (JQuery(window).width() > 600) {
                JQuery('.p_storelist').hide();
                JQuery('.a_selectBrand').show();
            } else {
                JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");                                    
                    JQuery(".page-header").toggleClass("hide-header");
                    JQuery(".p_storelist .storehead.stores-header").toggleClass("hide-headerTitle");                    
            }
        });
		JQuery("body").on("click", ".a_filterpartMain .storehead p img", function (e) {         
            if (JQuery(window).width() > 600) {
                JQuery('.a_filterpartMain').hide();
                JQuery('.p_storelist').show();
            } else {
                JQuery('.a_filterpartMain').fadeOut(200);
            }
        });
		JQuery("body").on("click", ".p_storeloction .storehead p img", function (e) {        
            if (JQuery(window).width() > 600) {
                JQuery('.p_storeloction').hide();
                JQuery('.p_storelistbg').hide();
            } else {
                JQuery('.p_storeloction').fadeOut(200);
                JQuery('.p_storelist').removeClass('slideright');
                JQuery('.p_storelistbg').fadeOut(200);
                JQuery(".p_storelist .storehead.stores-header").toggleClass("hide-headerTitle");                 
            }
        });
		JQuery("body").on("click", ".mappindetailbox .storehead p img", function (e) {         
            if (JQuery(window).width() > 600) {
                JQuery('.mappindetailbox').hide();
                JQuery('.p_storelist').show();
            } else {
                JQuery('.mappindetailbox').slideUp();
                JQuery('.p_storelist').show();
            }
        });

        JQuery("body").on("click", ".a_continuPopCon .a_mainCcOn a", function (e) {
            if (JQuery(window).width() < 600) {
                JQuery(".a_continuSdop .a_continuSdopBlack").removeClass("a_callbackpopopen");
                JQuery(".a_continuSdop .a_continuPopCon").removeClass("show");
            } else {
                JQuery('.a_continuSdop').hide();
            }
        });

        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .a_lookingPart .a_lookProtab ul li a').click(function () {
            JQuery(this).addClass('active');
            JQuery(this).parent().siblings().children('a').removeClass('active');
            var getData = JQuery(this).attr('data-tab');
            JQuery('#' + getData).fadeIn(200);
            JQuery('#' + getData).siblings().fadeOut(0);
        });

        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .a_lookingPart .a_productInfo .a_row8 .a_onePro a').click(function () {
            JQuery(this).addClass('active');
            JQuery(this).parent().siblings().children('a').removeClass('active');
        });

        JQuery('.a_filterTabs .a_filterLink li a').click(function () {
            JQuery(this).addClass('active');
            JQuery(this).parent().siblings().children('a').removeClass('active');
            var getData = JQuery(this).attr('data-tab');
            JQuery('#' + getData).addClass('a_storFillConShow');
            JQuery('#' + getData).siblings().removeClass('a_storFillConShow');
        });

        JQuery('.a_filterwht ul li a').click(function () {
            var getData = JQuery(this).attr('data-tab');
            JQuery('.a_filterpartMain').fadeIn(200);
            JQuery('#' + getData).addClass('a_storeAllfilShow');
            JQuery('#' + getData).siblings().removeClass('a_storeAllfilShow');
        });

        JQuery('.a_storeAllfil .a_storFillCon .a_searchPart input[type="text"]').keyup(function () {
            var searchText = JQuery(this).val().toUpperCase();
            JQuery(this).parent('.a_searchPart').siblings('ul').children('li').find('label').each(function () {
                var currentLiText = JQuery(this).text().toUpperCase(),
                        showCurrentLi = currentLiText.indexOf(searchText) !== -1;
                JQuery(this).parents('li').toggle(showCurrentLi);
            });
        });

        JQuery('.a_newFilter .a_filterConmain .a_mainfilBlock .a_filterCon .searchPart input[type="text"]').keyup(function () {
            var searchText = JQuery(this).val().toUpperCase();
            JQuery(this).parent('.searchPart').siblings('ul').children('li').find('label').each(function () {
                var currentLiText = JQuery(this).text().toUpperCase(),
                        showCurrentLi = currentLiText.indexOf(searchText) !== -1;
                JQuery(this).parents('li').toggle(showCurrentLi);
            });
        });

        JQuery('.a_storFillCon .a_applyBtn .a_aplybtn').click(function () {
            JQuery('.a_filterpartMain').hide();
            var filtercheck = JQuery(this).parents('.a_storFillCon').children('ul').find('input').filter(':checked').length;
            var getPId = JQuery(this).parents('.a_storFillCon').attr('id');
            JQuery('.a_filterTabs .a_filterLink li a[data-tab="' + getPId + '"]').children('i').text('(' + filtercheck + ')');
        });

        JQuery('.a_storFillCon .a_applyBtn .a_cnclBtn').click(function () {
            JQuery('.a_filterpartMain').hide();
            JQuery(this).parents('.a_storFillConShow').children('ul').find('input[type="checkbox"],input[type="radio"]').prop('checked', false);
            var getId = JQuery(this).parents('.a_storFillConShow').attr('id');
            JQuery('.a_filterTabs .a_filterLink li a[data-tab="' + getId + '"]').children('i').text('');
        });

        function deviceheight() {
            var winHeight = JQuery(window).height();
            var populercityHeight = winHeight - 157;            
            var lookheight = winHeight - 205;
            JQuery('.a_lookingPart .a_productInfo').height(lookheight);

//        var selectBHeight = winHeight - 181;
//        JQuery('.a_selectBrand .a_brandPart').height(selectBHeight);

            var storeListHeight = winHeight - 140;
            JQuery('.a_storeListavail .p_storelistbox').height(storeListHeight);
            var filterheight = winHeight - 60;
            JQuery('.a_filterpartMain .a_filterpart').height(filterheight);
            var p_storenames1 = winHeight - 164;
            JQuery('.p_findnearbystore .p_storeblack .p_findstoredeta .p_findstorewhite .p_storenames').height(p_storenames1);
        }

        if (JQuery(window).width() < 600) {
            deviceheight();
        }

        function devideDesk() {
            var winHeight = JQuery(window).height();
            var selectCarcitys = winHeight - 210;            
            var a_lookingtInfoShow = winHeight - 252;
            JQuery('.a_lookingPart .a_productInfoShow').height(a_lookingtInfoShow);
            var lookppart = winHeight - 105;
            JQuery('.storelocatorLeft .a_lookingPart').height(lookppart);
            var storelocatoBrand = winHeight - 105;
            JQuery('.storelocatorLeft .a_selectBrand').height(storelocatoBrand);
        }

        if (JQuery(window).width() > 600) {
            devideDesk();
        }

        if (JQuery(window).width() < 600) {
            JQuery(".storelocatorRight").removeClass("storelocatorRightFull");
            JQuery(".storelocatorLeft").removeClass("storelocatorLeftFull");
        }

        /*    JQuery(".p_storetitle,.p_topborder").swipe({
         swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
         if (direction == "up") {
         JQuery(".a_storeListavail").addClass("a_fullopenstrlist");
         } else if (direction == "down") {
         JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");
         }
         },
         threshold: 0
         });*/

        JQuery('.p_storetitle,.p_topborder').click(function () {
            if (!JQuery(".a_storeListavail").hasClass('a_fullopenstrlist')) {
                JQuery(".a_storeListavail").addClass("a_fullopenstrlist");                
                if (JQuery(window).width() < 768) {
               JQuery(".p_storedetilsbox").show();
               JQuery(".p_storedetilsbox.view-more-stores").hide();
               JQuery('#stores-view-more').show();               
           }
           
                
                if (JQuery(window).width() < 600) {                    
                    JQuery(".page-header").toggleClass("hide-header");
                    JQuery(".p_storelist .storehead.stores-header").toggleClass("hide-headerTitle");
                    
                }
            } else {
                JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");
                if (JQuery(window).width() < 768) {                    
                    JQuery(".page-header").toggleClass("hide-header");
                    JQuery(".p_storelist .storehead.stores-header").toggleClass("hide-headerTitle");
                }
            }
        });


        /*    JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storelistbox').scroll(function(){
         var thisScroll = JQuery(this).scrollTop();
         if(thisScroll > 0){
         setTimeout(function(){
         JQuery(".a_storeListavail").addClass("a_fullopenstrlist");
         },100);
         
         }else{
         setTimeout(function(){
         JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");
         },300);               
         }
         });*/

        /*        JQuery(".storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storelistbox").swipe({
         swipeDown: function(event, direction, distance, duration, fingerCount, fingerData) {
         var thisScroll = JQuery(this).scrollTop();
         if(thisScroll == 0){
         if (direction == "up") {
         JQuery(".a_storeListavail").removeClass("a_fullopenstrlist");
         }
         }
         },
         threshold: 0
         });
         */
		 
        JQuery("body").on("click", ".fullmainmap img", function () {
            if (JQuery(window).width() > 600) {        
                JQuery('.storelocatorRight').addClass('store-selected'); 
            }
        });
        JQuery("body").on("click", ".fullmainmap", function () {
            setTimeout(function () {
                if (outsidemarkerclick == 1) {
                    outsidemarkerclick = 0                    
                } else {                
                    JQuery('.mappindetailbox').slideUp();
                    JQuery('.p_storelist').fadeIn();
                        if (JQuery(window).width() > 600) {
                            if(JQuery('.storelocatorRight').hasClass('store-selected')){
                            JQuery(".p_storedetilsbox").show();
                            JQuery(".p_storedetilsbox.view-more-stores").hide(); 
                            JQuery('#stores-view-more').show();
                            JQuery('.p_storedetilsbox, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder').show();
                            JQuery(".p_storedetilsbox.view-more-stores").hide();            
                            JQuery('.p_storelistbox').css('top', '70px');
                            JQuery('.storelocatorRight').removeClass('store-selected');
							JQuery('.p_storelistbox').removeClass("changeHeight");							
                        }
                    }                    
                    resetmarkers();
                }
            }, 300);
        });

        JQuery('.mappindetailbox .desktopbacklist').click(function () {

            JQuery('.mappindetailbox').slideUp(200);
            JQuery('.p_storelist').fadeIn(100);            
            if (JQuery(window).width() > 600) {
                JQuery(".p_storedetilsbox").show();
                JQuery(".p_storedetilsbox.view-more-stores").hide(); 
                JQuery('#stores-view-more').show();
                JQuery('.p_storedetilsbox, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_storetitle, .storelocatorsec .storelocatorMain .storelocatorLeft .p_storelist .a_storeListavail .p_topborder').show();
                JQuery(".p_storedetilsbox.view-more-stores").hide();            
                JQuery('.p_storelistbox').css('top', '70px');
                JQuery('.storelocatorRight').removeClass('store-selected');
				JQuery('.p_storelistbox').removeClass("changeHeight");
            }
            resetmarkers();
        });

        JQuery(".seachlocationIcon").click(function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getGeoLocationCallback, getCityLocationErrorCallBack);
            }
        });
        
        JQuery(".seachlocationIcon.choose-city").click(function () {
            JQuery(".a_filterConmain").show();
            JQuery(".a_newFilter .buttonDiv").show();
            JQuery(".a_newFilter .allcitybox").hide();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(chooseCityCallback, chooseCityErrorCallBack);
            }
        });

        if (JQuery(window).width() > 600) {            
            JQuery("body").on("click", ".a_storeLBlack", function () {
                JQuery(this).parent().hide();
                JQuery('.p_storelistbox').css('overflow-y', 'scroll'); 
            });           
            JQuery("body").on("click", ".a_continuSdopBlack", function () {
                JQuery(this).parent().hide();
                JQuery('.a_continuSdop').hide();
            });

            JQuery('.a_callBalck').click(function () {
                JQuery(this).parent().hide();
            });

            
            JQuery("body").on("click", ".a_callAndreq ul li a.callStore", function (e){
                e.stopPropagation();
                var phone= JQuery(this).attr("href");                
                var phone_no = phone.substring(4, phone.length);                
                JQuery(this).children('h4').text(phone_no);
                JQuery(this).children('p').text('You can call on above number');

                /* JQuery('.a_storeLList').hide();
                 JQuery('.a_callStorePop').show();*/
            });
            JQuery('.p_callpoint').click(function () {
                JQuery('.a_callStorePop').show();
            });

        }
        if (JQuery(window).width() < 600) {
          JQuery("body").on("click", ".p_storedetilsbox.located .a_storeLBlack, .p_storedetilsbox.located .a_continuSdopBlack", function () {
                JQuery(this).parent().hide(); 
                JQuery('.a_continuSdop').hide();                
            });        
            JQuery("body").on("click", ".p_storedetilsbox.located .a_callAndreq ul li a.callStore", function (e){
                e.stopPropagation();
                var phone= JQuery(this).attr("href");                
                var phone_no = phone.substring(4, phone.length);                
                JQuery(this).children('h4').text(phone_no);
                JQuery(this).children('p').text('You can call on above number');
            });
        }

        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .a_lookingPart .a_lookTitle h4 img').click(function () {
              window.history.back(); 
        });
		JQuery("body").on("click", ".storelocatorsec .storelocatorMain .storelocatorLeft .p_storeloction .p_loctiontitle h2 img", function (e){        
            JQuery('.p_storeloction').fadeOut(200);
            JQuery('.p_storelist').removeClass('slideright');
            JQuery('.p_storelistbg').fadeOut(200);
            JQuery('#stores-view-more').show(); 
        });

        JQuery('.p_selectproduct .p_allselect_pro .p_selectanother_product .p_selectbox .p_designbox .p_nearbystore a').click(function () {
            if (JQuery(window).width() > 768) {
                JQuery('.p_selectemipopup').show();
            } else {
                JQuery('.p_selectemipopup').addClass('blacktop');
                JQuery('.p_selectemipopup .p_selectwhitebg .p_selectfullwidth').addClass('selectbottom');
            }
        });

        JQuery('.p_selectemipopup').click(function () {
            if (JQuery(window).width() < 768) {
                JQuery(this).removeClass("blacktop");
                JQuery(this).find(".p_selectfullwidth").removeClass("selectbottom");
                JQuery('body').css('overflow-y', 'scroll');
            }
        });

        JQuery('.p_selectemipopup .p_selectwhitebg .p_selectfullwidth').click(function (e) {
            e.stopPropagation();
        });

        JQuery('.p_selectemipopup .p_selectwhitebg .p_selectfullwidth .p_selectclosebtn a').click(function () {
            JQuery('.p_selectemipopup').hide();

        });

        JQuery('.p_selectemipopup .p_selectwhitebg .p_selectfullwidth .p_findsroreblack .p_findsrorepdpdesign .p_findstorerow .p_findstorebox .p_findboxdetapdp').click(function () {
            JQuery(this).addClass('borderfinds');
            JQuery(this).parent('.p_findstorebox').siblings().children('.p_findboxdetapdp').removeClass('borderfinds');
        });


        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .a_filterwht ul li a img').click(function () {
            if (JQuery(window).width() > 768) {
                JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .p_nostoredesign').show();
            } else {
                JQuery('.p_nostoredesign').addClass('nostoretop');
                JQuery('.p_nostorewhitebg').addClass('nostorebottom');
            }
        });

        JQuery('.p_nostoredesign').click(function () {
            if (JQuery(window).width() > 768) {
                JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .p_nostoredesign').hide();
            } else {
                JQuery('.p_nostoredesign').removeClass('nostoretop');
                JQuery('.p_nostorewhitebg').removeClass('nostorebottom');
            }
        });

        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .p_nostoredesign .p_nostorewhitebg').click(function (e) {
            e.stopPropagation();
        });

        JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .p_nostoredesign .p_nostorewhitebg .p_openfilter a').click(function () {
            JQuery('.storelocatorsec .storelocatorMain .storelocatorLeft .p_nostoredesign').hide();
        });
        
		JQuery("body").on("click", ".a_likespops .a_likebLack .a_innerLinke > ul li .likeno", function () {
            if (JQuery(window).width() > 768) {
                JQuery(this).parents('.a_likespops').hide();
            } else {
                JQuery('.a_likespops .a_likebLack').removeClass('a_likebLackShow');
                JQuery('.a_likespops .a_likebLack .a_innerLinke').removeClass('a_innerLinkeShow');
            }
        });        
		JQuery("body").on("click", ".a_likespops .a_likebLack .a_innerLinke > ul li .likeyes", function () {
            if (JQuery(window).width() > 768) {
                JQuery(this).parents('.a_likespops').hide();
                JQuery('.a_continuSdop').show();
            } else {
                JQuery('.a_likespops .a_likebLack').removeClass('a_likebLackShow');
                JQuery('.a_likespops .a_likebLack .a_innerLinke').removeClass('a_innerLinkeShow');

                JQuery('.a_continuSdop .a_continuSdopBlack').addClass('a_callbackpopopen');
                JQuery('.a_continuSdopBlack .a_continuPopCon').addClass('show');
            }
        });

        JQuery('.a_likebLack').click(function () {
            if (JQuery(window).width() > 768) {
                JQuery(this).parent('.a_likespops').hide();
            } else {
                JQuery('.a_likespops .a_likebLack').removeClass('a_likebLackShow');
                JQuery('.a_likespops .a_likebLack .a_innerLinke').removeClass('a_innerLinkeShow');
            }
        });

        JQuery('.a_likespops .a_likebLack .a_innerLinke').click(function (e) {
            e.stopPropagation();
        });

        var animating = false;
        var cardsCounter = 0;
        var numOfCards = 4;
        var decisionVal = 80;
        var pullDeltaX = 0;
        var deg = 0;
        var JQuerycard, JQuerycardReject, JQuerycardLike;

        function pullChange() {
            animating = true;
            deg = pullDeltaX / 10;
            JQuerycard.css("transform", "translateX(" + pullDeltaX + "px) rotate(" + deg + "deg)");

            var opacity = pullDeltaX / 100;
            var rejectOpacity = (opacity >= 0) ? 0 : Math.abs(opacity);
            var likeOpacity = (opacity <= 0) ? 0 : opacity;
            JQuerycardReject.css("opacity", rejectOpacity);
            JQuerycardLike.css("opacity", likeOpacity);
        }
        ;

        function release() {
            if (pullDeltaX >= decisionVal) {
                JQuerycard.addClass("to-right");
                if (JQuery(window).width() > 768) {
                    JQuery('.a_likespops').show();
                    JQuery('.p_wentcallback').show();
                } else {
                    JQuery('.a_likespops .a_likebLack').addClass('a_likebLackShow');
                    JQuery('.a_likespops .a_likebLack .a_innerLinke').addClass('a_innerLinkeShow');

                    JQuery('.p_wentcallback').addClass('wentslideup');
                    JQuery('.p_wentcallback .p_wentfullbg .p_wntesbtnsbox').addClass('wentslidecall');
                }

            } else if (pullDeltaX <= -decisionVal) {
                JQuerycard.addClass("to-left");
            }

            if (Math.abs(pullDeltaX) >= decisionVal) {
                JQuerycard.addClass("inactive");
                setTimeout(function () {
                    JQuerycard.addClass("below").removeClass("inactive to-left to-right");
                    cardsCounter++;
                    if (cardsCounter === numOfCards) {
                        cardsCounter = 0;
                        JQuery(".demo__card").removeClass("below");
                    }
                }, 300);
            }

            if (Math.abs(pullDeltaX) < decisionVal) {
                JQuerycard.addClass("reset");
            }

            setTimeout(function () {
                JQuerycard.attr("style", "").removeClass("reset")
                        .find(".demo__card__choice").attr("style", "");
                pullDeltaX = 0;
                animating = false;
            }, 300);
        }
        ;

        JQuery(document).on("mousedown touchstart", ".demo__card:not(.inactive)", function (e) {
            if (animating)
                return;
            JQuerycard = JQuery(this);
            JQuerycardReject = JQuery(".demo__card__choice.m--reject", JQuerycard);
            JQuerycardLike = JQuery(".demo__card__choice.m--like", JQuerycard);
            var startX = e.pageX || e.originalEvent.touches[0].pageX;

            JQuery(document).on("mousemove touchmove", function (e) {
                var x = e.pageX || e.originalEvent.touches[0].pageX;
                pullDeltaX = (x - startX);
                if (!pullDeltaX)
                    return;
                pullChange();
            });

            JQuery(document).on("mouseup touchend", function () {
                JQuery(document).off("mousemove touchmove mouseup touchend");
                if (!pullDeltaX)
                    return; // prevents from rapid click events
                release();
            });
        });

        JQuery('.a_storfilteropen').click(function () {
            JQuery('.Storefilter').addClass('filterShow');
        });
        
        JQuery('.storeListzero .szopenfilter').click(function () {
            JQuery('.Storefilter').addClass('filterShow');
        });

            

            JQuery(".category").click(function () {
                var categorylob = JQuery(this).attr('data-categorylob');
                var baseUrl = window.location.origin;
                var url = baseUrl + "/storelocator/index/session";
                JQuery.ajax({
                    showLoader: true,
                    url: url,
                    data: {
                        categorylob: categorylob
                    },
                    type: "POST",
                    success: function () {
                        if (JQuery(window).width() > 600) {
                            JQuery('.a_lookingPart').hide();
                            JQuery('.p_storelist').show();
                            JQuery('.a_storeListavail').show();
                            JQuery('.storelocatorLeft').removeClass('storelocatorLeftFull');
                            location.reload();
                        } else {
                            JQuery('.a_lookingPart').addClass('slideleft');
                            JQuery('.p_storelist').removeClass('slideright');
                            JQuery('.a_storeListavail').show();
							location.reload();
                        }
                    }
                });
                return false;
            });

            JQuery(".filterA").click(function (e) {
                JQuery('#filter').submit();
                e.preventDefault();
            });

            JQuery("#filter").submit(function (e) {
                e.preventDefault();
                var form = JQuery(this);
                var baseUrl = window.location.origin;
                var url = baseUrl + "/storelocator/index/session";
                JQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize(),
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            JQuery(".filterC").click(function (e) {
                var baseUrl = window.location.origin;
                var url = baseUrl + "/storelocator/index/session";
                JQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: {clearall: 'clearall'},
                    success: function () {
                        location.reload();
                    }
                });
            });
        
        
        
        /* end storelocator */
        /* Filter Options */
        JQuery('.a_newFilter.Storefilter .a_filterConmain .a_mainfilBlock .a_filterAccr').click(function () {
            JQuery(this).toggleClass('activeFilter');
            JQuery(this).parent('.a_mainfilBlock').siblings().children('.a_filterAccr').removeClass('activeFilter');
            JQuery(this).siblings('.a_filterCon').slideToggle(200);
            JQuery(this).parent('.a_mainfilBlock').siblings().children('.a_filterCon').slideUp(200);
        });

        JQuery('.a_newFilter.Storefilter .fitlerHear > img,.a_newFilter .buttonDiv .buttonOne > a').click(function () {
            JQuery('.newFilterBlack').hide();
            JQuery('.a_newFilter.Storefilter').removeClass('filterShow');
            JQuery('body').css('overflow-y', 'auto');
        });
        /* Filter Options */
        
        /* Load More Logic  Begins*/
        JQuery('#view-pincodes').click(function () {
            var baseUrl = window.location.origin;
			var url = baseUrl + "/storelocator/index/filters";
			JQuery.ajax({
				url: url,
				type: 'POST',
				showLoader: true,
				data: {pincode: 'pincode'},
				dataType: 'html',
				success: function (data) {
					JQuery('#pincodes').html(data);
					JQuery('#view-pincodes').remove();
				}
			});
        });
		
		JQuery('#view-dealers').click(function () {
			if(!JQuery(this).hasClass("seeLess")){
				var baseUrl = window.location.origin;
				var url = baseUrl + "/storelocator/index/filters";
				var btnText = document.getElementById("view-dealers");
				JQuery.ajax({
					url: url,
					type: 'POST',
					showLoader: true,
					data: {groups: 'groups'},
					dataType: 'html',
					success: function (data) {
						JQuery('#groupsList').html(data);
							btnText.innerHTML = "See Less";
							JQuery('#view-dealers').remove();	
					}
				});
			}			
        });
        
        JQuery('#view-categories').click(function () {
            var btnText = document.getElementById("view-categories");
            var countText = document.getElementById("category-count");
            if (btnText.innerHTML === "See Less") {
                JQuery( "li.view-more-categories" ).css( "display", "none" );
                btnText.innerHTML = "See More";
                countText.style.display = "block";
            } else {
                JQuery( "li.view-more-categories" ).css( "display", "block" );
                btnText.innerHTML = "See Less";
                countText.style.display = "none";
            }
        });
        
        JQuery('#stores-view-more').click(function (e) {
            e.preventDefault();
            JQuery(".view-more-stores" ).css( "display", "block" );
            JQuery('#stores-view-more').css("display","none");
        });
        /* Load More Logic Ends*/
        JQuery('.viewCitypart').click(function () {            
            JQuery(".Storefilter.filterShow" ).css( "display", "none" );
        });
        if(JQuery('.a_filterConmain').length > 0){
            var getfilterHeight = JQuery(window).height();
            var getheght = getfilterHeight - 177;
            JQuery('.a_newFilter .a_filterConmain').height(getheght);
            var getcityBoxHeight= getfilterHeight-122;
            JQuery('.a_newFilter .allcitybox').height(getcityBoxHeight);
        }        
        
    });
   
});
