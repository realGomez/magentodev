<?php

namespace Hainan\StoreLocator\Controller\Adminhtml\Stores;

class Edit extends \Bcn\StoreLocator\Controller\Adminhtml\Stores
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Bcn_StoreLocator::stores')
            ->addBreadcrumb(__('Stores'), __('Stores'))
            ->addBreadcrumb(__('Manage Stores'), __('Manage Stores'));
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $storeViewId = $this->getRequest()->getParam('store', 0);

        $model = $this->_objectManager->create('Bcn\StoreLocator\Model\Stores');

        if ($id) {
            $model->setStoreId($storeViewId)->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This store no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('storelocator_stores_content', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Store') : __('New Store'),
            $id ? __('Edit Store') : __('New Store')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Store Locator'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getName() : __('New Store'));

        return $resultPage;
    }
}
