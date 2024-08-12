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

namespace Dss\Limitcartqty\Model\System\Config\Backend;

use Dss\Limitcartqty\Helper\ConfigValue;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class ConfigModel extends Value
{
    /**
     * ConfigModel constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param ConfigValue|null $configValue
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        protected ConfigValue $configValue,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * _afterLoad
     *
     * @return Value|void
     * @throws LocalizedException
     */
    protected function _afterLoad(): void
    {
        $value = $this->getValue();
        $value = $this->configValue->makeArrayFieldValue($value);
        $this->setValue($value);
    }

    /**
     * BeforeSave
     *
     * @return Value|void
     * @throws LocalizedException
     */
    public function beforeSave(): void
    {
        $value = $this->getValue();
        if (!$this->configValue->validateMinMaxQty($value)) {
            throw new \Magento\Framework\Exception\ValidatorException(__('Qty must be integer and greater than zero.'));
        }
        $value = $this->configValue->makeStorableArrayFieldValue($value);
        $this->setValue($value);
    }
}
