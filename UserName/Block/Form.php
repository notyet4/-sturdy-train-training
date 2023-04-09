<?php

namespace Amasty\UserName\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function showQty(): bool
    {
        return $this->scopeConfig->isSetFlag('test_config/general/qty') ?: '';
    }

    /*public function getQty(): int
    {
        return $this->scopeConfig->getValue('test_config/general/qty_value') ?: '' ;
    }*/

}
