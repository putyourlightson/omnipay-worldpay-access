<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Authorize Response
 */
class AuthorizeResponse extends Response
{
    /**
     * @var string Outcome that determines success
     */
    protected $successfulStatus = 'authorized';

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $isHttpSuccess = parent::isSuccessful();
        $isSuccess = false;

        if (isset($this->data['outcome']) && $this->data['outcome'] == $this->successfulStatus) {
            $isSuccess = true;
        }

        return ($isHttpSuccess && $isSuccess);
    }
}
