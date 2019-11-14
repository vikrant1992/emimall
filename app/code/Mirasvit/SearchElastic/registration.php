<?php
// @codingStandardsIgnoreStart
$configFile = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/app/etc/autocomplete.json';
if (!file_exists($configFile)) {
    $configFile = dirname(dirname(dirname(dirname(__DIR__)))) . '/app/etc/autocomplete.json';
}

if (isset($_SERVER) && is_array($_SERVER) && isset($_SERVER['REQUEST_URI'])
    && strpos($_SERVER['REQUEST_URI'], 'searchautocomplete/ajax/suggest') !== false
    && file_exists($configFile)) {
    require_once 'autocomplete.php';
}

$registration = dirname(dirname(dirname(__DIR__))) . '/vendor/mirasvit/module-search-elastic/src/SearchElastic/registration.php';
if (file_exists($registration)) {
    return;
}

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Mirasvit_SearchElastic',
    __DIR__
);
// @codingStandardsIgnoreEnd
