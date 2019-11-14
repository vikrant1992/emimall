<?php
/**
 * BFL AttributeClustering
 *
 * @category   Cybage AttributeClustering Module
 * @package    BFL AttributeClustering
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */
namespace Cybage\AttributeClustering\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Psr\Log\LoggerInterface;

class AddProductAttributes implements DataPatchInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /** @var arrNewProductAttrs */
    private $arrNewProductAttrs;

    /** @var arrMappedAttrCodes */
    private $arrMappedAttrCodes;

    /** @var attributeSetFactory */
    private $attributeSetFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\View\DesignInterface $designInterface,
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;

        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->designInterface = $designInterface;
        $this->arrMappedAttrCodes = array(
            'viewing_angle'=>'view_angle',
            'indoor_weight_kg'=>'indoor_weight',
            'outdoor_weight_kg'=>'outdoor_weight',
            'dedicated_graphics_memory_capacity' => 'dedicated_graphics_memory',
            'washing_capacity_kg'=>'washing_capacity',
            '3d'=>'desk_3d',
            'function_type'=>'function_type_wm'
        );

        $this->arrNewProductAttrs = array(
            "Coolers"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Cooling Media"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Speeds"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Blower/Fan"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water Tank Capacity"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Cooling and Heating"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Remote Support"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Performance"=>array(
                    "Speed Control"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Operating Mode"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Air Delivery"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Air Throw Distance"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Motor Speed"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Air Deflection"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Body & Design"=>array(
                    "Body Material"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Blower/Fan Material"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Ice Chamber"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Castor Wheels"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Castor Wheels"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Fan Blades"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Louver Movement"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Oscillating Function"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "Empty Tank Alarm"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water Level Indicator"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dust Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Overflow Indicator"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Convenience Features"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Power Features"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Width x Height x Depth"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Blower/Fan Diameter"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty Summary"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Grinder"=>array(
                "General"=>array(
                    "Sales Package"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Switch Off"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Material"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Juicer Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dry Grinding"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Chutney Grinding"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Capacity"=>array(
                    "Grinding Jar Capacity"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Liquidizing Jar Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Chutney Jar Capacity"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Power requirements"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                )
            ),
            "UPS"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Form Factor"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Overload Protection"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Certification"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Technology Used"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Cold Start"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Input Features"=>array(
                    "Input Voltage"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Input Frequency"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Phase"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Input Plug Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Input Features"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Output"=>array(
                    "Output Voltage"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Output Frequency"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Output Power Wattage"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Efficiency"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Output Waveform"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Transfer Time"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Outlet Plug Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Outlet Plugs"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Surge Protection"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Output Power Factor"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "Digital Display"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Display Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Display Indicator Functions"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Audible Indicator Functions"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Emergency Power Off"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Serial Port"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Low Battery Indicator"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimensions"=>array(
                    "Width"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Height"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Depth"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Cord Length"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Battery"=>array(
                    "Battery Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Hot-swappable Battery"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Recharge Time"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Number of Batteries"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Battery Voltage"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Battery Capacity"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Replacement Battery Type"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Stabiliser"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Used For"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Generator Compatibility"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Model ID"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Mount"=>array(
                    "Mount Type"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Overload Protection"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Minimum Input Power (V)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Maximum Output Power(V)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Maximum Input Power (V)"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Dimensions"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "INVERTOR"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Battery Included"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Back Up Time"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Load Options"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Material"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Technology Used"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Solar Power Compatible"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Output"=>array(
                    "Efficiency"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Output Voltage"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Output Frequency"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Input"=>array(
                    "Input Voltage"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Input Frequency"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Battery"=>array(
                    "Battery Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Batteries"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Width"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Height"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Depth"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Service"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y")
                )
            ),
            "Printer"=>array(
                "General"=>array(
                    "Printing Method"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Display"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Part Number"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Printing Output"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Interface"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Printer Languages"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Functions"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Refill Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Ideal Usage"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Print"=>array(
                    "Max Print Resolution (Colour)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Max Print Resolution (Mono)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Duty cycle (monthly, A4)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "First Print Out Time (Color)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "First Print Out Time (Mono)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Cost per Page (Color) - As per ISO Standards"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Cost per Page (Black)- As per ISO Standards"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Duplex Print"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Print Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Additional Features"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Paper Handling"=>array(
                    "Media Types Supported"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Document Feeder"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Output Tray Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Input Tray Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Borderless Printing"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Media Size Supported"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Scan"=>array(
                    "Scan Area Size"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Optical Scanning Resolution"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Scan Type"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Copy"=>array(
                    "Copy Resolution Colour"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Copier Resize"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Copy Resolution Mono"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Height"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Width"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Depth"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Compatibility"=>array(
                    "Compatible Colour Cartridge"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Compatible Black Cartridge"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Connectivity"=>array(
                    "USB Support"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Wireless Support"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "JUICER"=>array(
                "General"=>array(
                    "Power Required"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Locking System"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Material"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Juicer Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Non-slip Feet"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Juice Extractor Jar Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimensions"=>array(
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Features"=>array(
                    "Other Features"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Sales Package"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y")
                )
            ),
            "WATER HEATER"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Capacity"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Mount Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Star Rating"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Suitable For"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Performance"=>array(
                    "Rated Pressure"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Temperature Range"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Adjustable Thermostat"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Earth Leakage Circuit Breaker"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Thermal Cutoff"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Heating Element"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Multi Function Valve"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Performance Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water Flow Rate"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Body"=>array(
                    "Body Material"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Tank Material"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Features"=>array(
                    "Indicators"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Timer"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Automatic Shut Off"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Adjustable Temperature Knob"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Fusible Valve"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Rust Resistant"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Fire Retardant Cable"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Heating Time"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Other Power Features"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimensions"=>array(
                    "Width"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Height"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Depth"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Refrigerators"=>array(
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "In The Box"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Features"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Built-in Stabilizer"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Removable Gasket"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water & Ice Dispenser"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Ice Tray Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Performance Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Coolpad"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Door Lock"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Family Size"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Stabilizer"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Tooltip"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Egg Tray"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water Dispenser"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Defrosting Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Defrosting Type New"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Body & Design"=>array(
                    "Number of Refrigerator Shelves"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Handle Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Shelf Material"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Refrigerator Drawers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Refrigerator Interior Light"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Door Finish"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Toughened Glass"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Door Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Number of Doors"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Gasket Type"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Performance"=>array(
                    "RPM"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Compressor Type"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Dimensions"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "General"=>array(
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Capacity"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Refrigerator Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Energy"=>array(
                    "Energy Rating"=>array("Filterable"=>"y","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "External Link"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Smartphones"=>array(
                "Battery"=>array(
                    "Battery"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "General"=>array(
                    "SIM Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "SIM Size"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Camera"=>array(
                    "Primary Camera"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Secondary Camera"=>array("Filterable"=>"n","Comparable"=>"y"),
                ),
                "Memory"=>array(
                    "RAM"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Expandable Storage"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Internal Storage"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Display"=>array(
                    "Screen Size"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Display Resolution"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Processor & OS"=>array(
                    "Processor Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Processor Speed"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Operating System"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Connectivity"=>array(
                    "Connectivity"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "In The Box"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Others"=>array(
                    "Other Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Tablets"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Make"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "In The Box"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Display"=>array(
                    "Screen Size"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Display Resolution"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "OS"=>array(
                    "Operating System"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Product Dimensions"=>array("Filterable"=>"n","Comparable"=>"y"),
                ),
                "Camera"=>array(
                    "Primary Camera"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Secondary Camera"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Memory & Storage"=>array(
                    "Internal Storage"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "RAM"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Connectivity"=>array(
                    "Connectivity"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Battery"=>array(
                    "Battery"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Processor"=>array(
                    "Processor"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Processor Speed"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Online Partners" => array (
                    "Flipkart Url" => array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url" => array("Filterable"=>"n","Comparable"=>"n"),
                    "External Link" => array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "TV"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Make"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Display"=>array(
                    "Resolution"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "HD Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Screen Size"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Brightness"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Contrast Ratio"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Viewing Angle"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Aspect Ratio"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Refresh Rate"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Display Technology"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Screen Type"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "Smart Tv"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Additional Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Graphics Processor"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Ports"=>array(
                    "HDMI Port"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "USB Port"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Connectivity"=>array(
                    "Built in Wi-fi"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Ethernet"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Connectivity Options"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Sound"=>array(
                    "No. of Speakers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Speaker Output"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Power Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Source"=>array("Filterable"=>"n","Comparable"=>"y"),
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Covered in Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Not Covered in warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Installation & Demo"=>array("Filterable"=>"n","Comparable"=>"n")
                   ),
                "Dimensions"=>array(
                    "Product Dimensions"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Memory"=>array(
                    "RAM"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Battery"=>array(
                    "Battery"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "OS"=>array(
                    "Operating System"=>array("Filterable"=>"y","Comparable"=>"n"),
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Package Includes"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Supported Image Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "External Link" => array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "AC"=>array(
                "General"=>array(
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "AC Type"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Room Size"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "In The Box"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Refrigerant"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Capacity"=>array(
                    "Capacity in Tons"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Energy Rating"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "BEE Rating"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "BEE Rating Year"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Product Dimensions"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Indoor Weight (kg)"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Outdoor Weight (kg)"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Noise"=>array(
                    "Indoor Noise Level"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "Cooling and Heating"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Operating Modes"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Technology Used"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dust Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dehumidification"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Panel Display"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Indoor Temperature Indicator"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Cooling Coverage Area"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Turbo Mode"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Evaporator Fin Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Condenser Fin Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Stepped Louvers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Air Swing"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Anti Bacteria Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Active Carbon Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Deodorizing Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Restart"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Timer"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Sleep Mode"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Memory Feature"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Self Diagnosis"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Emergency Operational Button"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Operating Current"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Battery Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Inverter"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Condenser Coil"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Deodorising Filter"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Remote Control"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Services"=>array(
                    "Covered in Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Not Covered in warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Warranty Service Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Installation"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y")
                )
            ),
            "Laptops"=>array(
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                        "Covered in Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                        "Not Covered in Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                    ),
                "Connectivity"=>array(
                    "Bluetooth"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Ethernet"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Connectivity"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Features"=>array(
                    "Additional Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Keyboard"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Web Camera"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Optical Disk Drive"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Laptop Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Microphone"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Other Features"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimensions"=>array(
                    "Weight"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Dimensions"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Ports"=>array(
                    "HDMI Port"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "USB Port"=>array("Filterable"=>"n","Comparable"=>"n"),
                ),
                "Display"=>array(
                    "Screen Size"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Screen Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Display Resolution"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Sound"=>array(
                    "Audio"=>array("Filterable"=>"n","Comparable"=>"n"),
                ),
                "Memory"=>array(
                    "RAM"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Hard Disk Capacity"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Graphics Memory Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dedicated Graphics Memory Capacity"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Processor"=>array(
                    "Processor Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Processor Name"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Processor Count"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Processor Speed"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "OS"=>array(
                    "Operating System"=>array("Filterable"=>"y","Comparable"=>"n"),
                ),
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Disk"=>array(
                    "Optical Disc Drive"=>array("Filterable"=>"n","Comparable"=>"n"),
                ),
                "Performance"=>array(
                    "Battery"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "RPM"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Power Supply"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Online Partners" => array (
                    "Flipkart Url" => array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url" => array("Filterable"=>"n","Comparable"=>"n"),
                    "External Link" => array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "External Link" => array("Filterable"=>"n","Comparable"=>"n"),
                    "New" => array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Desktop"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Colour"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Series"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Memory"=>array(
                    "Cache Memory"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "System Memory"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Memory Detail"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Hard Drive"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Processor"=>array(
                    "Processor Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Processor Brand"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Processor Frequency"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Processor Model"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Graphic Processor"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Cores"=>array(
                    "Number of Cores"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "OS"=>array(
                    "Operating System"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Display"=>array(
                    "Display Size"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "HD"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "3D"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Display Resolution"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Display Type"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "Built-in Webcam"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Built-in Microphone"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Memory Card Reader"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Ports"=>array(
                    "USB"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Headphone Jack"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Memory Slots"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "HDMI"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Connectivity"=>array(
                    "Bluetooth Version"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Wireless"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Ethernet"=>array("Filterable"=>"n","Comparable"=>"y")
                   ),
                "Dimensions"=>array(
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Washing Machines"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "In The Box"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Water Consumption"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Capacity"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Washing"=>array(
                    "Washing Capacity (kg)"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Operation Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Function type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Maximum Spin Speed"=>array("Filterable"=>"y","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dimensions"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "In-built Heater"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Preset Timer"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water Level Selector"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Technology Used"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Water Level Settings"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Wash Modes"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Digital Display"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Display Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Memory Backup"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Family Size"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Other Convenience Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Noise Level Wash"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Noise Level Spin"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Power Off"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Body Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dryer Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Features"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Rating"=>array(
                    "Wash Motor Rating"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Spin Motor Rating"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Safety"=>array(
                    "Child Lock"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Installation"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Oven"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Capacity"=>array(
                    "Capacity"=>array("Filterable"=>"y","Comparable"=>"n")
                ),
                "Control"=>array(
                    "Control Type"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Frequency"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Feature"=>array(
                    "Display Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Preheat"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Timer"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Defrost"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Steam Cook"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Reheat"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Cavity Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other Performance Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Temperature Range"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Safety"=>array(
                    "Alarm"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Power Output"=>array("Filterable"=>"y","Comparable"=>"n"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Power Levels"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimensions"=>array(
                    "Dimensions (WxDxH)"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Material"=>array(
                    "Cavity Material"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Body & Design"=>array(
                    "Door Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Door Opening Mechanism"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Dishwasher"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Water Consumption"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Capacity"=>array(
                    "Capacity"=>array("Filterable"=>"y","Comparable"=>"n")
                ),
                "Feature"=>array(
                    "Noise Level"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Control Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Wash Programs"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Wash Program Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Temperature Control Knob"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Display Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Other  Features"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Power Off"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Clock Present"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Safety"=>array(
                    "Door Lock"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Child Lock"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Material"=>array(
                    "Body Material"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Basket Material"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Shelf Material"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimensions"=>array(
                    "Dimensions (WxHxD)"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Technology"=>array(
                    "Technology Used"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Body & Design"=>array(
                    "Number Of Racks"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Removable Rack"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Service"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Water Purifiers"=>array(
                "General"=>array(
                    "Capacity"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Purification"=>array(
                    "Purifying Technology"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Purification Stages"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Purification Production Rate"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Feature"=>array(
                    "Operating Voltage"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Filtration Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Installation Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Detachable Storage Tank"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Shut Off"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Auto Start"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Overflow Protection"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Indicators"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dispenser"=>array(
                    "Cold Water Dispenser"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Hot Water Dispenser"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimension"=>array(
                    "Dimensions (WxDxHW)"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Safety"=>array(
                    "Child Lock"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Material"=>array(
                    "Storage Tank Material"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Filter"=>array(
                    "Filter Type"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Filter Life"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Home Theaters"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Supported Devices"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Channel"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Dimensions (WxDxHW)"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Ports"=>array(
                    "Number of USB Ports"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of HDMI Ports"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Sound"=>array(
                    "Total Number of Speakers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Amplifier Output"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Front Speakers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Center Speakers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Surround Speakers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Subwoofers"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Dolby Digital"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Feature"=>array(
                    "Signal To Noise Ratio"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Minimum Frequency Response"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Maximum Frequency Response"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y")
                )
            ),
            "Flour Mill"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Body material"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Type"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Performance"=>array(
                    "Grinding Capacity"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Motor Power"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Motor Speed"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Dimensions"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            ),
            "Chest Freezer"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Capacity"=>array(
                    "Capacity"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Body"=>array(
                    "Lid Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Door Type"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Number of Compartments"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Features"=>array(
                    "Lock Present"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Inbuilt Lighting"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Defrost Water Drain Present"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Defrost Type"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Power"=>array(
                    "Power Requirement"=>array("Filterable"=>"n","Comparable"=>"y"),
                    "Power Consumption"=>array("Filterable"=>"n","Comparable"=>"y")
                ),
                "Dimensions"=>array(
                    "Dimensions (WxDxH)"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Services"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y")
                )
            ),
            "Generator"=>array(
                "General"=>array(
                    "Brand"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Name"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Color"=>array("Filterable"=>"y","Comparable"=>"y"),
                    "Model Code"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Model Number"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Service"=>array(
                    "Warranty"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Capacity"=>array(
                    "Fuel Tank Capacity"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Power"=>array(
                    "Power output(V)"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Feature"=>array(
                    "Noise Level"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Safety Switch"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Touch start"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Dimension"=>array(
                    "Weight"=>array("Filterable"=>"n","Comparable"=>"n")
                ),
                "Others"=>array(
                    "Flipkart Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Price"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Flipkart Url"=>array("Filterable"=>"n","Comparable"=>"n"),
                    "Amazon Url"=>array("Filterable"=>"n","Comparable"=>"n")
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        /* Update sku validation*/
        $eavSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, 'sku', 'frontend_class', 'validate-length maximum-length-255');

        /* Get product entity type id */
        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);

        $attributeSetSortOrder = 1;
        foreach ($this->arrNewProductAttrs as $attributeSet => $arrAttributeGroup) {
            /* Get attribute set id by attribute set name */
            $attributeSetId = (int)$eavSetup->getAttributeSet($entityTypeId, $attributeSet, 'attribute_set_id');

            if ($attributeSetId == 0) {
                /* Create new attribute set */
                $attributeSetObj = $this->attributeSetFactory->create();
                $defaultAttributeSetId = (int)$eavSetup->getDefaultAttributeSetId($entityTypeId);
                $data = [
                    'attribute_set_name' => $attributeSet, //attribute set name
                    'entity_type_id' => $entityTypeId,
                    'sort_order' => $attributeSetSortOrder,
                ];
                $attributeSetObj->setData($data);
                $attributeSetObj->validate();
                $attributeSetObj->save();
                $attributeSetObj->initFromSkeleton($defaultAttributeSetId)->save(); // based on default attribute set

                $this->logger->info('New Attribute Set Created');
                $attributeSetId = (int)$eavSetup->getAttributeSet($entityTypeId, $attributeSet, 'attribute_set_id');
            }
            $this->logger->info('Attribute Set Id = '.$attributeSetId);

            $attributeGroupSortOrder = 65;
            foreach ($arrAttributeGroup as $attributeGroup => $arrAttributes) {
                /* Get attribute group id by attribute group name */
                $attributeGroupId = 0;

                $attributeGroupCode = $this->convertToAttributeGroupCode($attributeGroup);
                $groupData = $eavSetup->getAttributeGroupByCode($entityTypeId, $attributeSetId, $attributeGroupCode);
                if (isset($groupData['attribute_group_id'])) {
                    $attributeGroupId = $groupData['attribute_group_id'];
                }
                
                if ($attributeGroupId == 0) {
                    /* Create new attribute group under set */
                    if ($attributeGroupCode == "general") {
                        $defaultAttributeGroupId = $eavSetup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

                        if ($defaultAttributeGroupId > 0) {
                            $eavSetup->updateAttributeGroup($entityTypeId, $attributeSetId, $defaultAttributeGroupId, 'default_id', 0);
                        }
                    }

                    $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $attributeGroup, $attributeGroupSortOrder);
                    $this->logger->info('New Attribute group Created');

                    $groupData = $eavSetup->getAttributeGroupByCode($entityTypeId, $attributeSetId, $attributeGroupCode);
                    if (isset($groupData['attribute_group_id'])) {
                        $attributeGroupId = $groupData['attribute_group_id'];
                    }
                    
                    if ($attributeGroupCode == "general") {
                        if ($attributeGroupId > 0) {
                            $eavSetup->updateAttributeGroup($entityTypeId, $attributeSetId, $attributeGroupId, 'default_id', 0);
                        }

                        if ($defaultAttributeGroupId > 0) {
                            $eavSetup->updateAttributeGroup($entityTypeId, $attributeSetId, $defaultAttributeGroupId, 'default_id', 1);
                        }
                    }
                }
                $this->logger->info('Attribute Group Id = '.$attributeGroupId);

                $attributeSortOrder = 1;
                foreach ($arrAttributes as $attributeName => $attributeFilters) {
                    $generatedAttributeCode = $this->convertToAttributeCode($attributeName);

                    $attributeCode = isset($this->arrMappedAttrCodes[$generatedAttributeCode]) ? $this->arrMappedAttrCodes[$generatedAttributeCode] : $generatedAttributeCode;

                    $attributeId = $eavSetup->getAttributeId($entityTypeId, $attributeCode);
                    $this->logger->info('Attribute Id = '.$attributeId);

                    /**
                    * Insert/Create a simple text attribute
                    */
                    if ($attributeId == 0) {
                        if ($attributeFilters["Filterable"] == "y") {
                            $attributeFilterable = true;
                            $attributeSearchable = true;
                            $attributeType = 'int';
                            $attributeInput = 'select';
                            $attributeSource = 'Magento\Eav\Model\Entity\Attribute\Source\Table';
                        } else {
                            $attributeFilterable = false;
                            $attributeSearchable = false;
                            $attributeType = 'text';
                            $attributeInput = 'text';
                            $attributeSource = '';
                        }

                        if ($attributeFilters["Comparable"] == "y") {
                            $attributeComparable = true;
                        } else {
                            $attributeComparable = false;
                        }

                        $eavSetup->addAttribute(
                            $entityTypeId,
                            $attributeCode,
                            [
                                'type' => $attributeType,
                                'backend' => '',
                                'frontend' => '',
                                'label' => $attributeName,
                                'input' => $attributeInput,
                                'class' => '',
                                'source' => $attributeSource,
                                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                                'visible' => true,
                                'required' => false,
                                'user_defined' => true,
                                'default' => '',
                                'searchable' => $attributeSearchable,
                                'filterable' => $attributeFilterable,
                                'comparable' => $attributeComparable,
                                'visible_on_front' => true,
                                'used_in_product_listing' => false,
                                'unique' => false,
                                'apply_to' => ''
                            ]
                        );

                        $this->logger->info('Attribute Created');
                        $attributeId = $eavSetup->getAttributeId($entityTypeId, $attributeCode);
                    }
                    $this->logger->info('Attribute Id = '.$attributeId);

                    /* Map attribute to attribute group */
                    if ($attributeId > 0 && $attributeGroupId > 0) {
                        $eavSetup->addAttributeToGroup(
                            $entityTypeId,
                            $attributeSetId,
                            $attributeGroupId,
                            $attributeCode,
                            $attributeSortOrder
                        );

                        $attributeSortOrder++;
                    }
                }

                $attributeGroupSortOrder++;
            }

            $attributeSetSortOrder++;
        }
        $this->addRating();
       // $this->designInterface->setDesignTheme('BFL', 'frontend');
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function addRating()
    {
        $data = [
            \Magento\Review\Model\Rating::ENTITY_PRODUCT_CODE => [
                ['rating_code' => 'Rating', 'position' => 0],
            ],
            \Magento\Review\Model\Rating::ENTITY_PRODUCT_REVIEW_CODE => [],
            \Magento\Review\Model\Rating::ENTITY_REVIEW_CODE => [],
        ];
        $this->moduleDataSetup->getConnection()->update(
            $this->moduleDataSetup->getTable('rating'),
            ['is_active' => 0]
        );
        foreach ($data as $entityCode => $ratings) {
            //Fill table rating/rating_entity
            $entityId = 1;
            foreach ($ratings as $bind) {
                //Fill table rating/rating
                $bind['entity_id'] = $entityId;
                $this->moduleDataSetup->getConnection()->insert(
                    $this->moduleDataSetup->getTable('rating'),
                    $bind
                );
                //Fill table rating/rating_option
                $ratingId = $this->moduleDataSetup->getConnection()->lastInsertId(
                    $this->moduleDataSetup->getTable('rating')
                );
                $optionData = [];
                for ($i = 1; $i <= 5; $i++) {
                    $optionData[] = ['rating_id' => $ratingId, 'code' => (string)$i, 'value' => $i, 'position' => $i];
                }
                $this->moduleDataSetup->getConnection()->insertMultiple(
                    $this->moduleDataSetup->getTable('rating_option'),
                    $optionData
                );
            }
        }
    }

    /**
     * @param string $groupName
     * @return string
     * @since 100.1.0
     */
    public function convertToAttributeGroupCode($groupName)
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($groupName)), '-');
    }

    /**
     * @param string $attributeName
     * @return string
     * @since 100.1.0
     */
    public function convertToAttributeCode($attributeName)
    {
        return trim(preg_replace('/[^a-z0-9]+/', '_', strtolower($attributeName)), '_');
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
