<?php
namespace Amasty\SecondUsername\Controller\Index\Index;

/**
 * Interceptor class for @see \Amasty\SecondUsername\Controller\Index\Index
 */
class Interceptor extends \Amasty\SecondUsername\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Customer\Model\Session $session)
    {
        $this->___init();
        parent::__construct($resultFactory, $scopeConfig, $session);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
