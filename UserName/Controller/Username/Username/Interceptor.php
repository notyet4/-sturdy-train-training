<?php
namespace Amasty\UserName\Controller\Username\Username;

/**
 * Interceptor class for @see \Amasty\UserName\Controller\Username\Username
 */
class Interceptor extends \Amasty\UserName\Controller\Username\Username implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Framework\App\RequestInterface $request, \Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku $getSalableQuantityDataBySku, \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory, \Magento\Framework\Event\ManagerInterface $eventManager, \Amasty\UserName\Model\BlacklistFactory $blacklistFactory, \Amasty\UserName\Model\ResourceModel\Blacklist $blacklistResource, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory, \Amasty\UserName\Model\ResourceModel\Blacklist\CollectionFactory $blacklistCollectionFactory, \Magento\Framework\Message\ManagerInterface $messageManager)
    {
        $this->___init();
        parent::__construct($checkoutSession, $productRepository, $request, $getSalableQuantityDataBySku, $resultRedirectFactory, $eventManager, $blacklistFactory, $blacklistResource, $collectionFactory, $blacklistCollectionFactory, $messageManager);
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
