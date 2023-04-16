<?php

namespace Amasty\SecondUsername\Plugin;

class ChangeForm
{
    public function aroundGetFormAction
    (\Amasty\UserName\Block\Form $subject): string
    {
        $result = 'checkout/cart/add';
        return $result;
    }
}