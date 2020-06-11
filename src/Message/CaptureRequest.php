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
        $data = array();

        $data['captureAmount'] = $this->getAmountInteger();

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().'/orders/'.$this->getTransactionReference().'/capture';
    }
}
