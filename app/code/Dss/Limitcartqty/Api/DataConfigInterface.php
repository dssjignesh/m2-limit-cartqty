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
     * @return float|mixed|null
     */
    public function getMinValue(): float|null;

    /**
     * MaxValue
     *
     * @return float|mixed|null
     */
    public function getMaxValue(): float|null;

    /**
     * CustomerId
     *
     * @return int|mixed
     */
    public function getCustomerId(): mixed;

    /**
     * Store Id
     *
     * @return int|mixed
     */
    public function getStoreId(): mixed;
}
