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

namespace Dss\Limitcartqty\Api;

interface DataConfigInterface
{
    /**
     * MinValue
     *
     * @return mixed
     */
    public function getMinValue();

    /**
     * MaxValue
     *
     * @return mixed
     */
    public function getMaxValue();

    /**
     * CustomerId
     *
     * @return mixed
     */
    public function getCustomerId();

    /**
     * Store Id
     *
     * @return mixed
     */
    public function getStoreId();
}
