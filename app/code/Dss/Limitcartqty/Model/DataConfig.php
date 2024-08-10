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

namespace Dss\Limitcartqty\Model;

use Dss\Limitcartqty\Api\DataConfigInterface;
use Dss\Limitcartqty\Helper\ConfigValue;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class DataConfig implements DataConfigInterface
{
    /**
     * @var $customerGroupId
     */
    protected $customerGroupId;
    /**
     * @var $storeId
     */
    protected $storeId;

    /**
     * DataConfig constructor.
     *
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     * @param ConfigValue $configValue
     */
    public function __construct(
        protected Session $customerSession,
        protected StoreManagerInterface $storeManager,
        protected ConfigValue $configValue
    ) {
    }

    /**
     * GetMinValue
     *
     * @return float|mixed|null
     * @throws LocalizedException
     */
    public function getMinValue(): float|null
    {
        return $this->configValue->getMinConfigValue($this->getCustomerId());
    }

    /**
     * GetMaxValue
     *
     * @return float|mixed|null
     * @throws LocalizedException
     */
    public function getMaxValue(): float|null
    {
        return $this->configValue->getMaxConfigValue($this->getCustomerId());
    }

    /**
     * IsModuleEnable
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function isModuleEnable(): mixed
    {
        return $this->configValue->isModuleEnable();
    }

    /**
     * GetCustomerId
     *
     * @return int|mixed
     */
    public function getCustomerId(): mixed
    {
        return $this->customerSession->getCustomerGroupId();
    }

    /**
     * GetStoreId
     *
     * @return int|mixed
     * @throws NoSuchEntityException
     */
    public function getStoreId(): mixed
    {
        if ($this->storeId === null) {
            $this->storeId = $this->storeManager->getStore()->getId();
        }
        return $this->storeId;
    }
}
