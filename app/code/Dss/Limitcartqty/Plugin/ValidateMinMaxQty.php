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

use Magento\Customer\Model\ResourceModel\Group\Collection;

class ValidateMinMaxQty
{
    /**
     * ValidateMinMaxQty constructor.
     * @param Collection $customerGroupColl
     */
    public function __construct(
        protected Collection $customerGroupColl
    ) {
        $this->customerGroupColl = $customerGroupColl;
    }

    /**
     * Validate before save config
     *
     * @param \Magento\Config\Model\Config $subject
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function beforeSave(\Magento\Config\Model\Config $subject)
    {
        $customerGroups = $this->getCustomerGroups();
        if ($subject->getSection() == 'Dss_Commerce') {
            $groups = $subject->getGroups();
            $data = $this->processData($groups['item_options']['fields']);
            foreach ($data as $groupId => $qty) {
                if (isset($qty['min']) && isset($qty['max'])) {
                    if ($qty['min'] > $qty['max']) {
                        throw new \Magento\Framework\Exception\ValidatorException(
                            __('Minimum Qty must smaller than Maximum Qty in group %1', $customerGroups[$groupId])
                        );
                    }
                }
            }
        }
    }

    /**
     * Get Customer groups
     *
     * @return array
     */
    protected function getCustomerGroups()
    {
        $customerGroups = [];
        foreach ($this->customerGroupColl->toOptionArray() as $customerGroup) {
            $customerGroups[$customerGroup['value']] = $customerGroup['label'];
        }
        return $customerGroups;
    }

    /**
     * Process qty data
     *
     * @param array $data
     * @return array
     */
    protected function processData($data)
    {
        $minQtyData = $data['dss_min_total_qty']['value'];
        unset($minQtyData['__empty']);
        $maxQtyData = $data['dss_max_total_qty']['value'];
        unset($maxQtyData['__empty']);
        $result = [];
        $result = $this->getQtyByCustomerGroup($minQtyData, $result, 'min');
        $result = $this->getQtyByCustomerGroup($maxQtyData, $result, 'max');
        if (isset($result[32000])) {
            $allGroup = $result[32000];
            unset($result[32000]);
            foreach ($result as &$qty) {
                if (!isset($qty['max']) && isset($allGroup['max'])) {
                    $qty['max'] = $allGroup['max'];
                }
                if (!isset($qty['min']) && isset($allGroup['min'])) {
                    $qty['min'] = $allGroup['min'];
                }
            }
        }
        return $result;
    }

    /**
     * Get Min/Max qty by customer group
     *
     * @param array $qtyData
     * @param array $result
     * @param string $type
     * @return array
     */
    protected function getQtyByCustomerGroup($qtyData, $result, $type)
    {
        foreach ($qtyData as $data) {
            $result[$data['customer_group_id']][$type] = $data['config_value'];
        }
        return $result;
    }
}
