<?php
/**
 * Created by PhpStorm.
 * User: XLY
 * Date: 2019/11/1
 * Time: 17:59
 */

namespace Hainan\Sea\Controller\Adminhtml\Station;


use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;



class Edit extends \Magento\Backend\App\Action
{

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

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hainan_Sea::blog')
            ->addBreadcrumb(__('blog'), __('blog'))
            ->addBreadcrumb(__('Manage blog'), __('Manage blog'));
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('hainan_sea_main_id');
        $storeViewId = $this->getRequest()->getParam('store', 0);

        $model = $this->_objectManager->create('Hainan\Sea\Model\Station');

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
