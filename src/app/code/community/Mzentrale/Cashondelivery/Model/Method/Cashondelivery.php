<?php

/**
 * The MIT License
 *
 * Copyright (c) 2013 mzentrale | eCommerce - eBusiness
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Cash on delivery payment method model
 *
 * @category    Mzentrale
 * @package     Mzentrale_Cashondelivery
 * @author      Francesco Marangi | mzentrale
 */
class Mzentrale_Cashondelivery_Model_Method_Cashondelivery extends Mage_Payment_Model_Method_Cashondelivery
{
    /**
     * Check whether payment method is applicable to quote
     *
     * @param Mage_Sales_Model_Quote $quote
     * @param int|null $checksBitMask
     * @return bool|void
     */
    public function isApplicableToQuote($quote, $checksBitMask)
    {
        if ($checksBitMask & self::CHECK_USE_FOR_COUNTRY) {
            if (!$this->canUseForCountry($quote->getShippingAddress()->getCountryId())) {
                return false;
            }
        }

        // Skip country check, already performed above
        return parent::isApplicableToQuote($quote, $checksBitMask & ~self::CHECK_USE_FOR_COUNTRY);
    }

    /**
     * Validate payment method information object
     *
     * @return Mage_Payment_Model_Abstract
     */
    public function validate()
    {
        /**
         * to validate payment method is allowed for billing country or not
         */
        $paymentInfo = $this->getInfoInstance();
        if ($paymentInfo instanceof Mage_Sales_Model_Order_Payment) {
            $shippingCountry = $paymentInfo->getOrder()->getShippingAddress()->getCountryId();
        } else {
            $shippingCountry = $paymentInfo->getQuote()->getShippingAddress()->getCountryId();
        }
        if (!$this->canUseForCountry($shippingCountry)) {
            Mage::throwException(Mage::helper('payment')->__('Selected payment type is not allowed for shipping country.'));
        }
        return $this;
    }
}
