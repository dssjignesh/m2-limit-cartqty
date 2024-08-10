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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class CustomMessage
{
    /**
     * @var storeId
     */
    protected $storeId;

    /**
     * CustomMessage constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
        protected StoreManagerInterface $storeManager
    ) {
    }

    /**
     * Replace Data
     *
     * @param string $text
     * @param string $conf
     * @param string $cart
     * @return string
     */
    public function replaceData($text, $conf, $cart): string
    {
        $text1 = str_replace("-conf-", (string) $conf, $text);
        $text2 = str_replace("-cart-", (string) $cart, $text1);
        return $text2;
    }

    /**
     * Get Min Message
     *
     * @param string $conf
     * @param string $cart
     * @return Phrase|mixed
     * @throws NoSuchEntityException
     */
    public function getMinMessage($conf, $cart)
    {
        $value = $this->scopeConfig->getValue(
            'Dss_Commerce/item_options/Dss_min_total_qty_message',
            ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
        if ($value === null) {
            return __('The fewest you may purchase is %1, you have %2 !', $conf, $cart);
        } else {
            return $this->replaceData($value, $conf, $cart);
        }
    }

    /**
     * GetMaxMessage
     *
     * @param string $conf
     * @param string $cart
     * @return Phrase|mixed
     * @throws NoSuchEntityException
     */
    public function getMaxMessage($conf, $cart)
    {
        $value = $this->scopeConfig->getValue(
            'Dss_Commerce/item_options/Dss_max_total_qty_message',
            ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
        if ($value === null) {
            return __('The most you may purchase is %1, you have %2 !', $conf, $cart);
        } else {
            return $this->replaceData($value, $conf, $cart);
        }
    }

    /**
     * GetStoreId
     *
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStoreId()
    {
        if ($this->storeId === null) {
            $this->storeId = $this->storeManager->getStore()->getId();
        }
        return $this->storeId;
    }
}
