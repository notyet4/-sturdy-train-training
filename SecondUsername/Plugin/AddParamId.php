<?php

namespace Amasty\SecondUsername\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;

class AddParamId
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;



    /**
     * @var RequestInterface
     */
    private $request;


    public function __construct(
        ProductRepositoryInterface $productRepository,
        RequestInterface $request
    ){
        $this->productRepository = $productRepository;
        $this->request = $request;
    }


    private function getProductId($sku)
    {

        $product = $this->productRepository->get($sku);

        return $product->getId();

    }



    public function beforeExecute($subject){

        $sku = $this->request->getParam('sku');
        $productId = $this->getProductId($sku);
        $this->request->setParam('product', $productId);

    }
}