<?php


namespace Hainan\Sea\Component;

use Magento\Framework\View\Element\BlockInterface;

class SimpleValidHijackingHtmlContent  extends \Magento\Ui\Component\AbstractComponent
{


    const NAME = 'html_content_hainan_valid';

    public function getComponentName()
    {
        return self::getName();
    }
}

