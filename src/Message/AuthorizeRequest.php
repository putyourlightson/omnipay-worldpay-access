<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace Omnipay\WorldpayAccess\Message;

/**
 * Worldpay Access Authorize Request
 *
 * @link https://developer.worldpay.com/docs/access-worldpay/payments/authorize-a-payment#authorize-a-payment
 */
class AuthorizeRequest extends Request
{
    /**
     * Set up the base data for an authorize request
     *
     * @return mixed[]
     */
    public function getData()
    {
        $this->validate('amount');

        $card = $this->getCard();

        $data = array(
            'transactionReference' => $this->getTransactionReference(),
            'merchant' => array(
                'entity' => 'Solutions'
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
            // TODO: verify the values below
//            'customer' => array(
//                'authentication' => array(
//                    'eci' => '',
//                    'type' => 'ECOM',
//                    'transactionId' => $this->getTransactionId(),
//                ),
//            ),
        );

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().'/payments/authorizations';
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return AuthorizeResponse::class;
    }
}
