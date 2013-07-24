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
 * Cash On Delivery Model Test Case
 *
 * @category    Mzentrale
 * @package     Mzentrale_Cashondelivery
 * @author      Francesco Marangi | mzentrale
 */
class Mzentrale_Cashondelivery_Test_Model_Method_Cashondelivery extends EcomDev_PHPUnit_Test_Case
{
    /** @var Mzentrale_Cashondelivery_Model_Method_Cashondelivery */
    protected $_model;

    public function setUp()
    {
        $this->_model = Mage::helper('payment')->getMethodInstance('cashondelivery');
    }

    /**
     * @loadFixture config
     */
    public function testMethodIsApplicableToQuote()
    {
        $quote = Mage::getModel('sales/quote');

        $billingAddress = Mage::getModel('sales/quote_address');
        $billingAddress->setCountryId('DE');
        $quote->setBillingAddress($billingAddress);

        $shippingAddress = Mage::getModel('sales/quote_address');
        $shippingAddress->setCountryId('AT');
        $quote->setShippingAddress($shippingAddress);

        $this->assertFalse($this->_model->isApplicableToQuote($quote, Mage_Payment_Model_Method_Abstract::CHECK_USE_FOR_COUNTRY));
    }

    /**
     * @loadFixture config
     */
    public function testMethodIsNotApplicableToQuote()
    {
        $quote = Mage::getModel('sales/quote');

        $billingAddress = Mage::getModel('sales/quote_address');
        $billingAddress->setCountryId('AT');
        $quote->setBillingAddress($billingAddress);

        $shippingAddress = Mage::getModel('sales/quote_address');
        $shippingAddress->setCountryId('DE');
        $quote->setShippingAddress($shippingAddress);

        $this->assertTrue($this->_model->isApplicableToQuote($quote, Mage_Payment_Model_Method_Abstract::CHECK_USE_FOR_COUNTRY));
    }

    /**
     * @loadFixture config
     */
    public function testMethodValidates()
    {
        $paymentInfo = Mage::getModel('sales/quote_payment');
        $quote = Mage::getModel('sales/quote');
        $paymentInfo->setQuote($quote);

        $billingAddress = Mage::getModel('sales/quote_address');
        $billingAddress->setCountryId('AT');
        $quote->setBillingAddress($billingAddress);

        $shippingAddress = Mage::getModel('sales/quote_address');
        $shippingAddress->setCountryId('DE');
        $quote->setShippingAddress($shippingAddress);

        try {
            $this->_model->setInfoInstance($paymentInfo);
            $this->_model->validate();
        } catch (Mage_Core_Exception $e) {
            $this->fail('No exception should to be thrown');
        }
    }

    /**
     * @loadFixture config
     * @expectedException Mage_Core_Exception
     */
    public function testMethodFailsValidation()
    {
        $paymentInfo = Mage::getModel('sales/quote_payment');
        $quote = Mage::getModel('sales/quote');
        $paymentInfo->setQuote($quote);

        $billingAddress = Mage::getModel('sales/quote_address');
        $billingAddress->setCountryId('DE');
        $quote->setBillingAddress($billingAddress);

        $shippingAddress = Mage::getModel('sales/quote_address');
        $shippingAddress->setCountryId('AT');
        $quote->setShippingAddress($shippingAddress);

        $this->_model->setInfoInstance($paymentInfo);
        $this->_model->validate();
    }
}
