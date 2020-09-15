<?php

namespace Hinan\Sea\Controller\Adminhtml\Station;

class NewAction extends \Bcn\StoreLocator\Controller\Adminhtml\Location
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
