<?php

namespace Amasty\UserName\Controller\Index;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;
class GetSku extends Action{



    private $action;

    /**
     * @var CollectionFactory
     */
    private $factory;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    public function __construct(
        Context $context,
        CollectionFactory $factory,
        JsonFactory $jsonFactory
    ) {

        $this->factory = $factory;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }





    public function execute()
    {
        $answer = $this->getRequest()->getParam('value');
        $factory = $this->factory->create();

        $factory->addAttributeToFilter('sku', array('like' => '%'."$answer".'%'));
        $factory->addAttributeToSelect('name');
        $factory->setPageSize(10);

        $data = [];
        foreach ($factory as $product){
            $data [] = [
                'sku' => $product->getSku(),
                'name' => $product->getName()
                ];
        }

        $json = $this->jsonFactory->create();
        $json->setData($data);
        return $json;
    }
}