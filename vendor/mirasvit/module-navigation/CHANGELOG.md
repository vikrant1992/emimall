# Change Log
## 1.0.77
*(2019-11-05)*

#### Improvements
* Ability to use multi-select for Decimal filters
* Ability to split selected filter option (filter clear block)

---


## 1.0.76
*(2019-10-28)*

#### Improved
* Code refactoring

#### Fixed
* Price filter multi select

---


## 1.0.75
*(2019-10-21)*

#### Features
* display different swatch for category and product page

#### Fixed
* ES compatibility

---


## 1.0.73
*(2019-08-22)*

#### Improvements
* Ability to use .svg for brand logos

---


## 1.0.72
*(2019-08-21)*

#### Improvements
* Ability to display nested categories in filter

---


## 1.0.71
*(2019-05-24)*

#### Fixed
* Issue with save attribute

---


## 1.0.70
*(2019-05-23)*

#### Fixed
* Upgrade issue (All parts of a PRIMARY KEY must be NOT NULL)

---


## 1.0.69
*(2019-05-22)*

#### Improvements
* Ability to display/hide particular filters by category

#### Fixed
* Issue with Customer Group ID in price filter

---


## 1.0.68
*(2019-04-15)*

#### Fixed
* JS error on edit brand page

---


## 1.0.67
*(2019-04-11)*

#### Improvements
* All Brands Page

---


## 1.0.66
*(2019-03-28)*

#### Improvements
* Performance issue loading css styles

---

### 1.0.65
*(2019-03-18)* 

* Refactoring


## 1.0.64
*(2019-03-14)*

#### Fixed
* Price slider filter is not properly displayed in IE11 [#89]()

---

## 1.0.63
*(2019-03-06)*

#### Fixed
* White layer appears during using toolbar and hides catalog

---

## 1.0.62
*(2019-03-04)*

#### Fixed
* Rating filter displayed multiple times across different filters
* Properly set additional filters position

---

## 1.0.61
*(2019-03-01)*

#### Fixed
* Error during saving product from admin panel

---

## 1.0.60
*(2019-02-28)*

#### Improvements
* Integrate Layered Navigation with Elastic Search Engine provided by Mirasvit Search

---

## 1.0.59
*(2019-02-22)*

#### Improvements
* Add translation file

---

## 1.0.58
*(2019-02-19)*

#### Fixed
* Error during performing compilation command

---

## 1.0.57
*(2019-02-14)*

#### Fixed
* Solve error during DI compilation

---

## 1.0.56
*(2019-02-13)*

#### Fixed
* Error 'The attribute model is not defined.'

---

## 1.0.55
*(2019-02-07)*

#### Features
* SEO for layered navigation: robots meta header and canonical URLs

#### Fixed
* Error in logs regarding non-numeric value in price filter
* Fix error in browser's console regarding absent css file

---

## 1.0.54
*(2019-01-11)*

#### Fixed
* Clear all filters button does not work in some cases

---

## 1.0.53
*(2019-01-10)*

#### Fixed
* Style issue with 'Shop By' button #50
* Error in browser's developer toolbar regarding absence of the stylesheet file #50

---

## 1.0.52
*(2019-01-09)*

#### Fixed
* Cannot upload logo image for brand page in M2.3

---


## 1.0.51
*(2019-01-09)*

#### Fixed
* Error 'Attribute does not exist' occurs when opening CMS pages without preliminary setting the brand attribute
* Compatibility with Magento 2.1.7 and lower

---

## 1.0.50
*(2018-12-20)*

#### Fixed
* Category page gives error when price calculation step set to 'Automatic (equalize product counts)' option

---

## 1.0.49
*(2018-12-05)*

#### Features
* Added Smart Sorting module

#### Fixed
* Errors during di compilation
* Brand pages show all brand products (since 1.0.48)

#### Documentation
* Layered Navigation troubleshoot
* Scroll and Sorting modules documentation

---

## 1.0.48
*(2018-11-29)*

#### Improvements
* M2.3 support
* Center brand labels in slider for IE

#### Fixed
* Brand page is not opened

---


## 1.0.47
*(2018-11-23)*

#### Fixed
* Error displaying brand slider

---

## 1.0.46
*(2018-11-19)*

#### Improvements
* Display horizontal filters with mobile themes
* **Center 'Add to Cart' button after catalog update**
    Trigger "amscroll" event after catalog update,
    JS script listens for this event to center the buttons

#### Fixed
* Swatch options' labels of type text are not visible (since 1.0.45)
* **Problem with auto-generated brand URLs**
    whitespaces are not replaced with hyphen sign

---

## 1.0.45
*(2018-11-09)*

#### Features
* Ability to set Brand URL suffix

#### Fixed
* Brand logo is not visible in product list
* **Filter options missing for swatch filters**<br>
    When swatch type is not set for the attribute the<br>
    filter options for that attribute are not visible
* **Checkbox-styled filters are not clickable**
    When option Display options set to Checkbox and Ajax<br>
    is not enabled the filter options do not react on user clicks<br>
    and as a result filtering is not performed.

#### Documentation
* update installation instruction

---

## 1.0.44
*(2018-11-02)*

#### Fixed
* **On Sale filter shows wrong products**<br>
    On Sale filter ignores Special Price From and To dates<br>
    and as a result shows products that are no longer on sale.

#### Feature
* Ajax Infinite Scroll

---

## 1.0.43
*(2018-10-24)*

#### Fixed
* Wrong SEO-friendly filter URL when category URL suffix is set to slash - /

---

## 1.0.42
*(2018-10-23)*

#### Fixed
* Product URLs are not SEO-friendly on brand page when 'Use Categories Path for Product URLs' is enabled

---

## 1.0.41
*(2018-10-11)*

#### Fixed
* Pagination does not work on search page, when search query composed from 2 words

#### Documentation
* Instruction for module disabling

---

## 1.0.40
*(2018-09-28)*

#### Fixed
* Multiple filter options marked as checked when option ID exists as the substring in another option
* JS Error: filters do not work

---

## 1.0.39
*(2018-09-19)*

#### Fixed
* Brand page returns 404 when trailing slash is used in the brand's page URL

---

## 1.0.38
*(2018-09-18)*

#### Fixed
* Issue with slider

---

## 1.0.36
*(2018-09-14)*

#### Fixed
* Swatch multiselector

---

## 1.0.35
*(2018-09-14)*

#### Fixed
* issues with js

---

## 1.0.33
*(2018-09-12)*

#### Fixed
* LOF after filtration

---

## 1.0.32
*(2018-09-11)*

#### Improvements
* Float filters

#### Fixed
* Lof Ajax

---

## 1.0.31
*(2018-09-06)*

#### Improvements
* Lof Ajax

---

## 1.0.30
*(2018-08-30)*

#### Improvements
* Show all categories in filter (for brand and all products page)

---

## 1.0.29
*(2018-08-28)*

#### Fixed
* Lof_AjaxScroll compatibility

---

## 1.0.28
*(2018-08-23)*

#### Fixed
* Fixed conflict with Aheadworks Product Questions

---

## 1.0.27
*(2018-08-17)*

#### Fixed
* Fixed "Notice: Undefined variable: filtersWithoutSuffix in .../LayeredNavigation/Service/SeoFilterUrlService.php on line 292"

---

## 1.0.26
*(2018-08-16)*

#### Fixed
* Fixed notice

---

## 1.0.25
*(2018-08-15)*

#### Fixed
* Fixed frontend style

---

## 1.0.24
*(2018-08-15)*

#### Feature
* Brand slider
* More from this brand block
* Brand logo and tooltip on product and category page

---

## 1.0.23
*(2018-07-20)*

#### Fixed
* bug: Compatibility with SEO

---

## 1.0.22
*(2018-07-19)*

#### Fixed
* Style fix

---

## 1.0.21
*(2018-07-19)*

#### Feature
* All products page

---

## 1.0.20
*(2018-07-16)*

#### Fixed
* Fix default title
* Compatibility with SEOFilter version 1.0.5

#### Feature
* Ability add banner to brand page

---

## 1.0.19
*(2018-07-04)*

#### Fixed
* Fixed incorrect items count in navigation for Elasticsearch (magento ee, Elasticsearch, for some stores)

---

## 1.0.18
*(2018-06-27)*

#### Fixed
* Ability use catalog.leftnav for horizontal navigation (need for some stores)

---

## 1.0.17
*(2018-06-22)*

#### Fixed
* Fixed brand images style

---

## 1.0.16
*(2018-06-21)*

#### Fixed
* Fixed an issue when only 10 items in navigation ( for Elasticsearch 1.7.x )

---

## 1.0.15
*(2018-06-14)*

#### Fixed
* Elasticsearch compatibility if multiselect enabled (magento ee)

---

## 1.0.14
*(2018-06-06)*

#### Fixed
* Fix brand composer

---

## 1.0.13
*(2018-06-06)*

#### Documentation
* docs: Documentation improvement

#### Feature
* Brands

---

## 1.0.12
*(2018-05-23)*

#### Fixed
* Fixed incorrect urls for additional filters in navigation
* Fixed an issue with "%2C" in url without ajax if slider enabled

---

## 1.0.11
*(2018-05-17)*

#### Fixed
* Multi filter issue + issue with price slider (if from is 0)

---

## 1.0.10
*(2018-05-08)*

#### Fixed
* Fixed error if search elastic work in mysql mode

---

## 1.0.9
*(2018-05-08)*

#### Fixed
* Fixed issue with "pub" folder in additional css path

---

## 1.0.8
*(2018-05-04)*

#### Fixed
* Compatibility with SearchElastic

---

## 1.0.7
*(2018-04-30)*

#### Fixed
* Fixed %2C symbol in pager url

---

## 1.0.6
*(2018-04-30)*

#### Improvements
* Redirect to correct url if js error

---

## 1.0.5
*(2018-04-30)*

#### Fixed
* Fixed filter disappearance when click on ajax paging

---

## 1.0.4
*(2018-04-18)*

#### Improvements
* Magento 2.1 compatibility

---

## 1.0.3
*(2018-04-18)*

#### Improvements
* Ability use scroll for navigation links

---

## 1.0.2
*(2018-04-12)*

#### Fixed
* Fixed style issue for Safari browser

---

## 1.0.1
*(2018-04-06)*

#### Documentation
* Added documentation

---

## 1.0.0
*(2018-04-03)*

* Initial release

---
