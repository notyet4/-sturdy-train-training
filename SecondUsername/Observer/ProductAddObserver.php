<?php

namespace Amasty\SecondUsername\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Api\ProductRepositoryInterface;
class ProductAddObserver implements ObserverInterface
{


    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var Session
     */
    private $checkoutSession;


    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;


    public function __construct(
        Session $checkoutSession,
        ScopeConfigInterface $scopeConfig,
        ProductRepositoryInterface $productRepository,
    ){
        $this->productRepository = $productRepository;
        $this->checkoutSession = $checkoutSession;
        $this->scopeConfig = $scopeConfig;
    }



    public function execute(Observer $observer)
    {
        $productSku = $observer->getData('sku');
        $forSku =  explode(',', $this->scopeConfig->getValue('second_test_config/general/for_sku'));
        $promoSku = $this->scopeConfig->getValue('second_test_config/general/promo_sku');


        foreach ($forSku as $item){
            if ( $productSku == $item){
                $quote = $this->checkoutSession->getQuote();
                $product = $this->productRepository->get($promoSku);
                $quote->addProduct($product, 1);
                $quote->save();
            }
        }

    }


}
