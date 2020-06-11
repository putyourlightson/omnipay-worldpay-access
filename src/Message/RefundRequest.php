<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Refund Request
 */
class RefundRequest extends Request
{
    /**
     * Set up the refund-specific data
     *
     * @link https://developer.worldpay.com/docs/access-worldpay/payments/manage-payments#partially-refund-a-payment
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('amount');

        $data = array(
            'value' => array(
                'amount' => $this->getAmountInteger(),
                'currency' => $this->getCurrency(),
            ),
            'reference' => 'Refund',
        );

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().'/payments/settlements/refunds/partials/'.$this->getTransactionReference();
    }
}
