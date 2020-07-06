<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess;

use Http\Adapter\Guzzle6\Client as GuzzleClient;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Http\Client;
use Omnipay\WorldpayAccess\Message\AuthorizeRequest;
use Omnipay\WorldpayAccess\Message\AuthorizeResponse;
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
            'username' => '',
            'password' => '',
            'checkoutId' => '',
        );
    }

    /**
     * Get the stored username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set the stored username
     *
     * @param string $value
     * @return $this
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Get the stored password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set the stored password
     *
     * @param string $value
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Get the stored checkout ID
     *
     * @return string
     */
    public function getCheckoutId()
    {
        return $this->getParameter('checkoutId');
    }

    /**
     * Set the stored checkout ID
     *
     * @param string $value
     * @return $this
     */
    public function setCheckoutId($value)
    {
        return $this->setParameter('checkoutId', $value);
    }

    /**
     * Get the stored authorize response
     *
     * @param array $parameters
     * @return AuthorizeResponse
     */
    public function getAuthorizeResponse(array $parameters = array())
    {
        if (empty($this->getParameter('authorizeResponse'))) {
            /** @var AuthorizeResponse $authorizeResponse */
            $authorizeResponse = $this->authorize($parameters)->send();

            $this->setAuthorizeResponse($authorizeResponse);
        }

        return $this->getParameter('authorizeResponse');
    }

    /**
     * Set the stored authorize response
     *
     * @param AuthorizeResponse $value
     * @return $this
     */
    public function setAuthorizeResponse($value)
    {
        return $this->setParameter('authorizeResponse', $value);
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

    /**
     * Create purchase request
     *
     * @param array $parameters
     *
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        $this->getAuthorizeResponse($parameters);

        return $this->createRequest(PurchaseRequest::class, $parameters);
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
