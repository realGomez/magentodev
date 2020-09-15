<?php

namespace Hainan\StoreLocator\Controller\Adminhtml\Stores;

use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class MassDelete extends \Bcn\StoreLocator\Controller\Adminhtml\Stores
{
    /**
     * Field id
     */
    const ID_FIELD = 'entity_id';

    /**
     * Resource collection
     *
     * @var string
     */
    protected $collectionFactory;

    /**
     * Page model
     *
     * @var string
     */
    protected $model = 'Bcn\StoreLocator\Model\Stores';

    protected $filter;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        Filter $filter,
        \Bcn\StoreLocator\Model\ResourceModel\Stores\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context,$resultPageFactory,$registry,$resultForwardFactory);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $itemDeleted = 0;
        foreach ($collection->getItems() as $item) {
            $item->delete();
            $itemDeleted++;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $itemDeleted)
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
