<?php

namespace Omnipay\WebMoney\Message;

/**
 * WebMoney Abstract Request.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://w3s.wmtransfer.com/asp/XMLTransCert.asp';

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
     * Get the return method.
     *
     * @return string return method
     */
    public function getReturnMethod()
    {
        return $this->formatMethod($this->getParameter('returnMethod'));
    }

    /**
     * Set the return method.
     *
     * @param string $value return method
     *
     * @return self
     */
    public function setReturnMethod($value)
    {
        return $this->setParameter('returnMethod', $value);
    }

    /**
     * Get the cancel method.
     *
     * @return string cancel method
     */
    public function getCancelMethod()
    {
        return $this->formatMethod($this->getParameter('cancelMethod'));
    }

    /**
     * Set the cancel method.
     *
     * @param string $value cancel method
     *
     * @return self
     */
    public function setCancelMethod($value)
    {
        return $this->setParameter('cancelMethod', $value);
    }

    /**
     * Redirect method conversion table.
     */
    private static $methodsTable = array(
        '1'     => '1',
        '2'     => '2',
        'GET'   => '0',
        'POST'  => '1',
        'LINK'  => '2',
    );

    /**
     * Converts redirect method to WebMoney code: 0, 1 or 2.
     *
     * @param string $method
     *
     * @return string
     */
    public function formatMethod($method)
    {
        $method = strtoupper((string)$method);
        return isset(self::$methodsTable[$method]) ? self::$methodsTable[$method] : '0';
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
     * Detect currency by purse.
     *
     * @param string $purse
     *
     * @return null|string
     */
    public function getCurrencyByPurse($purse)
    {
        switch (substr($purse, 0, 1)) {
            case 'Z':
                return 'USD';
            case 'R':
                return 'RUB';
            case 'E':
                return 'EUR';
            case 'U':
                return 'UAH';
            case 'K':
                return 'KZT';
            case 'Y':
                return 'UZS';
            case 'B':
                return 'BYR';
            case 'X':
                return 'BTC';
            default:
                return;
        }
    }
}
