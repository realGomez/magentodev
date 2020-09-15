<?php

namespace Hainan\StoreLocator\Controller\Adminhtml\Stores;

class Index extends \Hainan\StoreLocator\Controller\Adminhtml\Stores
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bcn_StoreLocator::Stores');
        $resultPage->addBreadcrumb(__('Stores'), __('Stores'));
        $resultPage->addBreadcrumb(__('Manage Stores'), __('Manage Stores'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Stores'));

        return $resultPage;
    }
}
