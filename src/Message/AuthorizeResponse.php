<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Authorize Request
 */
class AuthorizeResponse extends PurchaseResponse
{
    /**
     * @var string  Payment status that determines success
     */
    protected $successfulPaymentStatus = 'AUTHORIZED';
}
