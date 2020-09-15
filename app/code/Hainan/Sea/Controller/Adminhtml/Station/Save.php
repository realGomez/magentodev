<?php

namespace Hainan\Sea\Controller\Adminhtml\Station;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    const ENTITY_ID = 'hainan_sea_main_id';

    const ADMIN_RESOURCE = 'Hainan_Sea::location_save';

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $storeId = $this->getRequest()->getParam('store', 0);

        if ($data) {
            /** @var \Bcn\StoreLocator\Model\Location $model */
            $model = $this->_objectManager->create('Hainan\Sea\Model\Station');

            $id = $this->getRequest()->getParam(static::ENTITY_ID);
            if ($id) {
                // Must set store id to load
                $model->setStoreId($storeId)->load($id);
            }

            // Include store id to save store view
            $model->setData($data)->setStoreId($storeId);

            //$model->setData('attribute_set_id',$this->getDefaultAttributeSetId());

            $this->_eventManager->dispatch(
                'storelocator_location_content_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('Save successfully.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                return $this->_getBackResultRedirect($resultRedirect, $model->getId());

            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the store location.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id'), 'store' => $storeId]);
        }

        return $resultRedirect->setPath('*/*/', ['store' => $storeId]);
    }


    /**
     * Get back result redirect after add/edit.
     *
     * @param \Magento\Framework\Controller\Result\Redirect $resultRedirect
     * @param null                                          $paramEntityId
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function _getBackResultRedirect(\Magento\Framework\Controller\Result\Redirect $resultRedirect, $paramEntityId = null)
    {
        switch ($this->getRequest()->getParam('back')) {
            case 'edit':
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        static::ENTITY_ID => $paramEntityId,
                        '_current' => true,
                        'store' => $this->getRequest()->getParam('store')
                    ]
                );
                break;
            case 'new':
                $resultRedirect->setPath('*/*/new', ['_current' => true]);
                break;
            default:
                $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
