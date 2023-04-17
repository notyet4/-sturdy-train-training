<?php

namespace Amasty\UserName\Model\ResourceModel\Blacklist;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Amasty\UserName\Model\Blacklist::class,
            \Amasty\UserName\Model\ResourceModel\Blacklist::class

        );
    }
}