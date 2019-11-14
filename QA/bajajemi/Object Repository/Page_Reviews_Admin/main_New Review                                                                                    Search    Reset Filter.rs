<?xml version="1.0" encoding="UTF-8"?>
<WebElementEntity>
   <description></description>
   <name>main_New Review                                                                                    Search    Reset Filter</name>
   <tag></tag>
   <elementGuidId>080fa08f-44b8-41b7-9ad1-3c8943ebbfef</elementGuidId>
   <selectorCollection>
      <entry>
         <key>XPATH</key>
         <value>//main[@id='anchor-content']</value>
      </entry>
   </selectorCollection>
   <selectorMethod>XPATH</selectorMethod>
   <useRalativeImagePath>false</useRalativeImagePath>
   <webElementProperties>
      <isSelected>true</isSelected>
      <matchCondition>equals</matchCondition>
      <name>tag</name>
      <type>Main</type>
      <value>main</value>
   </webElementProperties>
   <webElementProperties>
      <isSelected>true</isSelected>
      <matchCondition>equals</matchCondition>
      <name>id</name>
      <type>Main</type>
      <value>anchor-content</value>
   </webElementProperties>
   <webElementProperties>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>class</name>
      <type>Main</type>
      <value>page-content</value>
   </webElementProperties>
   <webElementProperties>
      <isSelected>true</isSelected>
      <matchCondition>equals</matchCondition>
      <name>text</name>
      <type>Main</type>
      <value>    
        
    New Review

    
    
    
                    
            
                                    
    Search


    Reset Filter

                                        

            
                                    

        
            
        
            
                Actions
                                    Delete
                                    Update Status
                            
            
            
            
    Submit

        
        
        
                    
                            
                    
                

    
Status


Approved
Pending
Not Approved



            
            
    
        
            
                
                            
                    Select All                
                
                    Unselect All                
                            
                    Select Visible                
                
                    Unselect Visible                
            
        
        
    

    require(['jquery'], function($){
        'use strict';
        $('#reviwGrid_massaction-mass-select').change(function () {
            var massAction = $('option:selected', this).val();
            switch (massAction) {
                                case 'selectAll':
                    return reviwGrid_massactionJsObject.selectAll();
                    break;
                case 'unselectAll':
                    return reviwGrid_massactionJsObject.unselectAll();
                    break;
                                case 'selectVisible':
                    return reviwGrid_massactionJsObject.selectVisible();
                    break;
                case 'unselectVisible':
                    return reviwGrid_massactionJsObject.unselectVisible();
                    break;
            }
            this.blur();
        });
    });

    

                                                
                        
                            6                        
                    records found                    0 selected
                

                            
                    
                        20
                        
                        30
                        
                        50
                        
                        100
                        
                        200
                        
                    
                    per page

                    
                                                                                                    Previous page
                                                
                        
                            of 1                        
                                                Next page
                                            
                
                        
        
    
    
        
                                        
                                    
                                                                                     
                                                                                                                ID                                                                                                                Created                                                                                                                Status                                                                                                                Title                                                                                                                Nickname                                                                                                                Review                                                                                                                Type                                                                                                                Product                                                                                                                SKU                                                                                                                Action                                                                        
                                                    
                                                    
                                AnyYesNo                            
                                                    
                                                            
                                                    
                                Date selectorDate selector
            require([&quot;jquery&quot;, &quot;mage/calendar&quot;],function($){
                    $(&quot;#reviwGrid_filter_created_at1fbDDUB5ay1FL3HVcsuVCFk4qoA31yXX_range&quot;).dateRange({
                        dateFormat: &quot;M/d/yy&quot;,
                        timeFormat: &quot;&quot;,
                        showsTime: false,
                        buttonText: &quot;Date selector&quot;,
                        from: {
                            id: &quot;reviwGrid_filter_created_at1fbDDUB5ay1FL3HVcsuVCFk4qoA31yXX_from&quot;
                        },
                        to: {
                            id: &quot;reviwGrid_filter_created_at1fbDDUB5ay1FL3HVcsuVCFk4qoA31yXX_to&quot;
                        }
                    })
            });
                                    
                                                    
                                ApprovedPendingNot Approved                            
                                                    
                                                            
                                                    
                                                            
                                                    
                                                            
                                                    
                                AdministratorCustomerGuest                            
                                                    
                                                            
                                                    
                                                            
                                                    
                                                             
                                            
                                
                        
            
                                                                            
                                                                                            
                                6                                                            
                                Jul 26, 2019, 11:55:01 AM                                                            
                                Pending                                                            
                                Just Giving a Review                                                            
                                Anonymous&quot;                                                            
                                Description                                                            
                                Customer                                                            
                                HP Pavilion Notebook 15-ab027TX Silver                                                            
                                HPPavilionNotebook15-ab027TXCorei3-5010USilver                                                            
                                Edit                                                    
                    
                                                                                    
                                                                                            
                                5                                                            
                                Jul 24, 2019, 3:57:15 PM                                                            
                                Not Approved                                                            
                                Title of the Review                                                             
                                Anonymous&quot;                                                            
                                Description needs to be updated..!!!!                                                            
                                Customer                                                            
                                LG G5 32 GB Gold (4 GB RAM)                                                            
                                LGLGG532GBGold                                                            
                                Edit                                                    
                    
                                                                                    
                                                                                            
                                4                                                            
                                Jul 24, 2019, 12:34:27 PM                                                            
                                Not Approved                                                            
                                Increase the Count of Reviews                                                            
                                Anonymous&quot;                                                            
                                This is just a Review to increase the Count of ...                                                            
                                Customer                                                            
                                LG G5 32 GB Gold (4 GB RAM)                                                            
                                LGLGG532GBGold                                                            
                                Edit                                                    
                    
                                                                                    
                                                                                            
                                3                                                            
                                Jul 24, 2019, 12:17:19 PM                                                            
                                Approved                                                            
                                Just Giving a Review                                                            
                                Anonymous&quot;                                                            
                                DEscription                                                            
                                Customer                                                            
                                LG 235 L Direct Cool Single Door Refrigerator (GL-245BAG5, Coral Ornate)                                                            
                                LG235LDirectCoolSingleDoorRefrigeratorGL245BAG5CoralOrnate                                                            
                                Edit                                                    
                    
                                                                                    
                                                                                            
                                2                                                            
                                Jul 24, 2019, 11:50:45 AM                                                            
                                Not Approved                                                            
                                Just Giving a Review                                                            
                                Anonymous&quot;                                                            
                                Description                                                            
                                Customer                                                            
                                LG G5 32 GB Gold (4 GB RAM)                                                            
                                LGLGG532GBGold                                                            
                                Edit                                                    
                    
                                                                                    
                                                                                            
                                1                                                            
                                Jul 24, 2019, 11:50:07 AM                                                            
                                Approved                                                            
                                Just Giving a Review                                                            
                                Anonymous&quot;                                                            
                                LG is a good brand in terms of  Electronics..!!!!                                                            
                                Customer                                                            
                                LG GC-B207GLQV Side-by-Side Refrigerator (581 L, Platinum Silver)                                                            
                                LGGCB207GLQVSidebySideRefrigerator581LPlatinumSilver                                                            
                                Edit                                                    
                    
                                                            
        

    
    

    var deps = [];

    
    
    deps.push('mage/adminhtml/grid');

    
    require(deps, function(){
        
        //&lt;![CDATA[
    
    reviwGridJsObject = new varienGrid(&quot;reviwGrid&quot;, 'http://anjali.bajaj.com/admin/review/product/index/key/0d0f9ccf93f19eb55d5770673712ef28c73eaa2ed7c709c118e0e4b48b7f2f4f/', 'page', 'sort', 'dir', 'filter');
    reviwGridJsObject.useAjax = '';
        reviwGridJsObject.rowClickCallback = openGridRow;
                     reviwGrid_massactionJsObject = new varienGridMassaction('reviwGrid_massaction', reviwGridJsObject, '', 'internal_reviews', 'reviews');reviwGrid_massactionJsObject.setItems({&quot;delete&quot;:{&quot;label&quot;:&quot;Delete&quot;,&quot;url&quot;:&quot;http:\/\/anjali.bajaj.com\/admin\/review\/product\/massDelete\/ret\/index\/key\/70d5859be78e0c0c0fb0bed5e57f6241c808486ae0a04b2bca2ae75521fe8967\/&quot;,&quot;confirm&quot;:&quot;Are you sure?&quot;,&quot;id&quot;:&quot;delete&quot;},&quot;update_status&quot;:{&quot;label&quot;:&quot;Update Status&quot;,&quot;url&quot;:&quot;http:\/\/anjali.bajaj.com\/admin\/review\/product\/massUpdateStatus\/ret\/index\/key\/29f03ba8a56b4a71095c1865e338028ff99635965251a50e71ed875b96d21d54\/&quot;,&quot;id&quot;:&quot;update_status&quot;}}); reviwGrid_massactionJsObject.setGridIds('6,5,4,3,2,1');reviwGrid_massactionJsObject.setUseSelectAll(true);reviwGrid_massactionJsObject.errorText = 'An item needs to be selected. Select and try again.';
window.reviwGrid_massactionJsObject = reviwGrid_massactionJsObject;        
        //]]>

});

</value>
   </webElementProperties>
   <webElementProperties>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath</name>
      <type>Main</type>
      <value>id(&quot;anchor-content&quot;)</value>
   </webElementProperties>
   <webElementXpaths>
      <isSelected>true</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath:attributes</name>
      <type>Main</type>
      <value>//main[@id='anchor-content']</value>
   </webElementXpaths>
   <webElementXpaths>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath:idRelative</name>
      <type>Main</type>
      <value>//body[@id='html-body']/div[2]/main</value>
   </webElementXpaths>
   <webElementXpaths>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath:neighbor</name>
      <type>Main</type>
      <value>(.//*[normalize-space(text()) and normalize-space(.)='Jun 4, 2019, 1:24:35 AM'])[1]/following::main[1]</value>
   </webElementXpaths>
   <webElementXpaths>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath:position</name>
      <type>Main</type>
      <value>//main</value>
   </webElementXpaths>
</WebElementEntity>
