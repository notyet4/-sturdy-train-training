<?php

namespace Amasty\Username\Cron;

use Psr\Log\LoggerInterface;

class SendBlacklistEmail
{
    public function __construct(
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
    }

    public function execute(){

    }

}