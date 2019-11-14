<?php
namespace Mirasvit\SearchElastic\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Mirasvit\SearchElastic\Model\Engine;

abstract class Command extends Action
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var Context
     */
    protected $context;

    public function __construct(
        Context $context,
        Engine $engine
    ) {
        $this->engine = $engine;
        $this->context = $context;

        parent::__construct($context);
    }
}
