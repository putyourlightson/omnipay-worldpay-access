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
     * @inheritDoc
     *
     * @link https://developer.worldpay.com/docs/access-worldpay/payments/manage-payments#partially-refund-a-payment
     */
    public function getData()
    {
        $this->validate('amount');

        $data = array(
            'value' => array(
                'amount' => $this->getAmountInteger(),
                'currency' => $this->getCurrency(),
            ),
            'reference' => $this->getTransactionReference(),
        );

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function getEndpoint()
    {
        $links = $this->getPurchaseResponseLinks();

        return $links['payments:partialRefund']['href'] ?? '';
    }
}
