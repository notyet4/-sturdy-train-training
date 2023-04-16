<?php

namespace Amasty\SecondUsername\Controller\Index;

use Amasty\UserName\Controller\Index\Index as FirstIndex;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;

Class Index extends FirstIndex{

    /**
     * @var Session
     */
    private $session;


    public function __construct(
        ResultFactory $resultFactory,
        ScopeConfigInterface $scopeConfig,
        Session $session,
    ){
        $this->session = $session;
        parent::__construct($resultFactory, $scopeConfig);
    }


    public function execute(){
        
        if(!$this->session->isLoggedIn()) {
            die('you must be registered');
        }

        return parent::execute();
    }

}