<?php

namespace Amasty\UserName\Controller\Index;

use Magento\Framework\App\ActionInterface;

class Index implements ActionInterface
{
    public function execute() {
        echo 'Привет Magento. Привет Amasty. Я готов тебя покорить!';
        die;
    }
}