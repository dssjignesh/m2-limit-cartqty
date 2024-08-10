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
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\Response\HttpInterface;
use Magento\Framework\UrlFactory;

class ValidateCheckoutPaypal
{
    /**
     * ValidateCheckoutPaypal constructor.
     * @param CheckoutFlag $checkoutFlag
     * @param Http $response
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        protected CheckoutFlag $checkoutFlag,
        protected Http $response,
        protected UrlFactory $urlFactory
    ) {
    }

    /**
     * AfterExecute
     *
     * @param \Magento\Paypal\Controller\Express\Start $subject
     * @param \Closure $proceed
     * @return Http|HttpInterface|mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(\Magento\Paypal\Controller\Express\Start $subject, \Closure $proceed)
    {
        if ($this->checkoutFlag->isEnableToCheckout()) {
            return $proceed();
        } else {
            $cartUrl = $this->urlFactory->create()->getUrl('checkout/cart');
            return $this->response->setRedirect($cartUrl);
        }
    }
}
