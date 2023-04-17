<?php

namespace Amasty\UserName\Controller\Username;

use Magento\Framework\App\ActionInterface;
use \Magento\Framework\Message\ManagerInterface;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;
use \Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Amasty\UserName\Model\BlacklistFactory;
use Amasty\UserName\Model\ResourceModel\Blacklist;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Amasty\UserName\Model\ResourceModel\Blacklist\CollectionFactory as BlacklistCollectionFactory;



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


    /**
     * @var EventManager
     */
    private $eventManager;


    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;


    /**
     * @var Blacklist
     */
    private $blacklistResource;


    /**
     * @var CollectionFactory
     */
    private $collectionFactory;


    /**
     * @var BlacklistCollectionFactory
     */
    private $blacklistCollectionFactory;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    public function __construct(
        Session $checkoutSession,
        ProductRepositoryInterface $productRepository,
        RequestInterface $request,
        GetSalableQuantityDataBySku $getSalableQuantityDataBySku,
        RedirectFactory $resultRedirectFactory,
        EventManager $eventManager,
        BlacklistFactory $blacklistFactory,
        Blacklist $blacklistResource,
        CollectionFactory $collectionFactory,
        BlacklistCollectionFactory $blacklistCollectionFactory,
        ManagerInterface $messageManager

    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->eventManager = $eventManager;
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
        $this->collectionFactory = $collectionFactory;
        $this->blacklistCollectionFactory = $blacklistCollectionFactory;
        $this->messageManager = $messageManager;
    }


//    public function addSkuInBlacklist($sku)
//    {
//        $blacklist = $this->blacklistFactory->create();
//        $blacklist->setSku($sku);
//        $blacklist->setQty(5);
//        $this->blacklistResource->save($blacklist);
//
//    }



    public function checkQtyQuote($sku){
        $cartQty = $this->checkoutSession->getQuote()->getAllItems();
        foreach ($cartQty as $item) {
            if ($sku == $item->getSku()) {

              return $item->getQty();

            }else{
                return 0;
            }
        }

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

            $blacklistCollection = $this->blacklistCollectionFactory->create();
            $blacklistCollection->addFieldToFilter('sku', ['eq'=> $sku]);
            $blacklistSku = '';


            foreach ($blacklistCollection as $item){

                $blacklistSku = $item->getSku();

            }



            $blacklist = $this->blacklistFactory->create();
            $this->blacklistResource->load(
                $blacklist,
                $sku,
                'sku'
            );


            $blacklistQty = (int)$blacklist->getQty();
            $cartQty = (int) $this->checkQtyQuote($sku);

            $sumQty = $qty + $cartQty;


            if ($blacklistSku !== $sku){
                $quote->addProduct($product,$qty);
                $quote->save();
               $this->messageManager->addSuccessMessage("added $qty  products");
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/');

            }else{

                if ($sumQty > $blacklistQty){
                    $addQuantity = $blacklistQty - $cartQty;
                    $quote->addProduct($product,$addQuantity);
                    $quote->save();
                    $this->messageManager->addSuccessMessage("added $addQuantity  products");
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/');
                }else{
                    $quote->addProduct($product,$qty);
                    $quote->save();
                    $this->messageManager->addSuccessMessage("added $qty  products");
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/');
                }



            }




        }catch (\Exception $e){
            echo $e->getMessage();
            die();
        }

    }
}