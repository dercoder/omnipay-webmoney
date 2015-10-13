<?php

namespace Omnipay\WebMoney\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * WebMoney Payout Request
 * http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X2.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class PayoutRequest extends AbstractRequest
{
    protected $endpoint = 'https://w3s.wmtransfer.com/asp/XMLTransCert.asp';

    /**
     * Get the customer purse.
     *
     * Format is a letter and twelve digits.
     * Presently, Z, R, E, U and D purses are used in the service.
     *
     * @return string customer purse
     */
    public function getCustomerPurse()
    {
        return $this->getParameter('customerPurse');
    }

    /**
     * Set the customer purse.
     *
     * Format is a letter and twelve digits.
     * Presently, Z, R, E, U and D purses are used in the service.
     *
     * @param string $value customer purse
     *
     * @return self
     */
    public function setCustomerPurse($value)
    {
        return $this->setParameter('customerPurse', $value);
    }

    /**
     * Get the request number.
     *
     * A positive integer of 15 digits maximally; must be greater than a previous payment request number!!!
     * Each WMID that signs the request is linked to its` unique sequence of monotonically increasing values of this
     * parameter.
     *
     * @return int request number
     */
    public function getRequestNumber()
    {
        $requestNumber = $this->getParameter('requestNumber');

        return $requestNumber ? $requestNumber : (string) time();
    }

    /**
     * Set the request number.
     *
     * A positive integer of 15 digits maximally; must be greater than a previous payment request number!!!
     * Each WMID that signs the request is linked to its` unique sequence of monotonically increasing values of this
     * parameter.
     *
     * @param int $value request number
     *
     * @return self
     */
    public function setRequestNumber($value)
    {
        return $this->setParameter('requestNumber', $value);
    }

    /**
     * Get the protection period.
     *
     * Maximum protection period allowed in days; An integer in the range 0 - 120;
     * 0 - means that no protection will be used.
     *
     * @return int protection period
     */
    public function getProtectionPeriod()
    {
        return (int) $this->getParameter('protectionPeriod');
    }

    /**
     * Set the protection period.
     *
     * Maximum protection period allowed in days; An integer in the range 0 - 120;
     * 0 - means that no protection will be used.
     *
     * @param int $value protection period
     *
     * @return self
     */
    public function setProtectionPeriod($value)
    {
        return $this->setParameter('protectionPeriod', $value);
    }

    /**
     * Get the protection code.
     *
     * Arbitrary string of 0 to 255 characters.
     * No spaces may be used at the beginning or the end.
     *
     * @return string protection code
     */
    public function getProtectionCode()
    {
        return trim($this->getParameter('protectionCode'));
    }

    /**
     * Set the protection code.
     *
     * Arbitrary string of 0 to 255 characters.
     * No spaces may be used at the beginning or the end.
     *
     * @param string $value protection code
     *
     * @return self
     */
    public function setProtectionCode($value)
    {
        return $this->setParameter('protectionCode', $value);
    }

    /**
     * Get the invoice Id.
     *
     * An integer > 0; 0 means that the transfer is made without an invoice.
     * Maximum is 2 32 -1.
     *
     * @return int protection code
     */
    public function getInvoiceId()
    {
        return (int) $this->getParameter('invoiceId');
    }

    /**
     * Set the invoice Id.
     *
     * An integer > 0; 0 means that the transfer is made without an invoice.
     * Maximum is 2 32 -1.
     *
     * @param int $value invoice Id
     *
     * @return self
     */
    public function setInvoiceId($value)
    {
        return $this->setParameter('invoiceId', $value);
    }

    /**
     * Get the only auth.
     *
     * obligatorily! 1 – the transfer will be made only if the recipient allows the transfer
     * (otherwise the returned code will be - 35). The recepient can prohibit accepting payments in two cases.
     * The first is when the sender is an authorized correspondent for the recepient for whom the latter had prohibited
     * the possibility of making payments to his purses ('restrictions' section in the correspondent's properties).
     * The second is when the sender isn't an authorized correspondent for the recepient, and the latter had prohibited
     * the possibility of making payments to his purses for all unauthorized members.
     *
     * @return int only auth
     */
    public function getOnlyAuth()
    {
        return (int) $this->getParameter('onlyAuth');
    }

    /**
     * Set the only auth.
     *
     * obligatorily! 1 – the transfer will be made only if the recipient allows the transfer
     * (otherwise the returned code will be - 35). The recepient can prohibit accepting payments in two cases.
     * The first is when the sender is an authorized correspondent for the recepient for whom the latter had prohibited
     * the possibility of making payments to his purses ('restrictions' section in the correspondent's properties).
     * The second is when the sender isn't an authorized correspondent for the recepient, and the latter had prohibited
     * the possibility of making payments to his purses for all unauthorized members.
     *
     * @param int $value only auth
     *
     * @return self
     */
    public function setOnlyAuth($value)
    {
        return $this->setParameter('onlyAuth', $value);
    }

    public function getData()
    {
        $this->validate(
            'merchantPurse',
            'customerPurse',
            'sslFile',
            'sslKey',
            'transactionId',
            'description',
            'currency',
            'amount'
        );

        if ($this->getCurrencyByPurse($this->getMerchantPurse()) !== $this->getCurrency()) {
            throw new InvalidRequestException('Invalid currency for this merchant purse');
        }

        $document = new \DOMDocument('1.0', 'utf-8');
        $document->formatOutput = false;

        $request = $document->appendChild(
            $document->createElement('w3s.request')
        );

        $request->appendChild(
            $document->createElement('reqn', $this->getRequestNumber())
        );

        $request->appendChild(
            $document->createElement('wmid', '')
        );

        $request->appendChild(
            $document->createElement('sign', '')
        );

        $trans = $request->appendChild(
            $document->createElement('trans')
        );

        $trans->appendChild(
            $document->createElement('tranid', $this->getTransactionId())
        );

        $trans->appendChild(
            $document->createElement('pursesrc', $this->getMerchantPurse())
        );

        $trans->appendChild(
            $document->createElement('pursedest', $this->getCustomerPurse())
        );

        $trans->appendChild(
            $document->createElement('amount', $this->getAmount())
        );

        $trans->appendChild(
            $document->createElement('period', $this->getProtectionPeriod())
        );

        $trans->appendChild(
            $document->createElement('pcode', $this->getProtectionCode())
        );

        $trans->appendChild(
            $document->createElement('desc', $this->getDescription())
        );

        $trans->appendChild(
            $document->createElement('wminvid', $this->getInvoiceId())
        );

        $trans->appendChild(
            $document->createElement('onlyauth', $this->getOnlyAuth())
        );

        return $document->saveXML();
    }

    public function sendData($data)
    {
        $this->httpClient->setConfig(array(
            'curl.options' => array(
                CURLOPT_CAINFO => $this->getCertificatePath('WMUsedRootCAs.crt'),
                CURLOPT_SSLCERT => $this->getSslFile(),
                CURLOPT_SSLKEY => $this->getSslKey(),
                CURLOPT_SSLVERSION => 1,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => 1,
            ),
        ));

        $httpResponse = $this->httpClient->post($this->endpoint, null, $data)->send();

        return $this->createResponse($httpResponse->xml());
    }

    protected function createResponse($data)
    {
        return $this->response = new PayoutResponse($this, $data);
    }

    protected function getCertificatePath($fileName)
    {
        $class = new \ReflectionObject($this);
        $directory = dirname($class->getFileName());
        $file = realpath($directory.'/../Certificate/'.$fileName);

        return $file;
    }
}
