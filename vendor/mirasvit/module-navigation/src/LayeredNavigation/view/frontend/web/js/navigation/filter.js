define([
    'jquery',
    'Mirasvit_LayeredNavigation/js/action/apply-filter',
    'Mirasvit_LayeredNavigation/js/constants'
], function($, applyFilter) {
    'use strict';

    /**
     * Work with default filters.
     */
    $.widget('mst.mNavigationFilter', {
        _create: function () {
            if (this.options.isAjaxEnabled == 1) {
                this._bind();
            }
        },

        _bind: function () {
            this.element.on('click', function (e) {
                var href = this.element.prop('href');
                var checkbox = this.element.find('input[type=checkbox]', '#layered-filter-block a');
                var isChecked = checkbox.prop('checked'),
                    filterValue, filterName, filterData;

                if ((this.element.parent('li').next('ol').length && !this.element.hasClass('filterable')) ||
                    (this.element.parent('li').next('ol').length && this.element.hasClass('filterable'))) {

                    this.expandFilter(this.element);
                    return false;
                }

                if (window.mNavigationFilterCheckboxAjaxApplied === undefined) {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }

                if (window.mNavigationIsSimpleCheckboxChecked !== undefined) {
                    isChecked = window.mNavigationIsSimpleCheckboxChecked;
                }

                if (isChecked) {
                    filterValue = checkbox.prop('value');
                    filterName = checkbox.prop('name');
                    filterData = {filterValue: filterValue, filterName: filterName};

                    applyFilter(href, false, false, filterData);
                } else {
                    applyFilter(href);
                }

                e.stopPropagation();
                if (window.mNavigationFilterCheckboxAjaxApplied === undefined) {
                    e.preventDefault();
                }

                window.mNavigationFilterCheckboxAjaxApplied = undefined;
            }.bind(this));
        },

        expandFilter: function(el) {
            if ($(el).parent('li').next('ol').length) {
                $(el).parent('li').find('span').toggleClass('arrowDown');
                $(el).parent('li').find('span').toggleClass('arrowLeft');
                $(el).parent('li').next('ol.m-navigation-filter-item-nested').toggle();

                if ($(el).hasClass('filterable')) {
                    $(el).next('.m-navigation-filter-item-ensure').toggle('slow');
                    $(el).next('.m-navigation-filter-item-ensure').toggleClass('ensure_show', 800);
                }
                return false;
            }
        }
    });

    return $.mst.mNavigationFilter;
});
