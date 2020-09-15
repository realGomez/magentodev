<?php


namespace Hainan\Sea\Component;

use Magento\Framework\View\Element\BlockInterface;

class SimpleValid  extends \Magento\Framework\View\Element\AbstractBlock
{
    public function toHtml()
    {
        return '<h1>Hello PHP Block Rendered in JS</h1>';
    }

}

