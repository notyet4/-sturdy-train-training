<?php

namespace Amasty\UserName\Controller\Username;

use Magento\Framework\App\ActionInterface;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;
use \Magento\Framework\Controller\Result\RedirectFactory;


class Username implements ActionInterface
{
    /**
     * @var Session
     */
    private $checkoutSession;


    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var GetSalableQuantityDataBySku
     */
    private $getSalableQuantityDataBySku;

    /**
     * @var RedirectFactory
     */
    private $resultRedirectFactory;


    public function __construct(
        Session $checkoutSession,
        ProductRepositoryInterface $productRepository,
        RequestInterface $request,
        GetSalableQuantityDataBySku $getSalableQuantityDataBySku,
        RedirectFactory $resultRedirectFactory

    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }


    public function execute()
    {
        $sku = $this->request->getParam('sku');
        $qty = $this->request->getParam('qty');

        $quote = $this->checkoutSession->getQuote();

        if (!$quote->getId()){
            $quote->save();
        }

        $product = $this->productRepository->get($sku);
        $salable = $this->getSalableQuantityDataBySku->execute($sku);
        $salableQuantity = (int)$salable[0]['qty'];

        try {

            if (!isset($product)) {
                throw new \Exception('product does not exist');
            }

            if ($product->getTypeId()!== 'simple'){
                throw new \Exception('product type is not simple');
            }

            if ($qty <= 0){
                throw new \Exception('qty must be > than 0'); //добавлена проверка инпута на фронте, но здесь тоже лишней не будет?
            }

            if ($qty > $salableQuantity){
                throw new \Exception('no such quantity of product');
            }

            $quote->addProduct($product,$qty);
            $quote->save();
            //die('product added to cart');
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/');

        }catch (\Exception $e){
            echo $e->getMessage();
            die();
        }

    }
}
