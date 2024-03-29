<?php

namespace Omnipay\WebMoney\Message;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\CurlException;
use Omnipay\Tests\TestCase;
use ReflectionObject;
use SimpleXMLElement;

class PayoutRequestTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        parent::setUp();

        $class = new ReflectionObject($this);
        $directory = dirname($class->getFileName());
        $sslFile = realpath($directory . '/../Certificate/webmoney.pem');
        $sslKey = realpath($directory . '/../Certificate/webmoney.key');

        $mockPlugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockPlugin->addResponse(__DIR__ . '/../Mock/PayoutSuccess.txt');

        $httpClient = new Client();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = $this->getMockBuilder(PayoutRequest::class)
            ->onlyMethods(['getHttpClient'])
            ->setConstructorArgs([$this->getHttpClient(), $this->getHttpRequest()])
            ->getMock();

        $this->request->method('getHttpClient')->willReturn($httpClient);
        $this->request->initialize([
                'webMoneyId'       => '811333344777',
                'merchantPurse'    => 'Z123428476799',
                'secretKey'        => '226778888',
                'sslFile'          => $sslFile,
                'sslKey'           => $sslKey,
                'transactionId'    => '1444111666',
                'requestNumber'    => '111222333',
                'customerPurse'    => 'Z123428476700',
                'protectionPeriod' => '60',
                'protectionCode'   => 'xyZ123',
                'invoiceId'        => '12345678',
                'onlyAuth'         => false,
                'description'      => 'Payout',
                'currency'         => 'USD',
                'amount'           => '12.46',
            ]
        );
    }

    public function testException()
    {
        $this->request->setCurrency('EUR');

        try {
            $this->request->getData();
        } catch (\Exception $e) {
            $this->assertInstanceOf(\Omnipay\Common\Exception\InvalidRequestException::class, $e);
        }
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $request = new SimpleXMLElement($data);

        $this->assertSame('111222333', (string)$request->reqn);
        $this->assertSame('', (string)$request->wmid);
        $this->assertSame('', (string)$request->sign);
        $this->assertSame('1444111666', (string)$request->trans->tranid);
        $this->assertSame('Z123428476799', (string)$request->trans->pursesrc);
        $this->assertSame('Z123428476700', (string)$request->trans->pursedest);
        $this->assertSame('12.46', (string)$request->trans->amount);
        $this->assertSame('60', (string)$request->trans->period);
        $this->assertSame('xyZ123', (string)$request->trans->pcode);
        $this->assertSame('Payout', (string)$request->trans->desc);
        $this->assertSame('12345678', (string)$request->trans->wminvid);
        $this->assertSame('0', (string)$request->trans->onlyauth);
    }
}
