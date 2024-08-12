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

namespace Dss\Limitcartqty\Block;

use Dss\Limitcartqty\Helper\CheckoutFlag;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class MinMaxCart extends Template
{
    /**
     * Minmaxcart constructor.
     *
     * @param Context $context
     * @param CheckoutFlag $checkoutFlag
     * @param array $data
     */
    public function __construct(
        protected Context $context,
        protected CheckoutFlag $checkoutFlag,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    /**
     * Get Checkout flag
     *
     * @return bool
     */
    public function getCheckoutFlag(): bool
    {
        return $this->checkoutFlag->isEnableToCheckout();
    }

    /**
     * Return list of available checkout methods
     *
     * @param string $alias Container block alias in layout
     * @return array
     */
    public function getMethods($alias)
    {
        $childName = $this->getLayout()->getChildName($this->getNameInLayout(), $alias);
        if ($childName) {
            return $this->getLayout()->getChildNames($childName);
        }
        return [];
    }

    /**
     * Return HTML of checkout method (link, button etc.)
     *
     * @param string $name Block name in layout
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMethodHtml($name)
    {
        $block = $this->getLayout()->getBlock($name);
        if (!$block) {
            throw new \Magento\Framework\Exception\LocalizedException(
                new Phrase(
                    $this->escapeHtml(
                        __('Invalid method: %1', $name)
                    )
                )
            );
        }
        return $block->toHtml();
    }
}
