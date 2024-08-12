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

use Dss\Limitcartqty\Helper\CheckoutFlag;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class UpdateCartObserver implements ObserverInterface
{
    /**
     * UpdateCartObserver constructor.
     *
     * @param CheckoutFlag $checkoutFlag
     */
    public function __construct(
        protected CheckoutFlag $checkoutFlag
    ) {
    }

    /**
     * Execute
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->checkoutFlag->resetCart();
    }
}
