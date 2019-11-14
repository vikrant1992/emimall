define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';
    
    $.widget('mst.brandList', {
        _create: function () {
            var self = this;
            
            const ROW_SELECTOR = '.js-brand-row';
            const LETTER_SELECTOR = '.js-brand-letter';
            
            $(function () {
                var el = self.element;
                
                el.on('click', function (e) {
                    e.preventDefault();
                    
                    $(LETTER_SELECTOR).removeClass('_active');
                    $(e.currentTarget).addClass('_active');
                    
                    var letter = $(e.currentTarget).data('letter');
                    var rows = $(ROW_SELECTOR);
                    
                    rows.each(function () {
                        var rowLetter = $(this).data('letter');
                        
                        if (letter && rowLetter !== letter) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            })
        }
    });
    
    return $.mst.brandList;
});
