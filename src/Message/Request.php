<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

use Omnipay\Common\Message\AbstractRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * Worldpay Access Abstract Request
 */
abstract class Request extends AbstractRequest
{
    /**
     * @var string Live API endpoint base to connect to
     */
    protected $liveEndpoint = 'https://try.access.worldpay.com';//'https://access.worldpay.com';

    /**
     * @var string Test API endpoint base to connect to
     */
    protected $testEndpoint = 'https://try.access.worldpay.com';

    /**
     * Get the specific request endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * The HTTP method used to send data to the API endpoint
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
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
    public function getAuthorizeResponse()
    {
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
     * Get the stored authorize response links
     *
     * @param array $parameters
     * @return array
     */
    public function getAuthorizeResponseLinks()
    {
        $data = $this->getAuthorizeResponse()->getData();

        return $data['_links'] ?? [];
    }

    /**
     * Get the stored purchase response links
     *
     * @return mixed
     */
    public function getPurchaseResponseLinks()
    {
        return $this->getParameter('purchaseResponse');
    }

    /**
     * Set the stored purchase response links
     *
     * @param mixed $value
     * @return $this
     */
    public function setPurchaseResponseLinks($value)
    {
        return $this->setParameter('purchaseResponse', $value);
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return Response::class;
    }

    /**
     * Set up the base data for a request
     *
     * @return mixed
     */
    public function getData()
    {
        return null;
    }

    /**
     * Send the request to the API then build the response object
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     *
     * @return Response
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);

        $responseClass = $this->getResponseClassName();

        return $this->response = new $responseClass($this, $httpResponse);
    }

    /**
     * Make the actual request to Worldpay
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     * @return ResponseInterface HTTP response object
     */
    public function sendRequest($data)
    {
        $credentials = $this->getUsername() . ':' . $this->getPassword();

        $data = empty($data) ? null : json_encode($data);

        return $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Authorization' => 'Basic ' . base64_encode($credentials),
                'Content-Type' => 'application/vnd.worldpay.payments-v6+json',
                'Accept' => 'application/json',
            ],
            $data
        );
    }
}
