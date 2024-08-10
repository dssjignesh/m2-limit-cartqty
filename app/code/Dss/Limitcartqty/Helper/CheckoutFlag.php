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

namespace Dss\Limitcartqty\Helper;

use Dss\Limitcartqty\Api\DataConfigInterface;
use Magento\Checkout\Model\Cart;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class CheckoutFlag extends AbstractHelper
{
    /**
     * CheckoutFlag constructor.
     *
     * @param Context $context
     * @param Cart $cart
     * @param DataConfigInterface $dataConfig
     * @param Session $customerSession
     * @param ManagerInterface $messageManager
     * @param CustomMessage $customMessage
     */
    public function __construct(
        protected Context $context,
        protected Cart $cart,
        protected DataConfigInterface $dataConfig,
        protected Session $customerSession,
        protected ManagerInterface $messageManager,
        protected CustomMessage $customMessage
    ) {
        parent::__construct($context);
    }

    /**
     * Validate Checkout
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function validateCheckout(): bool
    {
        return $this->validateMax() && $this->validateMin();
    }

    /**
     * Check Enable
     *
     * @return bool
     */
    public function isEnableToCheckout(): bool
    {
        return $this->checkMax() && $this->checkMin();
    }

    /**
     * Validate Min
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function validateMin(): bool
    {
        if ($this->checkMin()) {
            return true;
        } else {
            $this->messageManager->addError(
                $this->customMessage->getMinMessage(
                    round($this->getMinConfigCartQty()),
                    round((int) $this->getCartQty())
                )
            );
            return false;
        }
    }

    /**
     * Validate Max
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function validateMax(): bool
    {
        if ($this->checkMax()) {
            return true;
        } else {
            $this->messageManager->addError(
                $this->customMessage->getMaxMessage(
                    round($this->getMaxConfigCartQty()),
                    round((int) $this->getCartQty())
                )
            );
            return false;
        }
    }

    /**
     * Check Max
     *
     * @return bool
     */
    public function checkMax(): bool
    {
        $this->customerSession->setMaxConfigCartQty($this->dataConfig->getMaxValue());
        return !($this->getMaxConfigCartQty()
            && $this->getCartQty() > $this->getMaxConfigCartQty())
            || !$this->dataConfig->isModuleEnable();
    }

    /**
     * Check Min
     *
     * @return bool
     */
    public function checkMin(): bool
    {
        $this->customerSession->setMinConfigCartQty($this->dataConfig->getMinValue());
        return !($this->getMinConfigCartQty()
            && $this->getCartQty() < $this->getMinConfigCartQty())
            || !$this->dataConfig->isModuleEnable();
    }

    /**
     * Get Min
     *
     * @return mixed
     */
    public function getMinConfigCartQty(): mixed
    {
        return $this->customerSession->getMinConfigCartQty();
    }

    /**
     * Get Max
     *
     * @return mixed
     */
    public function getMaxConfigCartQty(): mixed
    {
        return $this->customerSession->getMaxConfigCartQty();
    }

    /**
     * GetQty
     *
     * @return mixed
     */
    public function getCartQty(): mixed
    {
        if (!$this->customerSession->getCartQty()) {
            $this->customerSession->setCartQty($this->cart->getQuote()->getItemsQty());
        }
        return $this->customerSession->getCartQty();
    }

    /**
     * Reset Cart
     */
    public function resetCart()
    {
        $this->customerSession->setCartQty(null);
    }
}
