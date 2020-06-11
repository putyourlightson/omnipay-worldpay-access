<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Purchase Response
 */
class PurchaseResponse extends Response
{
    /**
     * @var string  Payment status that determines success
     */
    protected $successfulPaymentStatus = 'authorized';

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $isHttpSuccess = parent::isSuccessful();
        $isPurchaseSuccess = false;

        if (isset($this->data['outcome']) && $this->data['outcome'] == $this->successfulPaymentStatus) {
            $isPurchaseSuccess = true;
        }

        return ($isHttpSuccess && $isPurchaseSuccess);
    }

    /**
     * What is the relevant description of the transaction response?
     *
     * @todo Sometimes the 'description' field is more user-friendly (see simulated eror) - how do we decide which one?
     *
     * @return string|null
     */
    public function getMessage()
    {
        // check for HTTP failure response first
        $httpMessage = parent::getMessage();

        if ($httpMessage !== null) {
            return $httpMessage;
        }

        // check if descriptive failure reason is available
        if (!$this->isSuccessful() && isset($this->data['paymentStatusReason'])) {
            return $this->data['paymentStatusReason'];
        }

        // check if general payment status is available
        if (isset($this->data['paymentStatus'])) {
            return $this->data['paymentStatus'];
        }
    }
}
