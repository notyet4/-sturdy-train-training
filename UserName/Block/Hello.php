<?php

namespace Amasty\UserName\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template
{
    public function hi()
    {
        return 'hello world!';
    }
}
