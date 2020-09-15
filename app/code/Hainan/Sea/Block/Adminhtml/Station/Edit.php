<?php

namespace Hainan\Sea\Block\Adminhtml\Station;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'hainan_sea_main_id';
        $this->_blockGroup = 'Hainan_Sea';
        $this->_controller = 'sea_manage';

        parent::_construct();

        if ($this->_isAllowedAction('Hainan_Sea:save')) {
            $this->buttonList->update('save', 'label', __('Save'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Hainan_Sea::delete')) {
            $this->buttonList->update('delete', 'label', __('Delete'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('storelocator_location_content')->getId()) {
            return __("Edit Location '%1'", $this->escapeHtml($this->_coreRegistry->registry('brand_content')->getName()));
        } else {
            return __('New Location');
        }
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('sea_manage/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
