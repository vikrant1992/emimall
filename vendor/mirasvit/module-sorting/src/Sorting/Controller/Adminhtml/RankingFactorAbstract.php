<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-sorting
 * @version   1.0.25
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Sorting\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Api\Repository\RankingFactorRepositoryInterface;

abstract class RankingFactorAbstract extends Action
{
    protected $context;

    private   $registry;

    protected $rankingFactorRepository;

    private   $session;

    protected $resultForwardFactory;

    public function __construct(
        RankingFactorRepositoryInterface $rankingFactorRepository,
        Registry $registry,
        ForwardFactory $resultForwardFactory,
        Context $context
    ) {
        $this->rankingFactorRepository = $rankingFactorRepository;
        $this->registry                = $registry;
        $this->resultForwardFactory    = $resultForwardFactory;

        $this->context = $context;
        $this->session = $context->getSession();

        parent::__construct($context);
    }

    /**
     * Initialize page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Mirasvit_Sorting::sorting');

        $resultPage->getConfig()->getTitle()->prepend(__('Improved Sorting'));
        $resultPage->getConfig()->getTitle()->prepend(__('Ranking Factors'));

        return $resultPage;
    }

    /**
     * @return RankingFactorInterface|false
     */
    protected function initModel()
    {
        $model = $this->rankingFactorRepository->create();

        if ($this->getRequest()->getParam(RankingFactorInterface::ID)) {
            $model = $this->rankingFactorRepository->get($this->getRequest()->getParam(RankingFactorInterface::ID));
        }

        $this->registry->register(RankingFactorInterface::class, $model);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->context->getAuthorization()->isAllowed('Mirasvit_Sorting::sorting');
    }
}
