<?php

namespace Hainan\StoreLocator\Controller\Adminhtml\Stores;

use Magento\Framework\View\Result\PageFactory;

class NewAction extends \Bcn\StoreLocator\Controller\Adminhtml\Stores
{
    protected $resultForwardFactory;

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
