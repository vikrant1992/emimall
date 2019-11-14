<?xml version="1.0" encoding="UTF-8"?>
<WebElementEntity>
   <description></description>
   <name>section_requireconfig</name>
   <tag></tag>
   <elementGuidId>92e23b9d-7035-4bb0-a5d2-ae220a3f0133</elementGuidId>
   <selectorCollection>
      <entry>
         <key>XPATH</key>
         <value>//body[@id='html-body']/section</value>
      </entry>
   </selectorCollection>
   <selectorMethod>XPATH</selectorMethod>
   <useRalativeImagePath>false</useRalativeImagePath>
   <webElementProperties>
      <isSelected>true</isSelected>
      <matchCondition>equals</matchCondition>
      <name>tag</name>
      <type>Main</type>
      <value>section</value>
   </webElementProperties>
   <webElementProperties>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>class</name>
      <type>Main</type>
      <value>page-wrapper</value>
   </webElementProperties>
   <webElementProperties>
      <isSelected>true</isSelected>
      <matchCondition>equals</matchCondition>
      <name>text</name>
      <type>Main</type>
      <value>

    require.config({
        map: {
            '*': {
                wysiwygAdapter: 'mage/adminhtml/wysiwyg/tiny_mce/tinymce4Adapter'
            }
        }
    });

    
        require.config({
            deps: [
                'jquery',
                'mage/translate',
                'jquery/jquery-storageapi'
            ],
            callback: function ($) {
                'use strict';

                var dependencies = [],
                    versionObj;

                $.initNamespaceStorage('mage-translation-storage');
                $.initNamespaceStorage('mage-translation-file-version');
                versionObj = $.localStorage.get('mage-translation-file-version');

                
                if (versionObj.version !== '233570405f1a3711b897a5e1a0263245720c154c') {
                    dependencies.push(
                        'text!js-translation.json'
                    );

                }

                require.config({
                    deps: dependencies,
                    callback: function (string) {
                        if (typeof string === 'string') {
                            $.mage.translate.add(JSON.parse(string));
                            $.localStorage.set('mage-translation-storage', string);
                            $.localStorage.set(
                                'mage-translation-file-version',
                                {
                                    version: '233570405f1a3711b897a5e1a0263245720c154c'
                                }
                            );
                        } else {
                            $.mage.translate.add($.localStorage.get('mage-translation-storage'));
                        }
                    }
                });
            }
        });
    





require([
    &quot;jquery&quot;,
    &quot;jquery/ui&quot;
], function($){

    $.extend(true, $, {
        calendarConfig: {
            dayNames: [&quot;Sunday&quot;,&quot;Monday&quot;,&quot;Tuesday&quot;,&quot;Wednesday&quot;,&quot;Thursday&quot;,&quot;Friday&quot;,&quot;Saturday&quot;],
            dayNamesMin: [&quot;Sun&quot;,&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;,&quot;Sat&quot;],
            monthNames: [&quot;January&quot;,&quot;February&quot;,&quot;March&quot;,&quot;April&quot;,&quot;May&quot;,&quot;June&quot;,&quot;July&quot;,&quot;August&quot;,&quot;September&quot;,&quot;October&quot;,&quot;November&quot;,&quot;December&quot;],
            monthNamesShort: [&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],
            infoTitle: &quot;About the calendar&quot;,
            firstDay: 0,
            closeText: &quot;Close&quot;,
            currentText: &quot;Go Today&quot;,
            prevText: &quot;Previous&quot;,
            nextText: &quot;Next&quot;,
            weekHeader: &quot;WK&quot;,
            timeText: &quot;Time&quot;,
            hourText: &quot;Hour&quot;,
            minuteText: &quot;Minute&quot;,
            dateFormat: $.datepicker.RFC_2822,
            showOn: &quot;button&quot;,
            showAnim: &quot;&quot;,
            changeMonth: true,
            changeYear: true,
            buttonImageOnly: null,
            buttonImage: null,
            showButtonPanel: true,
            showOtherMonths: true,
            showWeek: false,
            timeFormat: '',
            showTime: false,
            showHour: false,
            showMinute: false,
            serverTimezoneSeconds: 1564142950,
            serverTimezoneOffset: 19800,
            yearRange: '1919:2119'
        }
    });

enUS = {&quot;m&quot;:{&quot;wide&quot;:[&quot;January&quot;,&quot;February&quot;,&quot;March&quot;,&quot;April&quot;,&quot;May&quot;,&quot;June&quot;,&quot;July&quot;,&quot;August&quot;,&quot;September&quot;,&quot;October&quot;,&quot;November&quot;,&quot;December&quot;],&quot;abbr&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;]}}; // en_US locale reference

});

                        
            
        
    You have logged out.

    
        
            Welcome, please sign in
        
        
        
            
                Username
            
            
                
            
        
        
            
                Password
            
            
                
            
        
                
            
    
        Sign in
    


Forgot your password?

        
    


Copyright © 2019 Magento Commerce Inc. All rights reserved.</value>
   </webElementProperties>
   <webElementProperties>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath</name>
      <type>Main</type>
      <value>id(&quot;html-body&quot;)/section[@class=&quot;page-wrapper&quot;]</value>
   </webElementProperties>
   <webElementXpaths>
      <isSelected>true</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath:idRelative</name>
      <type>Main</type>
      <value>//body[@id='html-body']/section</value>
   </webElementXpaths>
   <webElementXpaths>
      <isSelected>false</isSelected>
      <matchCondition>equals</matchCondition>
      <name>xpath:position</name>
      <type>Main</type>
      <value>//section</value>
   </webElementXpaths>
</WebElementEntity>
