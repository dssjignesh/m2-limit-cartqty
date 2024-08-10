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

namespace Dss\Limitcartqty\Plugin;

use Dss\Limitcartqty\Helper\CheckoutFlag;
use Magento\Checkout\Controller\Index\Index;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\Response\HttpInterface;
use Magento\Multishipping\Helper\Data;

class MintotalRedirect
{
    /**
     * MintotalRedirect constructor.
     *
     * @param CheckoutFlag $checkoutFlag
     * @param Http $response
     */
    public function __construct(
        protected CheckoutFlag $checkoutFlag,
        protected Http $response
    ) {
    }

    /**
     * AfterExecute
     *
     * @param Index $subject
     * @param array $result
     * @return Http|HttpInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterExecute(Index $subject, $result)
    {
        if ($this->checkoutFlag->isEnableToCheckout()) {
            return $result;
        } else {
            return $this->response->setRedirect('cart');
        }
    }

    /**
     * MultishippingCheckout
     *
     * @param Data $subject
     * @param array $result
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterIsMultishippingCheckoutAvailable(Data $subject, $result)
    {
        return $this->checkoutFlag->validateCheckout() && $result;
    }
}
