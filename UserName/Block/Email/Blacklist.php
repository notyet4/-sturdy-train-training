<?php

namespace Amasty\Username\Block\Email;

use Magento\Framework\View\Element\Template;

class Blacklist extends Template
{
//    public function getSku()
//    {
//        return $this->getData('sku');
//    }

    public function getQty()
    {
        return $this->getData('qty');
    }

    public function getSku()
    {
        return $this->getData('sku');
    }
}