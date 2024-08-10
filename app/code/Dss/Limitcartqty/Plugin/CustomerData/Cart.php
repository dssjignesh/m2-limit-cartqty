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

namespace Dss\Limitcartqty\Plugin\CustomerData;

use Dss\Limitcartqty\Api\DataConfigInterface;
use Dss\Limitcartqty\Helper\CheckoutFlag;
use Dss\Limitcartqty\Helper\ConfigValue;
use Magento\Framework\Exception\NoSuchEntityException;

class Cart
{
    /**
     * Cart constructor.
     *
     * @param DataConfigInterface $dataConfig
     * @param CheckoutFlag $checkoutFlag
     * @param ConfigValue $helper
     */
    public function __construct(
        protected DataConfigInterface $dataConfig,
        protected CheckoutFlag $checkoutFlag,
        protected ConfigValue $helper
    ) {
    }

    /**
     * Get Section
     *
     * @param \Magento\Checkout\CustomerData\Cart $subject
     * @param array $result
     * @return mixed
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetSectionData(\Magento\Checkout\CustomerData\Cart $subject, $result)
    {
        if ($this->helper->isModuleEnable() == 1) {
            if ($result['summary_count'] > $this->dataConfig->getMaxValue() ||
                $result['summary_count'] < $this->dataConfig->getMinValue()
            ) {
                $result['possible_onepage_checkout'] = false;
            }
        }
        return $result;
    }
}
