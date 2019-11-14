<?php
/**
 * BFL Cybage_ExpertReview
 *
 * @category   Cybage_ExpertReview Module
 * @package    BFL Cybage_ExpertReview
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\ExpertReview\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class ExpertReview extends Command
{
    const CAT_ID = 'c';
    
    const SKU = 'sku';
    
    const PAGE = 'page';
    
    /**
     * @var \Cybage\ExpertReview\Helper\Data
     */
    protected $_data;
    
    /** 
     * @var \Magento\Framework\App\State 
     */
    private $_state;
    
    /**
     * @param \Cybage\ExpertReview\Helper\Data $data
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(
        \Cybage\ExpertReview\Helper\Data $data,
        \Magento\Framework\App\State $state
    ){
        $this->_state = $state;
        $this->_data = $data;
        parent::__construct();
    }
    
    protected function configure()
    {
        $options = [
            new InputOption(
                self::CAT_ID,
                null,
                InputOption::VALUE_REQUIRED,
                'category ID'
            ),
            new InputOption(
                self::SKU,
                null,
                InputOption::VALUE_OPTIONAL,
                'product SKU'
            ),
            new InputOption(
                self::PAGE,
                null,
                InputOption::VALUE_OPTIONAL,
                'page number'
            )
        ];

        $this->setName('cybage:expert-review')
                ->setDescription('Import 91mobile review')
                ->setDefinition($options);
        
        parent::configure();
    }
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return \Cybage\ExpertReview\Console\ExpertReview
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        $catId = $input->getOption(self::CAT_ID);
        $sku = $input->getOption(self::SKU);
        $pageNo = $input->getOption(self::PAGE);
        $pageNo = ($pageNo != NULL) ? $pageNo : 0;
        $response = $this->_data->getExpertReview($catId, $sku, $pageNo);
        $output->writeln($response);
        return $this;
    }
}
