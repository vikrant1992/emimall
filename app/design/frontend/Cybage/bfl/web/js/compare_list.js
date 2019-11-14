/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require(['jquery', 'mage/url','Magento_Customer/js/customer-data'], function ($, url, customerData) {
$(document).ready(function() {
    /********** Start: Google Analytics code for Compare Page ************************************/
	/**
	 * PPT: EMI_MALL_Compare implementation : Screen-2 : Compare Buy Now
	 * Get data layer code executed whenever someone click on 'Buy Now' button in Compare
	 */	
	$("div .p_nearbystoreBuy a").click(function() {
		var linkUrl = url.build('customcatalog/product/getproduct');		
		var productId = $(this).parent().siblings(".p_wishlist").attr('data-id')
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
						* PPT: EMI_MALL_Compare implementation : Screen-3 from Latest Version: Compare Buy Now
						*/	
						dataLayer.push({
							'ecommerce': {
							'detail': {
							    'actionField': {'list': 'Compare'},	
							    'products': [{
									'name': resp.data['name'],
									'id': resp.data['id'],
									'price': resp.data['price'],
									'brand': resp.data['brand'],
									'category': resp.data['category'],
									'variant': resp.data['variant']
								   }]
								}
						    }			
						});	
						
						/**
						* PPT: EMI_MALL_Compare implementation : Screen-4 from Latest Version: Compare Buy Now
						*/	
						dataLayer.push({
							'event': 'addToCart',
							'ecommerce': {
							'currencyCode': resp.data['currency'],							
							'add': {                               
							  'products': [{
								'name': resp.data['name'],
								'id': resp.data['id'],
								'price': resp.data['price'],
								'brand': resp.data['brand'],
								'category': resp.data['category'],
								'variant': resp.data['variant'],
								'quantity': 1,
								'dimension11': 'Compare',	
							   }]
							}
						  }			
						});
						
						/**
						* PPT: EMI_MALL_Final implementation on 19th : Screen-1 from Latest Version: Compare Buy Now
						*/	
						var pageTitle = $(document).find("title").text();
						var buttonText = $("div .a_rightnotiPop button").text();
						var productId = $(this).parent().siblings(".p_wishlist").attr('data-id');
						var customerId = '';
						dataLayer.push({
							'pageTitle': pageTitle,
							'event': 'Purchase_Click',                
							'clickText': 'Buy Now',
							'pageType': 'Compare',
							'customerID': customerId,
							'customerType': '',
							'clickPurchasevalue': productId
						});	
                    }
                }
            });
	});
	
	/**
	 * PPT: EMI_MALL_Compare implementation : Screen 5-6-7 : Compare Find Store
	 * Get data layer code executed whenever someone click on 'Find Store' button in Compare
	 */	
	$("div .p_nearbystore a").click(function() {
		var linkUrl = url.build('customcatalog/product/getproduct');		
		var productId = $(this).parent().siblings(".p_wishlist").attr('data-id');
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
						* PPT: EMI_MALL_Compare implementation : Screen-5 from Latest Version: Compare Find a store
						*/	
						dataLayer.push({
							  'ecommerce': {
								'detail': {
								  'actionField': {'list': 'Compare'},
								  'products': [{
									'name': resp.data['name'],
									'id': resp.data['id'],
									'price': resp.data['price'],
									'brand': resp.data['brand'],
									'category': resp.data['category'],
									'variant': resp.data['variant']
								   }]
								 }
							   }
							});

						
						/**
						* PPT: EMI_MALL_Compare implementation : Screen-6 from Latest Version: Compare Find a store
						*/	
						dataLayer.push({
							  'event': 'addToCart',
							  'ecommerce': {
								'currencyCode': resp.data['currency'],
								'add': {                                
								  'products': [{                        
									'name': resp.data['name'],
									'id': resp.data['id'],
									'price': resp.data['price'],
									'brand': resp.data['brand'],
									'category': resp.data['category'],
									'variant': resp.data['variant'],
									'quantity': 1,
									'dimension11' : 'Compare'
								   }]
								}
							  }
							});

						/**
						* PPT: EMI_MALL_Compare implementation : Screen-7 from Latest Version: Compare Find a store
						*/	
						  dataLayer.push({
							'event': 'checkout',
							'ecommerce': {
							  'checkout': {
								'actionField': {'step': 1, 'option': 'Visa'},
								'products': [{
									'name': resp.data['name'],
									'id': resp.data['id'],
									'price': resp.data['name'],
									'brand': resp.data['price'],
									'category': resp.data['category'],
									'variant': resp.data['variant'],
									'quantity': 1,
									'dimension11' : 'Compare'
							   }]
							 }
						   }
						  });

						/**
						* PPT: EMI_MALL_Final implementation on 19th : Screen-1 from Latest Version: Compare Find Now
						*/	
						var pageTitle = $(document).find("title").text();
						var buttonText = $("div .a_rightnotiPop button").text();
						var productId = $(this).parent().siblings(".p_wishlist").attr('data-id');
						var customerId = '';
						dataLayer.push({
							'pageTitle': pageTitle,
							'event': 'Purchase_Click',                
							'clickText': 'Find Store',
							'pageType': 'Compare',
							'customerID': customerId,
							'customerType': '',
							'clickPurchasevalue': productId
						});							  
                    }
                }
            });
	});

	/**
	 * PPT: EMI_MALL_Login_Event_Version_1.ppt implementation : Screen-2 : Desktop
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
			'pageType': 'Compare',
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
			'pageType': 'Compare',
			'customerID': customerId,
			'customerType': ''
		});		
	});	
	
	/**
	 * PPT: EMI_MALL_Login_Event_Version_1.ppt implementation : Screen-3 : Desktop
	 * Get data layer code executed whenever someone click on 'Get your pre-approved offer' button in header
	 */
	$(".Subbutton").click(function() {
		var pageTitle = $(document).find("title").text();
		var customerId = '';
		dataLayer.push({
			'pageTitle': pageTitle,
			'event': 'Login_PSTP',                
			'clickText': 'Get OTP',
			'pageType': 'Compare',
			'customerID': customerId,
			'customerType': ''
		});		
	});
	
	/**
	 * PPT: EMI_MALL_COMPARE_Version_1.ppt implementation : Screen-2 : Desktop
	 * Get data layer code executed whenever someone click on 'Closed' button in header
	 */
	$("div .p_closebtnicon").click(function() {		
		var pageTitle = $(document).find("title").text();
		var buttonText = $("div .a_rightnotiPop button").text();
		var customerId = '';
		var productId = $(this).parent().siblings(".p_wishlist").attr('data-id');
		var count = JSON.parse(localStorage.getItem('recently_viewed_product'));
		if(productId) {
			productId = productId;
		} else {
			productId = 'NA';
		}
		if(customerId) {
			customerId = customerId;
		} else {
			customerId = 'NA';
		}
		dataLayer.push({
			'pageTitle': pageTitle,
			'event': 'Feature_Click',                
			'clickText': 'Remove',
			'pageType': 'Compare',
			'customerID': customerId,
			'clickComparevalue': productId,
			'clickFavouritevalue': productId,
			'dimension10': JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products']['count'],
			'customerType': ''
		});		
	});	
	
	/**
	 * PPT: EMI_MALL_COMPARE_Version_1.ppt implementation : Screen-2 : Desktop
	 * Get data layer code executed whenever someone click on 'Hide' button in header
	 */
	$("div .p_hidecommon input").click(function() {
		var pageTitle = $(document).find("title").text();
		var buttonText = $("div .a_rightnotiPop button").text();
		var customerId = '';
		var productId = $(this).parent().siblings(".p_wishlist").attr('data-id');
		var count = JSON.parse(localStorage.getItem('recently_viewed_product'));
		if(productId) {
			productId = productId;
		} else {
			productId = 'NA';
		}
		if(customerId) {
			customerId = customerId;
		} else {
			customerId = 'NA';
		}
		dataLayer.push({
			'pageTitle': pageTitle,
			'event': 'Feature_Click',                
			'clickText': 'Hide',
			'pageType': 'Compare',
			'customerID': customerId,
			'clickComparevalue': productId,
			'clickFavouritevalue': productId,
			'dimension10': JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products']['count'],
			'customerType': ''
		});	
	});
	
	/**
	 * PPT: EMI_MALL_COMPARE_Version_1.ppt implementation : Screen-2 : Desktop
	 * Get data layer code executed whenever someone click on 'Wishlist' button in header
	 */
	$("div .p_wishlist i.fa-heart-o").click(function() {
		var pageTitle = $(document).find("title").text();
		var buttonText = $("div .a_rightnotiPop button").text();
		var customerId = '';
		var productId = $(this).parent().siblings(".p_wishlist").attr('data-id');
		var count = JSON.parse(localStorage.getItem('recently_viewed_product'));
		if(productId) {
			productId = productId;
		} else {
			productId = 'NA';
		}
		if(customerId) {
			customerId = customerId;
		} else {
			customerId = 'NA';
		}
		dataLayer.push({
			'pageTitle': pageTitle,
			'event': 'Feature_Click',                
			'clickText': 'Wishlist',
			'pageType': 'Compare',
			'customerID': customerId,
			'clickComparevalue': productId,
			'clickFavouritevalue': productId,
			'dimension10': JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products']['count'],
			'customerType': ''
		});	
	});

	/**
	 * PPT: EMI MALL Track implementation : Screen-2 : Compare Add Product
	 * Get data layer code executed whenever someone click on 'Add Product' button in Compare
	 */	
	$("div .p_addproductbtn a").click(function() {
		var pageTitle = $(document).find("title").text();
		var linkUrl = url.build('customcatalog/product/getproduct');		
		//var productId = $(this).parent().siblings(".p_wishlist").attr('data-id');
		var productId = $(this).parent().siblings(".p_productdrop").children(".p_serchproduct").attr('data-id');
		var customerId = '';
		if(customerId) {
			customerId = customerId;
		} else {
			customerId = 'NA';
		}
		dataLayer.push({
			'pageTitle': pageTitle,
			'event': 'Add_Product_Click',                
			'clickText': 'Add_Product',
			'pageType': 'Compare',
			'customerID': customerId,
			'clickComparevalue': productId,
			'dimension10': JSON.parse(localStorage.getItem('mage-cache-storage'))['compare-products']['count'],
			'customerType': ''
		});
         
		/**
		* PPT: EMI MALL Track implementation : Screen-3 from Latest Version: Compare Add Product
		*/ 
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
							dataLayer.push({
								'ecommerce': {
								'currencyCode': 'INR',							
								  'impressions': [{
									'name': resp.data['name'],
									'id': resp.data['id'],
									'price': resp.data['price'],
									'brand': resp.data['brand'],
									'category': resp.data['category'],
									'variant': resp.data['variant'],
									'list': 'Compare',
									'position': 1,
									'dimension8': 'NA',
									'dimension9': 'NA',
									'dimension6': 'NA'
								   }]
								}	
							});												
						}
					}
				});
		}		
	});
	
	/**
	 * PPT: EMI MALL Track implementation : Screen-4 : Compare Select Product
	 * Get data layer code executed whenever someone click on 'Select Product' button in Compare Page
	 */	
	$("div .p_selectimg").click(function() {
		var productImageId = $(this).parent().siblings(".p_wishlist").attr('data-id');		
		var pageTitle = $(document).find("title").text();
		var linkUrl = url.build('customcatalog/product/getproduct');
		var customerId = '';
		if(customerId) {
			customerId = customerId;
		} else {
			customerId = 'NA';
		}
		
		if(productImageId) {
			$.ajax({
					url: linkUrl,
					type: 'POST',
					data: {
						product_id: productImageId                  
					},
					showLoader: true,
					success: function (resp) {                    
						if (resp.success == true)
						{
							dataLayer.push({
								'event': 'productClick',
								'ecommerce': {
								'click': {
									'actionField': {'list': 'Compare'},		
									'products': [{
										'name': resp.data['name'],
										'id': resp.data['id'],
										'price': resp.data['price'],
										'brand': resp.data['brand'],
										'category': resp.data['category'],
										'variant': resp.data['variant'],
										'position': 1,
									    'dimension8' : 'NA',
									    'dimension9' : 'NA',
									    'dimension6' : 'NA'
								    }]
								  }
								}
							});
						}
					}
				});
		}
	});
	/********** End: Google Analytics code for Compare Page ************************************/
});
});