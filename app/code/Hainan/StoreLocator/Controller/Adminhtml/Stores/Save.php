<?php

namespace Hainan\StoreLocator\Controller\Adminhtml\Stores;

use Magento\Backend\App\Action;

class Save extends \Bcn\StoreLocator\Controller\Adminhtml\Stores
{
    const ENTITY_ID = 'entity_id';

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Bcn_StoreLocator::stores_save';

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $storeId = $this->getRequest()->getParam('store', 0);

        if ($data) {
            /** @var \Bcn\StoreLocator\Model\Stores $model */
            $model = $this->_objectManager->create('Bcn\StoreLocator\Model\Stores');

            $id = $this->getRequest()->getParam(static::ENTITY_ID);
            if ($id) {
                // Must set store id to load
                $model->setStoreId($storeId)->load($id);
            }

            $model->setData($data)
                ->setStoreId($storeId) // Include store id to save store view
            ;

            //$model->setData('attribute_set_id',$this->getDefaultAttributeSetId());

            $this->_eventManager->dispatch(
                'storelocator_stores_content_prepare_save',
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
                $this->messageManager->addException($e, __('Something went wrong while saving the store location address.'));
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
