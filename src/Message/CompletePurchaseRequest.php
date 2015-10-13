<?php

namespace Omnipay\WebMoney\Message;

/**
 * WebMoney Complete Purchase Request
 * https://merchant.wmtransfer.com/conf/guide.asp.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * Get the data for this request.
     *
     * @return array request data
     */
    public function getData()
    {
        $this->validate(
            'secretKey'
        );

        return array(
            'LMI_PAYEE_PURSE' => $this->httpRequest->request->get('LMI_PAYEE_PURSE'),
            'LMI_PAYMENT_AMOUNT' => $this->httpRequest->request->get('LMI_PAYMENT_AMOUNT'),
            'LMI_PAYMENT_NO' => $this->httpRequest->request->get('LMI_PAYMENT_NO'),
            'LMI_MODE' => $this->httpRequest->request->get('LMI_MODE'),
            'LMI_SYS_INVS_NO' => $this->httpRequest->request->get('LMI_SYS_INVS_NO'),
            'LMI_SYS_TRANS_NO' => $this->httpRequest->request->get('LMI_SYS_TRANS_NO'),
            'LMI_PAYER_PURSE' => $this->httpRequest->request->get('LMI_PAYER_PURSE'),
            'LMI_PAYER_WM' => $this->httpRequest->request->get('LMI_PAYER_WM'),
            'LMI_CAPITALLER_WMID' => $this->httpRequest->request->get('LMI_CAPITALLER_WMID'),
            'LMI_PAYMER_NUMBER' => $this->httpRequest->request->get('LMI_PAYMER_NUMBER'),
            'LMI_PAYMER_EMAIL' => $this->httpRequest->request->get('LMI_PAYMER_EMAIL'),
            'LMI_EURONOTE_NUMBER' => $this->httpRequest->request->get('LMI_EURONOTE_NUMBER'),
            'LMI_EURONOTE_EMAIL' => $this->httpRequest->request->get('LMI_EURONOTE_EMAIL'),
            'LMI_WMCHECK_NUMBER' => $this->httpRequest->request->get('LMI_WMCHECK_NUMBER'),
            'LMI_TELEPAT_PHONENUMBER' => $this->httpRequest->request->get('LMI_TELEPAT_PHONENUMBER'),
            'LMI_TELEPAT_ORDERID' => $this->httpRequest->request->get('LMI_TELEPAT_ORDERID'),
            'LMI_PAYMENT_CREDITDAYS' => $this->httpRequest->request->get('LMI_PAYMENT_CREDITDAYS'),
            'LMI_HASH' => $this->httpRequest->request->get('LMI_HASH'),
            'LMI_SYS_TRANS_DATE' => $this->httpRequest->request->get('LMI_SYS_TRANS_DATE'),
            'LMI_SECRET_KEY' => $this->httpRequest->request->get('LMI_SECRET_KEY'),
            'LMI_SDP_TYPE' => $this->httpRequest->request->get('LMI_SDP_TYPE'),
            'LMI_PAYMENT_DESC' => $this->httpRequest->request->get('LMI_PAYMENT_DESC'),
            'LMI_PAYER_COUNTRYID' => $this->httpRequest->request->get('LMI_PAYER_COUNTRYID'),
            'LMI_PAYER_PCOUNTRYID' => $this->httpRequest->request->get('LMI_PAYER_PCOUNTRYID'),
            'LMI_PAYER_IP' => $this->httpRequest->request->get('LMI_PAYER_IP'),
            'LMI_LANG' => $this->httpRequest->request->get('LMI_LANG'),
            'LMI_DBLCHK' => $this->httpRequest->request->get('LMI_DBLCHK'),
        );
    }

    /**
     * Send the request with specified data.
     *
     * @param mixed $data The data to send
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
