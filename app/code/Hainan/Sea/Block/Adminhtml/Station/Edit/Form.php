<?php

namespace Hainan\Sea\Block\Adminhtml\Station\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_location;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Bcn\StoreLocator\Model\Location $location,
        array $data = []
    ) {
        $this->_location = $location;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();

        $this->setId('location_form');
        $this->setTitle(__('Location Information'));
    }

    protected function _prepareForm()
    {
        /** @var \Bcn\StoreLocator\Model\Location $model */
        $model = $this->_coreRegistry->registry('storelocator_location_content');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save', ['store' => $this->getRequest()->getParam('store')]),
                    'method' => 'post'
                ]
            ]
        );

        $form->setHtmlIdPrefix('storelocatorlocation_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('General Information'),
                //'class' => 'fieldset-wide'
            ]
        );

        if (isset($model) && $model->getEntityId()) {
            $fieldset->addField('hainan_sea_main_id', 'hidden', ['name' => 'hainan_sea_main_id']);
            $fieldset->addField('path', 'hidden', ['name' => 'path']);
            $fieldset->addField('level', 'hidden', ['name' => 'level']);
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'location_code',
            'text',
            [
                'name' => 'location_code',
                'label' => __('Location Code'),
                'title' => __('Location Code'),
                'required' => true,
                'class' => 'validate-xml-identifier'
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );

        $fieldset->addField(
            'position',
            'text',
            [
                'name' => 'position',
                'label' => __('Position'),
                'title' => __('Position'),
                'required' => false
            ]
        );

        if (!$model->getId()) {
            $model->setData('status', '1');
        }

        $fieldset->addField(
            'parent_id',
            'select',
            [
                'name' => 'parent_id',
                'label' => __('Parent'),
                'title' => __('Parent'),
                'required' => false,
                'options' => $this->_location->getLocationOptions()
            ]
        );



        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
