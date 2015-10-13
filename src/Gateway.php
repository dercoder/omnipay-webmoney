<?php

namespace Omnipay\WebMoney;

use Omnipay\Common\AbstractGateway;

/**
 * WebMoney Gateway.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'WebMoney';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return array(
            'webMoneyId' => '',
            'merchantPurse' => '',
            'secretKey' => '',
            'sslFile' => '',
            'sslKey' => '',
            'testMode' => false,
        );
    }

    /**
     * Get the WebMoney Id.
     *
     * The WMID that owns the purse that the lmi_payment_no payment was sent to via the merchant.webmoney.ru service or
     * the WMID that signed the request if the WMSigner authentication method was used. If this WMID is not the owner
     * of the purse that received the payment, there must be a trust issued for generating payment requests on behalf
     * of this identifier.
     *
     * @return string webmoney id
     */
    public function getWebMoneyId()
    {
        return $this->getParameter('webMoneyId');
    }

    /**
     * Set the WebMoney Id.
     *
     * The WMID that owns the purse that the lmi_payment_no payment was sent to via the merchant.webmoney.ru service or
     * the WMID that signed the request if the WMSigner authentication method was used. If this WMID is not the owner
     * of the purse that received the payment, there must be a trust issued for generating payment requests on behalf
     * of this identifier.
     *
     * @param string $value webmoney id
     *
     * @return self
     */
    public function setWebMoneyId($value)
    {
        return $this->setParameter('webMoneyId', $value);
    }

    /**
     * Get the merchant purse.
     *
     * The merchant's purse to which the customer has to pay. Format is a letter and twelve digits.
     * Presently, Z, R, E, U and D purses are used in the service.
     *
     * @return string merchant purse
     */
    public function getMerchantPurse()
    {
        return $this->getParameter('merchantPurse');
    }

    /**
     * Set the merchant purse.
     *
     * The merchant's purse to which the customer has to pay. Format is a letter and twelve digits.
     * Presently, Z, R, E, U and D purses are used in the service.
     *
     * @param string $value merchant purse
     *
     * @return self
     */
    public function setMerchantPurse($value)
    {
        return $this->setParameter('merchantPurse', $value);
    }

    /**
     * Get the secret key.
     *
     * This parameter passes the value of the secret key specified in the lmi_payee_purse settings in the
     * merchant.wmtransfer.com service. Keep in mind that when using this method, https connection authentication
     * checking (validity and ownership of the root certificate of https://merchant.wmtransfer.com, etc) will be your
     * responsibility to avoid DNS substitution and the like. If you use this method for authenticating the request,
     * sign, sha256 and md5 parameters must be left empty or omitted.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set the secret key.
     *
     * This parameter passes the value of the secret key specified in the lmi_payee_purse settings in the
     * merchant.wmtransfer.com service. Keep in mind that when using this method, https connection authentication
     * checking (validity and ownership of the root certificate of https://merchant.wmtransfer.com, etc) will be your
     * responsibility to avoid DNS substitution and the like. If you use this method for authenticating the request,
     * sign, sha256 and md5 parameters must be left empty or omitted.
     *
     * @param string $value secret key
     *
     * @return self
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * Get the SSL file.
     *
     * This certificate will be used for the payout request.
     * Certificate format must be .pem
     *
     * @return string ssl file
     */
    public function getSslFile()
    {
        return $this->getParameter('sslFile');
    }

    /**
     * Set the SSL file.
     *
     * This certificate will be used for the payout request.
     * Certificate format must be .pem
     *
     * @param string $value ssl file
     *
     * @return self
     */
    public function setSslFile($value)
    {
        return $this->setParameter('sslFile', $value);
    }

    /**
     * Get the SSL key.
     *
     * @return string ssl key
     */
    public function getSslKey()
    {
        return $this->getParameter('sslKey');
    }

    /**
     * Set the SSL key.
     *
     * @param string $value ssl key
     *
     * @return self
     */
    public function setSslKey($value)
    {
        return $this->setParameter('sslKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\WebMoney\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WebMoney\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\WebMoney\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WebMoney\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\WebMoney\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WebMoney\Message\FetchTransactionRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\WebMoney\Message\FetchTransactionRequest
     */
    public function payout(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WebMoney\Message\PayoutRequest', $parameters);
    }
}
