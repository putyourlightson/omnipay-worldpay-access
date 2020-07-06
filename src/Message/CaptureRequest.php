<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Capture Request
 */
class CaptureRequest extends Request
{
    /**
     * @return array
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
     * @return string
     */
    public function getEndpoint()
    {
        $links = $this->getPurchaseResponseLinks();

        return $links['payments:payments:partialSettle']['href'] ?? '';
    }
}
