<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess;

use Http\Adapter\Guzzle6\Client as GuzzleClient;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Http\Client;
use Omnipay\WorldpayAccess\Message\AuthorizeRequest;
use Omnipay\WorldpayAccess\Message\CaptureRequest;
use Omnipay\WorldpayAccess\Message\PurchaseRequest;
use Omnipay\WorldpayAccess\Message\RefundRequest;

/**
 * WorldPay Access Gateway
 *
 * @link https://developer.worldpay.com/docs/access-worldpay
 */
class Gateway extends AbstractGateway
{
    /**
     * Name of the gateway
     *
     * @return string
     */
    public function getName()
    {
        return 'WorldPay Access';
    }

    /**
     * Setup the default parameters
     *
     * @return string[]
     */
    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'serviceKey' => '',
            'clientKey' => '',
        );
    }

    /**
     * Get the stored service key
     *
     * @return string
     */
    public function getServiceKey()
    {
        return $this->getParameter('serviceKey');
    }

    /**
     * Set the stored service key
     *
     * @param string $value Service key to store
     * @return Gateway
     */
    public function setServiceKey($value)
    {
        return $this->setParameter('serviceKey', $value);
    }

    /**
     * Get the stored merchant ID
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set the stored merchant ID
     *
     * @param string $value Merchant ID to store
     * @return Gateway
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the stored client key
     *
     * @return string
     */
    public function getClientKey()
    {
        return $this->getParameter('clientKey');
    }

    /**
     * Set the stored client key
     *
     * @param string $value Client key to store
     * @return Gateway
     */
    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
    }

    /**
     * Create purchase request
     *
     * @param array $parameters
     *
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Create authorize request
     *
     * @param array $parameters
     *
     * @return AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    /**
     * Create refund request
     *
     * @param array $parameters
     *
     * @return RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * Create capture request
     *
     * @param array $parameters
     *
     * @return CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    protected function getDefaultHttpClient()
    {
        $guzzleClient = GuzzleClient::createWithConfig([
            'curl.options' => [
                CURLOPT_SSLVERSION => 6
            ]
        ]);


        return new Client($guzzleClient);
    }
}
