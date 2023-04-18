<?php

namespace Amasty\UserName\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Event\ManagerInterface as EventManager;

class Form extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;


    const FORM_ACTION = 'USERNAME/Username/Username';

    /**
     * @var EventManager
     */

    protected $eventManager;

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

    public function getFormAction()
    {
        return self::FORM_ACTION;
    }

}
