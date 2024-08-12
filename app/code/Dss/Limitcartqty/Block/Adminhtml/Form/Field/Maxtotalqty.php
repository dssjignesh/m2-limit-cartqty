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

namespace Dss\Limitcartqty\Block\Adminhtml\Form\Field;

use Magento\CatalogInventory\Block\Adminhtml\Form\Field\Customergroup;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\BlockInterface;

class Maxtotalqty extends AbstractFieldArray
{
    /**
     * Group Render
     * @var groupRenderer
     */
    protected $groupRenderer;
    /**
     * Get Group
     *
     * @throws LocalizedException
     * @return BlockInterface
     */
    protected function _getGroupRenderer(): BlockInterface
    {
        if (!$this->groupRenderer) {
            $this->groupRenderer = $this->getLayout()->createBlock(
                Customergroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->groupRenderer->setClass('customer_group_select');
        }
        return $this->groupRenderer;
    }

    /**
     * Prepare To Render
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn(
            'customer_group_id',
            ['label' => __('Customer Group'), 'renderer' => $this->_getGroupRenderer()]
        );
        $this->addColumn('config_value', ['label' => __('Maximum Qty')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Maximum Qty');
    }

    /**
     * PrepareArrayRow
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $optionExtraAttr = [];
        $optionExtraAttr['option_' . $this->_getGroupRenderer()->calcOptionHash($row->getData('customer_group_id'))] =
            'selected="selected"';
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}
