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
     * @inheritDoc
     */
    public function getEndpoint()
    {
        $links = $this->getAuthorizeResponseLinks();

        return $links['payments:settle']['href'] ?? '';
    }
}
