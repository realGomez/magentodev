<?php

namespace Hainan\StoreLocator\Controller\Adminhtml\Stores;

use Magento\Backend\App\Action;

class Delete extends \Bcn\StoreLocator\Controller\Adminhtml\Stores
{
    const ADMIN_RESOURCE = 'Bcn_StoreLocator::stores_delete';

    protected $model = 'Bcn\StoreLocator\Model\Stores';

    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $this->deleteById($entityId);
            $this->messageManager->addSuccess(__('The Store has been deleted.'));
            $resultRedirect->setPath('admin_storelocator/*/');
        } catch (\Exception $e) {
            $this->messageManager->addError(__('We can\'t delete this store right now.'));
            $resultRedirect->setUrl($this->_redirect->getRedirectUrl($this->getUrl('*')));
        }

        return $resultRedirect;
    }

    /**
     * Delete brand items
     *
     * @param int $id
     * @return int
     */
    protected function deleteById($id = NULL)
    {
        $result = NULL;

        if(!is_null($id)){
            $model = $this->_objectManager->get($this->model);
            $model->load($id);
            $result = $model->delete();
        }

        return $result;
    }

}
