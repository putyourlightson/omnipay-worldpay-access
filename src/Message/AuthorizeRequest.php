<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Purchase Request
 */
class AuthorizeRequest extends PurchaseRequest
{
    /**
     * Set up the authorize-specific data
     *
     * @return mixed
     */
    public function getData()
    {
        $data = parent::getData();

        $data['authorizeOnly'] = true;

        return $data;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return AuthorizeResponse::class;
    }
}
