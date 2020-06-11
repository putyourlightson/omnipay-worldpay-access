<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * Worldpay Access Abstract Request
 */
abstract class AbstractRequest extends CommonAbstractRequest
{
    /**
     * @var string  API endpoint base to connect to
     */
    protected $endpoint = 'https://access.worldpay.com/';

    /**
     * Method required to override for getting the specific request endpoint
     *
     * @return string
     */
    abstract public function getEndpoint();

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
        return $this->getParameter('merchantId');
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
     * Make the actual request to Worldpay
     *
     * @param mixed $data  The data to encode and send to the API endpoint
     * @return ResponseInterface HTTP response object
     */
    public function sendRequest($data)
    {
        $authorization = 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword());

        return $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Authorization' => $authorization,
                'Content-Type' => 'application/vnd.worldpay.payments-v6+json',
                'Accept' => 'application/json',
            ],
            json_encode($data)
        );
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return Response::class;
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
}
