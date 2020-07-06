<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

use HttpResponse;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Worldpay Access Response
 */
class Response extends AbstractResponse
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var HttpResponse  HTTP response object
     */
    public $response;

    /**
     * Override the constructor so we can store the response
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(RequestInterface $request, $response)
    {
        $this->response = $response;
        parent::__construct($request, json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Is the response successful?
     *
     * Based on HTTP status code, as some requests have an empty body (no data) but are still a success.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $code = $this->response->getStatusCode();

        return ($code == 201 || $code == 202);
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->data['message'] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getCode()
    {
        return $this->data['issuer']['authorizationCode'] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        if ($this->isSuccessful()) {
            return $this->request->getTransactionReference();
        }

        return null;
    }
}
