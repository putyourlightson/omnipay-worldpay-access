<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Purchase Request
 *
 * @link https://developer.worldpay.com/docs/access-worldpay/payments/manage-payments#settle-an-authorization
 */
class PurchaseRequest extends Request
{
    /**
     * Set up the base data for a purchase request
     *
     * @return mixed[]
     */
    public function getData()
    {
        return array();
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        $links = $this->getAuthorizeResponseLinks();

        $endpoint = $links['payments:settle']['href'] ?? '';

        return $endpoint;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return Response::class;
    }
}
