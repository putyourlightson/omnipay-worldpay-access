<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Set up the base data for a purchase request
     *
     * @link https://developer.worldpay.com/interactive-references/access-worldpay/payments/authorizations
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount', 'token');

        $card = $this->getCard();

        $data = array(
            'transactionReference' => $this->getTransactionReference(),
            'merchant' => array(
                'entity' => 'an-entity'
            ),
            'instruction' => array(
                'narrative' => array(
                    'line1' => 'trading name'
                ),
                'value' => array(
                    'currency' => $this->getCurrency(),
                    'amount' => $this->getAmountInteger(),
                ),
                'paymentInstrument' => array(
                    'cvc' => $card->getCvv(),
                    'cardHolderName' => $card->getName(),
                    'billingAddress' => array(
                        'address1' => $card->getBillingAddress1(),
                        'address2' => $card->getBillingAddress2(),
                        'city' => $card->getBillingCity(),
                        'state' => $card->getBillingState(),
                        'postalCode' => $card->getBillingPostcode(),
                        'countryCode' => $card->getBillingCountry(),
                    ),
                    'type' => 'card/plain',
                    'cardNumber' => $card->getNumber(),
                    'cardExpiryDate' => array(
                        'month' => $card->getExpiryMonth(),
                        'year' => $card->getExpiryYear(),
                    ),
                ),
            ),
            'customer' => array(
                'authentication' => array(
                    // TODO: verify the values below
                    'eci' => '',
                    'type' => 'ECOM',
                    'transactionId' => $this->getTransactionId(),
                ),
            ),
        );

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint.'/payments/authorizations';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return PurchaseResponse::class;
    }
}
