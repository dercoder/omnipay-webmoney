<?php

namespace Omnipay\WebMoney\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * WebMoney Fetch Transactions Response
 * http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X18.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class FetchTransactionResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, \SimpleXMLElement $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return $this->getCode() === 0;
    }

    public function getCode()
    {
        return (int) $this->data->retval;
    }

    public function getMessage()
    {
        $message = (string) $this->data->retdesc;

        return $message ? $message : null;
    }

    public function getTransactionReference()
    {
        return $this->data->operation ? (string) $this->data->operation->attributes()->wmtransid : null;
    }

    public function getDescription()
    {
        return $this->data->operation ? (string) $this->data->operation->purpose : null;
    }

    public function getAmount()
    {
        return $this->data->operation ? (string) $this->data->operation->amount : null;
    }

    public function getClientIp()
    {
        return $this->data->operation ? (string) $this->data->operation->IPAddress : null;
    }
}
