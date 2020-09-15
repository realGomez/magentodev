<?php

namespace Hainan\StoreLocator\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

abstract class Stores extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Hainan_StoreLocator::stores';

    protected $resultPageFactory;

    protected $_coreRegistry;

    protected $resultForwardFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->resultForwardFactory = $resultForwardFactory;
    }
}
