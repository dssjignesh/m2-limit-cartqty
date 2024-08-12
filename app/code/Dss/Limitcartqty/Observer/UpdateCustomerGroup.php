<?php

declare(strict_types=1);

/**
 * Digit Software Solutions..
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category   Dss
 * @package    Dss_Limitcartqty
 * @author     Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */

namespace Dss\Limitcartqty\Observer;

use Magento\Framework\Event\ObserverInterface;
use Dss\Limitcartqty\Helper\CheckoutFlag;

class UpdateCustomerGroup implements ObserverInterface
{

    /**
     * UpdateCustomerGroup constructor.
     *
     * @param CheckoutFlag $checkoutFlag
     */
    public function __construct(
        protected CheckoutFlag $checkoutFlag
    ) {
    }

    /**
     * Reset Cart
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->checkoutFlag->resetCart();
    }
}
