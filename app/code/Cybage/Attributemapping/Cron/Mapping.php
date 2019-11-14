<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Cron;

class Mapping {

    protected $logger;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger, \Cybage\Attributemapping\Model\Import $attributes) {
        $this->logger = $logger;
        $this->attributes = $attributes;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute() {
        $this->attributes->mappingValues();
    }

}
