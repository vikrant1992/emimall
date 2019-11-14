<?php
/**
 * BFL Cybage_SeoSchema
 *
 * @category   Cybage_SeoSchema Block
 * @package    BFL Cybage_SeoSchema
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\SeoSchema\Block;

class OrganizationSchema extends \Magento\Framework\View\Element\Template
{
    /**
     * ENABLE_ORG_SCHEMA
     */
    const ENABLE_ORG_SCHEMA = 'seo_config/info/enable_org_schema';

    /**
     * INFO_BUSINESS_NAME
     */
    const INFO_BUSINESS_NAME = 'seo_config/info/business_name';

    /**
     * INFO_BUSINESS_LEGAL_NAME
     */
    const INFO_BUSINESS_LEGAL_NAME = 'seo_config/info/business_legal_name';

    /**
     * INFO_BUSINESS_URL
     */
    const INFO_BUSINESS_URL = 'seo_config/info/business_url';

    /**
     * INFO_BUSINESS_LOGO
     */
    const INFO_BUSINESS_LOGO = 'seo_config/info/business_logo';

    /**
     * INFO_BUSINESS_FOUND_DATE
     */
    const INFO_BUSINESS_FOUND_DATE = 'seo_config/info/business_found_date';

    /**
     * INFO_FOUNDER_NAME
     */
    const INFO_FOUNDER_NAME = 'seo_config/info/founder_name';

    /**
     * INFO_STREET_ADDRESS
     */
    const INFO_STREET_ADDRESS = 'seo_config/info/street_address';

    /**
     * INFO_ADDRESS_LOCALITY
     */
    const INFO_ADDRESS_LOCALITY = 'seo_config/info/address_locality';

    /**
     * INFO_ADDRESS_REGION
     */
    const INFO_ADDRESS_REGION = 'seo_config/info/address_region';

    /**
     * INFO_POSTAL_CODE
     */
    const INFO_POSTAL_CODE = 'seo_config/info/postal_code';

    /**
     * INFO_ADDRESS_COUNTRY
     */
    const INFO_ADDRESS_COUNTRY = 'seo_config/info/address_country';

    /**
     * INFO_CUSTOMER_SUPPORT_PHONE
     */
    const INFO_CUSTOMER_SUPPORT_PHONE = 'seo_config/info/customer_support_phone';

    /**
     * INFO_CUSTOMER_SUPPORT_EMAIL
     */
    const INFO_CUSTOMER_SUPPORT_EMAIL = 'seo_config/info/customer_support_email';

    /**
     * INFO_INSTAGRAM
     */
    const INFO_INSTAGRAM = 'seo_config/info/instagram';

    /**
     * INFO_FACEBOOK
     */
    const INFO_FACEBOOK = 'seo_config/info/facebook';

    /**
     * INFO_TWITTER
     */
    const INFO_TWITTER = 'seo_config/info/twitter';

    /**
     * SD_SCHEMA_URL
     */
    const SD_SCHEMA_URL = "http://schema.org/";

    /**
     * SD_ORGANIZATION
     */
    const SD_ORGANIZATION = "Organization";

    /**
     * SD_PERSON
     */
    const SD_PERSON = "Person";

    /**
     * SD_POSTALADDRESS
     */
    const SD_POSTALADDRESS = "PostalAddress";

    /**
     * SD_CONTACTPOINT
     */
    const SD_CONTACTPOINT = "ContactPoint";

    /**
     * SD_CUSTOMER_SUPPORT
     */
    const SD_CUSTOMER_SUPPORT = "customer support";

    /**
     * @var \Cybage\SeoSchema\Helper
     */
    protected $_helper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Cybage\SeoSchema\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Cybage\SeoSchema\Helper\Data $helper
    ) {
        $this->registry = $registry;
        $this->_helper = $helper;
        parent::__construct($context);
    }

    /**
     * Is enabled?
     *
     * @return bool
     */
    public function isOrgSchemaEnabled()
    {
        return $this->_helper->getConfigValue(self::ENABLE_ORG_SCHEMA);
    }

    /**
     * Get business name
     *
     * @return string
     */
    public function getBusinessName()
    {
        return $this->_helper->getConfigValue(self::INFO_BUSINESS_NAME);
    }

    /**
     * Get business url
     *
     * @return string
     */
    public function getBusinessLegalName()
    {
        return $this->_helper->getConfigValue(self::INFO_BUSINESS_LEGAL_NAME);
    }

    /**
     * Get business URL
     *
     * @return string
     */
    public function getBusinessUrl()
    {
        return trim($this->_helper->getConfigValue(self::INFO_BUSINESS_URL));
    }

    /**
     * Get business logo
     *
     * @return string
     */
    public function getBusinessLogo()
    {
        return trim($this->_helper->getConfigValue(self::INFO_BUSINESS_LOGO));
    }

    /**
     * Get business founding date
     *
     * @return string
     */
    public function getBusinessFoundingDate()
    {
        return trim($this->_helper->getConfigValue(self::INFO_BUSINESS_FOUND_DATE));
    }

    /**
     * Get founder name
     *
     * @return string
     */
    public function getBusinessFounderName()
    {
        return trim($this->_helper->getConfigValue(self::INFO_FOUNDER_NAME));
    }

    /**
     * Get business street address
     *
     * @return string
     */
    public function getBusinessStreetAddress()
    {
        return trim($this->_helper->getConfigValue(self::INFO_STREET_ADDRESS));
    }

    /**
     * Get business address locality
     *
     * @return string
     */
    public function getBusinessAddressLocality()
    {
        return trim($this->_helper->getConfigValue(self::INFO_ADDRESS_LOCALITY));
    }

    /**
     * Get business address region
     *
     * @return string
     */
    public function getBusinessAddressRegion()
    {
        return trim($this->_helper->getConfigValue(self::INFO_ADDRESS_REGION));
    }

    /**
     * Get business postal code
     *
     * @return string
     */
    public function getBusinessPostalCode()
    {
        return trim($this->_helper->getConfigValue(self::INFO_POSTAL_CODE));
    }

    /**
     * Get business address country
     *
     * @return string
     */
    public function getBusinessAddressCountry()
    {
        return trim($this->_helper->getConfigValue(self::INFO_ADDRESS_COUNTRY));
    }

    /**
     * Get business customer support telephone
     *
     * @return string
     */
    public function getBusinessCustSupportPhone()
    {
        return trim($this->_helper->getConfigValue(self::INFO_CUSTOMER_SUPPORT_PHONE));
    }

    /**
     * Get business customer support email
     *
     * @return string
     */
    public function getBusinessCustSupportEmail()
    {
        return trim($this->_helper->getConfigValue(self::INFO_CUSTOMER_SUPPORT_EMAIL));
    }

    /**
     * Get business instagram URL
     *
     * @return string
     */
    public function getBusinessInstagramUrl()
    {
        return trim($this->_helper->getConfigValue(self::INFO_INSTAGRAM));
    }

    /**
     * Get business facebook URL
     *
     * @return string
     */
    public function getBusinessFacebokUrl()
    {
        return trim($this->_helper->getConfigValue(self::INFO_FACEBOOK));
    }

    /**
     * Get business twitter URL
     *
     * @return string
     */
    public function getBusinessTwitterUrl()
    {
        return trim($this->_helper->getConfigValue(self::INFO_TWITTER));
    }

    /**
     * get Business Structured Data
     *
     * @return string
     */
    public function showBusinessStructuredData()
    {
        $businessStructuredData = array(
            "@context" => self::SD_SCHEMA_URL,
            "@type"    => self::SD_ORGANIZATION
        );

        $businessName = $this->getBusinessName();
        if (!empty($businessName)) {
            $businessStructuredData["name"] = $businessName;
        }

        $businessLegalName = $this->getBusinessLegalName();
        if (!empty($businessLegalName)) {
            $businessStructuredData["legalName"] = $businessLegalName;
        }

        $businessUrl = $this->getBusinessUrl();
        if (!empty($businessUrl)) {
            $businessStructuredData["url"] = $businessUrl;
        }

        $businessLogo = $this->getBusinessLogo();
        if (!empty($businessLogo)) {
            $businessStructuredData["logo"] = $businessLogo;
        }

        $businessFoundingDate = $this->getBusinessFoundingDate();
        if (!empty($businessFoundingDate)) {
            $businessStructuredData['foundingDate'] = $businessFoundingDate;
        }

        $businessFounderName = $this->getBusinessFounderName();
        if (!empty($businessFounderName)) {
            $founders = array(
                            '@type' => self::SD_PERSON,
                            'name' => $businessFounderName
                        );
            $businessStructuredData['founders'] = $founders;
        }

        $businessStreetAddress = $this->getBusinessStreetAddress();
        $businessAddressLocality = $this->getBusinessAddressLocality();
        $businessAddressRegion = $this->getBusinessAddressRegion();
        $businessPostalCode = $this->getBusinessPostalCode();
        $businessAddressCountry = $this->getBusinessAddressCountry();
        if (!empty($businessStreetAddress) || !empty($businessAddressLocality)
             || !empty($businessAddressRegion) || !empty($businessPostalCode)
             || !empty($businessAddressCountry)) {
            $address = array(
                            "@type" => self::SD_POSTALADDRESS
                       );

            if (!empty($businessStreetAddress)) {
                $address["streetAddress"] = $businessStreetAddress;
            }

            if (!empty($businessAddressLocality)) {
                $address["addressLocality"] = $businessAddressLocality;
            }

            if (!empty($businessAddressRegion)) {
                $address["addressRegion"] = $businessAddressRegion;
            }

            if (!empty($businessPostalCode)) {
                $address["postalCode"] = $businessPostalCode;
            }

            if (!empty($businessAddressCountry)) {
                $address["addressCountry"] = $businessAddressCountry;
            }

            $businessStructuredData['address'] = $address;
        }

        $businessCustSupportPhone = $this->getBusinessCustSupportPhone();
        $businessCustSupportEmail = $this->getBusinessCustSupportEmail();
        if (!empty($businessCustSupportPhone) || !empty($businessCustSupportEmail)) {
            $contacts = array(
                            "@type" => self::SD_CONTACTPOINT,
                            "contactType" => self::SD_CUSTOMER_SUPPORT
                        );

            if (!empty($businessCustSupportPhone)) {
                $contacts["telephone"] = $businessCustSupportPhone;
            }

            if (!empty($businessCustSupportEmail)) {
                $contacts["email"] = $businessCustSupportEmail;
            }

            $businessStructuredData['contactPoint'] = $contacts;
        }

        $businessInstagramUrl = $this->getBusinessInstagramUrl();
        $businessFacebokUrl = $this->getBusinessFacebokUrl();
        $businessTwitterUrl = $this->getBusinessTwitterUrl();
        if (!empty($businessInstagramUrl) || !empty($businessFacebokUrl) || !empty($businessTwitterUrl)) {
            $sameAs = array();

            if (!empty($businessInstagramUrl)) {
                $sameAs[] = $businessInstagramUrl;
            }

            if (!empty($businessFacebokUrl)) {
                $sameAs[] = $businessFacebokUrl;
            }

            if (!empty($businessTwitterUrl)) {
                $sameAs[] = $businessTwitterUrl;
            }

            if (!empty($sameAs)) {
                $businessStructuredData['sameAs'] = $sameAs;
            }
        }

        return $this->_helper->createStructuredData($businessStructuredData);
    }
}
